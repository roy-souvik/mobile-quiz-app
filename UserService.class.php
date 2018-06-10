<?php
require_once(__DIR__ . '/ADMIN/user/user.model.php');

class UserService
{
    public $connection;
    public $userTable;
    public $userBankAccountTable;
    public $userBankTransactionsTable;
    public $mobileTransactionsTable;
    private $daysToRequestBankTransaction = 30;
    public $user;

    public function __construct($userId = null)
    {
        $this->userTable = 'tbl_user';
        $this->userBankAccountTable = 'tbl_user_bank_account';
        $this->userBankTransactionsTable = 'tbl_user_bank_transactions';
        $this->mobileTransactionsTable = 'tbl_transaction';
        $this->connection = $this->getDbConnection();

        if ($userId > 0) {
          if (!$this->isValidUser($userId)) {
            print_r(json_encode([
              'flag' => false,
              'message' => 'Not a valid user!'
            ]));
            die();
          }
        }
    }

    public function getDbConnection()
    {
      $host = "localhost";
      $dbname = "quiz_competition";
      $username = "root";
      $password = "password";
      // $username = "ntss";
      // $password = "eerning";

      $connect = new mysqli($host, $username, $password, $dbname);
      if ($connect->connect_error) {
          die("connection failed : " . $connect->connect_error);
      }

      return $connect;
    }

    public function setUser($userId)
    {
      $userData = $this->findUserById($userId);
      if (!empty($userData)) {
        $this->user = new User($userData);
      }
    }

    public function findUserById($userId)
    {
        $userId = intval($this->sanitizeVariable($userId));
        $sql = "SELECT * FROM `{$this->userTable}`
        WHERE `user_id` = {$userId} LIMIT 1";
        $query = $this->connection->query($sql);

        if ($query->num_rows > 0) {
            return $query->fetch_assoc();
        }

        return [];
    }

    public function isValidUser($userId)
    {
        $userdata = $this->findUserById($userId);

        if (!empty($userdata) && intval($userdata['user_id']) > 0) {
          $this->user = new User($userdata);

          return $this->user->isActive() && $this->user->isDeleted();
        }

        return false;
    }

    public function submitBankInformation($request)
    {
        if (! $this->validBankDetails($request)) {
          return [
            'flag' => false,
            'message' => 'Bank details are not valid.'
          ];
        }

        $userHasAccount = (int) $this->findBankDetailsByUserId($request['user_id'])['id'] > 0;

        if ($userHasAccount) {
          return [
            'flag' => false,
            'message' => 'User already has a bank account.'
          ];
        }

        // May not be needed
        if (! $this->validAccountNumber($request['account_number'])) {
          return [
            'flag' => false,
            'message' => 'This account number already exist in our records.'
          ];
        }

        $data = [
          'user_id' => $this->sanitizeVariable($request['user_id']),
          'owner_name' => $this->sanitizeVariable($request['owner_name']),
          'account_number' => $this->sanitizeVariable($request['account_number']),
          'ifsc' => $this->sanitizeVariable($request['ifsc']),
          'branch_address' => $this->sanitizeVariable($request['branch_address']),
        ];

        $accountId = $this->createBankAccount($data);
        if ($accountId > 0) {
          return [
            'flag' => true,
            'message' => 'Your bank information is successfully submitted.',
            'data'=> $this->findBankDetailById($accountId)
          ];
        }

        return [
          'flag' => false,
          'message' => 'Unable to create bank account.'
        ];
    }

    private function validBankDetails($request)
    {
        return !empty($request['user_id']) && intval($request['user_id']) > 0 &&
        !empty($request['owner_name']) &&
        !empty($request['account_number']) &&
        !empty($request['ifsc']) &&
        !empty($request['branch_address']);
    }

    private function validAccountNumber($accountNumber)
    {
        $accountNumber = $this->sanitizeVariable($accountNumber);
        $sql = "SELECT * FROM `{$this->userBankAccountTable}` WHERE `account_number`='" . $accountNumber . "'";
        $result = $this->connection->query($sql);

        return !$result->num_rows > 0;
    }

    public function sanitizeVariable($variable)
    {
        return mysqli_real_escape_string($this->connection, trim($variable));
    }

    private function createBankAccount($data)
    {
        $create_sql = "INSERT INTO `{$this->userBankAccountTable}` (
        `user_id`, `owner_name`, `account_number`, `ifsc`, `branch_address`)
        VALUES ({$data['user_id']}, '{$data['owner_name']}', '{$data['account_number']}', '{$data['ifsc']}', '{$data['branch_address']}')";

        return $this->connection->query($create_sql) ? $this->connection->insert_id : 0;
    }

    public function findBankDetailById($id)
    {
      $id = intval($this->sanitizeVariable($id));
      $sql = "SELECT * FROM `{$this->userBankAccountTable}` WHERE `id` = {$id} LIMIT 1";
      $query = $this->connection->query($sql);

      if ($query->num_rows > 0) {
          return $query->fetch_assoc();
      }

      return [];
    }

    public function findBankDetailsByUserId($userId)
    {
      $userId = intval($this->sanitizeVariable($userId));
      $sql = "SELECT * FROM `{$this->userBankAccountTable}` WHERE `user_id` = {$userId} LIMIT 1";
      $query = $this->connection->query($sql);

      if ($query->num_rows > 0) {
          return $query->fetch_assoc();
      }

      return [];
    }

    /**
     * Statuses: 0 -> No Bank Info; 1 -> Un-approved; 2 -> Approved
     * @param  int $userId [description]
     * @return array         [description]
     */
    public function checkBankStatus($userId)
    {
        $userId = intval($this->sanitizeVariable($userId));
        $sql = "SELECT * FROM `{$this->userBankAccountTable}` WHERE `user_id` = {$userId} LIMIT 1";
        $query = $this->connection->query($sql);

        if ($query->num_rows > 0) {
            $bankInfo = $query->fetch_assoc();
            return [
              'flag' => true,
              'status' => (int) $bankInfo['is_approved'],
              'message' => 'Bank details found.'
            ];
        }

        return [
          'flag' => true,
          'status' => 0,
          'message' => 'No bank details found.'
        ];
    }

    public function verifyBankInformation($request)
    {
      if (empty($request['user_id']) || empty($request['amount']) || empty($request['transaction_id'])) {
        return [
          'flag' => false,
          'message' => 'Inputs are not valid.'
        ];
      }

      $data = [
        'user_id' => intval($this->sanitizeVariable($request['user_id'])),
        'amount' => intval($this->sanitizeVariable($request['amount'])),
        'transaction_id' => $this->sanitizeVariable($request['transaction_id']),
      ];

      $bankAccount = $this->findBankDetailsByUserId($data['user_id']);

      if (empty($bankAccount['id'])) {
        return [
          'flag' => false,
          'message' => 'Bank account does not exists.'
        ];
      }

      if (intval($bankAccount['is_approved']) === 2) {
        return [
          'flag' => true,
          'message' => 'Your account is already verified. You may apply for payment.'
        ];
      }

      $approvedstatus = 2;
      $updated_at = date('Y-m-d H:i:s');

      $updateAccountSql = "UPDATE `{$this->userBankAccountTable}`
      SET
      `is_approved`= {$approvedstatus},
      `verified_transaction_id`= '{$data['transaction_id']}',
      `verified_amount`= '{$data['amount']}',
      `updated_at`= '{$updated_at}'
      WHERE id = " . $bankAccount['id'];

      if ($this->connection->query($updateAccountSql)) {
        return [
          'flag' => true,
          'message' => 'Successfully verified your bank information. You may now apply for payments.'
        ];
      }

      return [
        'flag' => false,
        'message' => 'There is some internal error. Please try again later.'
      ];
    }

    /**
     * Transaction Status Codes: 0 -> in-progress, 1 -> done
     * @param  array $request
     * @return array
     */
    public function applyForBankPayment($request)
    {
      if (empty($request['user_id']) || empty($request['amount'])) {
        return [
          'flag' => false,
          'message' => 'Inputs are not valid.'
        ];
      }

      $data = [
        'user_id' => intval($this->sanitizeVariable($request['user_id'])),
        'amount' => intval($this->sanitizeVariable($request['amount']))
      ];

      if (! $this->isRequestedAfterSpecificDays(intval($data['user_id']))) {
        return [
          'flag' => false,
          'message' => 'You can request only once within ' . $this->daysToRequestBankTransaction . ' days.'
        ];
      }

      $insertSql = "INSERT INTO `{$this->userBankTransactionsTable}`
      (`user_id`, `request_amount`)
      VALUES ({$data['user_id']},{$data['amount']})";

      $this->connection->query($insertSql);

      if ($this->connection->insert_id > 0) {
        return [
          'flag' => true,
          'message' => 'Your request is accepted. The payment will be done within 15 working days. Thank you.'
        ];
      }

      return [
        'flag' => false,
        'message' => 'There is some internal error. Please try again later.'
      ];
    }

    private function isRequestedAfterSpecificDays($userId)
    {
        $sql = "SELECT * FROM `{$this->userBankTransactionsTable}`
        WHERE `user_id` = {$userId} ORDER BY id DESC LIMIT 1";

        $query = $this->connection->query($sql);
        $numRows = $query->num_rows;

        if ($numRows == 0) {
            return true;
        }

        if ($numRows > 0) {
            $data = $query->fetch_assoc();
            $daysDifference = $this->getDays($data['request_date'], date('Y-m-d H:i:s'));

            return $daysDifference > $this->daysToRequestBankTransaction;
        }

        return false;
    }

    public function getDays($startDate, $endDate)
    {
        $date1 = date_create($startDate);
        $date2 = date_create($endDate);

        // difference between two dates
        $diff = date_diff($date1, $date2);

        return $diff->format("%a");
    }

    public function convertDateToTimestamp($format = 'Y-m-d H:i:s', $date)
    {
        return DateTime::createFromFormat($format, $date)->getTimestamp();
    }

    public function getAllUsers()
    {
      $sql = "SELECT * FROM `{$this->userTable}` WHERE 1 order by user_id DESC";
      $query = $this->connection->query($sql);
      $users = [];
      while($userData = $query->fetch_assoc()) {
        $user = new User($userData);
        $users[] = $user;
      }

      return $users;
    }

    public function getBankDetails($userId = null)
    {
      $userId = is_null($userId) ? $this->user->id : $userId;

      $sql = "SELECT * FROM `{$this->userBankAccountTable}`
      WHERE user_id=" . $userId . " ORDER BY id DESC LIMIT 1";

      $query = $this->connection->query($sql);

      if ($query->num_rows > 0) {
        return $query->fetch_assoc();
      }

      return [];
    }

    public function getBankTransactions($userId = null)
    {
        $userId = is_null($userId) ? $this->user->id : $userId;

        $sql = "SELECT * FROM `{$this->userBankTransactionsTable}`
        WHERE `user_id` = {$userId} ORDER BY id DESC";

        $query = $this->connection->query($sql);

        $transactions = [];
        while($transaction = $query->fetch_assoc()) {
          $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function getMobileTransactions($userId = null)
    {
        $userId = is_null($userId) ? $this->user->id : $userId;

        $sql = "SELECT * FROM `{$this->mobileTransactionsTable}`
        WHERE `user_id` = {$userId} AND `transaction_request` = 'recharge'
        ORDER BY transaction_id DESC";

        $query = $this->connection->query($sql);

        $transactions = [];
        while($transaction = $query->fetch_assoc()) {
          $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function getUsersWithBankTransactions()
    {
      $sql = "SELECT * FROM `{$this->userTable}` WHERE 1 order by user_id DESC";
      $query = $this->connection->query($sql);
      $users = [];
      while($userData = $query->fetch_assoc()) {
        $user = new User($userData);
        $users[] = $user;
      }

      return $users;
    }

    public function updateProfileInfo($request)
    {
        $data['user_id'] = intval($this->sanitizeVariable($request['user_id']));
        $data['promoter_id'] = $this->sanitizeVariable($request['promoter_id']);
        $data['user_name'] = $this->sanitizeVariable($request['user_name']);
        $data['user_email'] = $this->sanitizeVariable($request['user_email']);
        $data['user_social_no'] = $this->sanitizeVariable($request['user_social_no']);
        $data['user_phone_no'] = $this->sanitizeVariable($request['user_phone_no']);

        $paytmSql = "";
        if (!empty($request['user_paytm'])) {
            $data['user_paytm'] = $this->sanitizeVariable($request['user_paytm']);
            $paytmSql = " `user_paytm`= '{$data['user_paytm']}', ";
        }

        $imageSql = "";
        if (!empty($request['user_image'])) {
          $data['user_image'] = $this->sanitizeVariable($request['user_image']);
          $imageSql = " `user_image`= '{$data['user_image']}', ";
        }

        $sql = "UPDATE `{$this->userTable}`
        SET
        `promoter_id`= '{$data['promoter_id']}',
        `user_name`= '{$data['user_name']}',
        `user_email`= '{$data['user_email']}',
        `user_social_no`= '{$data['user_social_no']}', " .
         $paytmSql . $imageSql .
        "`user_phone_no`= '{$data['user_phone_no']}'
         WHERE user_id = " . $data['user_id'] . " LIMIT 1";

        if ($this->connection->query($sql)) {
          $this->setUser($data['user_id']);

          return [
            'flag' => true,
            'message' => 'Successfully Updated.',
            'user_details' => $this->user
          ];
        }

        return [
          'flag' => false,
          'message' => 'There is some internal error. Please try again later.'
        ];
    }

    public function getWalletStatus($userId)
    {
        $response = [];
        $bankDetails = $this->getBankDetails();

        $getScoresSql = "SELECT * FROM `tbl_user_scores` WHERE user_id = " . $userId;
        $query = $this->connection->query($getScoresSql);

        $totalScore = 0;
        $todaysScore = 0;
        $monthsScore = 0;
        while($score = $query->fetch_assoc()) {
          $watchedVideo = $score['score_category'] == 2;
          $answeredCorrectly = $score['score_category'] == 1 && $score['answer_matched'] == 1;
          $answeredWrongly = $score['score_category'] == 1 && $score['answer_matched'] == 0;
          $scoreDate = date ('Y-m-d', strtotime($score['created_at']));
          $scoredToday = date('Y-m-d') == $scoreDate;
          $scoreMonth = date ('m', strtotime($score['created_at']));
          $scoredInCurrentMonth = date('m') == $scoreMonth;

          if ($answeredCorrectly || $watchedVideo) {
            $totalScore+= $score['score'];
          }  else if ($answeredWrongly) {
            $totalScore-= $score['score'];
          }

          if (($scoredToday && $answeredCorrectly) || ($scoredToday && $watchedVideo)) {
            $todaysScore+= $score['score'];
          } else if ($scoredToday && $answeredWrongly) {
            $todaysScore-= $score['score'];
          }

          if (($scoredInCurrentMonth && $answeredCorrectly) || ($scoredInCurrentMonth && $watchedVideo)) {
            $monthsScore+= $score['score'];
          } else if ($scoredInCurrentMonth && $answeredWrongly) {
            $monthsScore-= $score['score'];
          }
        }

        return [
          'bank_status' => intval($bankDetails['is_approved']),
          'todays_score' => $todaysScore,
          'months_score' => $monthsScore,
          'total_score' => $totalScore
        ];
    }

}
