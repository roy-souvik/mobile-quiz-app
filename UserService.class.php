<?php
// date_default_timezone_set('America/New_York');

class UserService
{
    public $connection;
    public $userBankAccountTable;
    public $userBankTransactionsTable;
    private $daysToRequestBankTransaction = 30;

    public function __construct()
    {
        $this->userBankAccountTable = 'tbl_user_bank_account';
        $this->userBankTransactionsTable = 'tbl_user_bank_transactions';
        $this->connection = $this->getDbConnection();
    }

    public function getDbConnection()
    {
      $localhost = "localhost";
      $username = "root";
      $password = "password";
      $dbname = "quiz_competition";

      $connect = new mysqli($localhost, $username, $password, $dbname);
      if ($connect->connect_error) {
          die("connection failed : " . $connect->connect_error);
      }

      return $connect;
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
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
    public function checkBankstatus($userId)
    {
        $userId = intval($this->sanitizeVariable($userId));
        $sql = "SELECT * FROM `{$this->userBankAccountTable}` WHERE `user_id` = {$userId} LIMIT 1";
        $query = $this->connection->query($sql);

        if ($query->num_rows > 0) {
            $bankInfo = $query->fetch_assoc();
            return [
              'flag' => true,
              'status' => $bankInfo['is_approved']
            ];
        }

        return [
          'flag' => true,
          'status' => 0
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
          'message' => 'Successfully verified your bank information. Now you may apply for payment.'
        ];
      }

      return [
        'flag' => false,
        'message' => 'There is some internal error.'
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
        'message' => 'There is some internal error.'
      ];

    }

    private function isRequestedAfterSpecificDays($userId)
    {
        $sql = "SELECT * FROM `{$this->userBankTransactionsTable}`
        WHERE `user_id` = {$userId} AND `transaction_status` = 0
        ORDER BY id DESC
        LIMIT 1";

        $query = $this->connection->query($sql);

        if ($query->num_rows > 0) {
            $data = $query->fetch_assoc();

            return $this->getDays($data['request_date'], date('Y-m-d H:i:s')) > $this->daysToRequestBankTransaction;
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

}
