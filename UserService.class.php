<?php
date_default_timezone_set('America/New_York');

class UserService
{
    const USER_BANK_ACCOUNT_TABLE = 'tbl_user_bank_accounts';

    public function dbconnenct()
    {
      $pass = "eerning";
      $host = "localhost";
      $promoter = "ntss";
      $dbname = $_SERVER['HTTP_HOST'] == "localhost" ? "promoter_competition" : "quiz_competition";
      $conn = mysqli_connect($host, $promoter, $pass, $dbname) or die ("Error Connection: " . mysql_error());

      return $conn;
    }

    public function saveBankDetails($request)
    {
        $response = [];
        if (! $this->validBankDetails($request)) {
          return [
            'flag' => false,
            'message' => 'Bank details are not valid'
          ];
        }

        if (! $this->validAccountNumber($request['account_number'])) {
          return [
            'flag' => false,
            'message' => 'This account number already exist in our records'
          ];
        }

        $data = [
          'user_id' => $this->sanitizeVariable($request['user_id']),
          'owner_name' => $this->sanitizeVariable($request['owner_name']),
          'account_number' => $this->sanitizeVariable($request['account_number']),
          'ifsc' => $this->sanitizeVariable($request['ifsc']),
          'branch_address' => $this->sanitizeVariable($request['branch_address'])
        ];

        return $this->createBankAccount($data);
    }

    private function validBankDetails($request)
    {
      if (
        !empty($request['user_id']) &&
        !empty($request['owner_name']) &&
        !empty($request['account_number']) &&
        !empty($request['ifsc']) &&
        !empty($request['branch_address'])
      ) {
        return true;
      }

      return false;
    }

    private function validAccountNumber($accountNumber)
    {
      $accountNumber = $this->sanitizeVariable($accountNumber);
      $sql = "SELECT * FROM " . USER_BANK_ACCOUNT_TABLE . " WHERE `account_number`='" . $accountNumber . "'";
      $result = $conn->query($sql);

      return !$result->num_rows > 0;
    }

    public function sanitizeVariable($variable)
    {
      return mysqli_real_escape_string(trim($variable));
    }

    private function createBankAccount($data)
    {
        $create_sql = "INSERT INTO " . USER_BANK_ACCOUNT_TABLE . " (
        user_id, owner_name, account_number, ifsc, branch_address)
        VALUES ({$data['user_id']}, {$data['owner_name']}, {$data['account_number']}, {$data['ifsc']}, {$data['branch_address']})";

        $query = $connect->query($create_sql);

        return findBankDetailById(1);
    }

    public function findBankDetailById($id)
    {
      $id = intval($this->sanitizeVariable($id));
      $sql = "SELECT * FROM " . USER_BANK_ACCOUNT_TABLE . " WHERE id = {$id} LIMIT 1";
      $query = $conn->query($sql);

      if ($query->num_rows > 0) {
          return $query->fetch_assoc();
      }

      return [];
    }

}
