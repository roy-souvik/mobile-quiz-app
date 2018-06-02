<?php
  require_once('../php_action/db_connect.php');
  require_once('../ADMIN/user/user.model.php');

  if (isset($_GET['id']) && !empty($_GET['id']) && intval($_GET['id']) > 0) {
    $user_id = intval($_GET['id']);
  }

  $getUserSql = "SELECT * FROM tbl_user WHERE user_id=" . $user_id . " LIMIT 1";
  $getUserQuery = $connect->query($getUserSql);
  $userData = $getUserQuery->fetch_assoc();
  $user = new User($userData);

  $getAccountsSql = "SELECT * FROM tbl_user_bank_accounts WHERE user_id=" . $user->id . " ORDER BY id DESC";
  $getAccountsQuery = $connect->query($getAccountsSql);
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Bank Account(s) of <strong><?php echo $user->name;?></strong> </h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover">
        <tr>
          <th>Owner Name</th>
          <th>Account Number</th>
          <th>IFSC</th>
          <th>Branch Address</th>
          <th>Active</th>
          <th>Created On</th>
        </tr>

        <?php
            while($account = $getAccountsQuery->fetch_assoc()) {
        ?>
              <tr>
                <td> <?php echo $account['owner_name']; ?> </td>
                <td> <?php echo $account['account_number']; ?> </td>
                <td> <?php echo $account['ifsc']; ?> </td>
                <td> <?php echo $account['branch_address']; ?> </td>
                <td> <?php echo $account['is_active']; ?> </td>
                <td> <?php echo $account['created_at']; ?> </td>
              </tr>

        <?php } ?>

      </table>

    <?php $connect->close(); ?>
  </div>
</div>
