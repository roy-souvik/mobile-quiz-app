<?php
  require_once('../php_action/db_connect.php');
  require_once('../ADMIN/user/user.model.php');

  $sql = "SELECT * FROM tbl_user WHERE 1 order by user_id DESC";
  $query = $connect->query($sql);
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Latest Users</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Social No.</th>
          <th>Phone No.</th>
          <th>PayTm</th>
          <th>Points</th>
          <th>Last Question</th>
          <th>Is Active</th>
          <th>Accounts</th>
        </tr>

        <?php
            while($userData = $query->fetch_assoc()) {
              $user = new User($userData);
        ?>
              <tr>
                <td> <?php echo $user->name; ?> </td>
                <td> <?php echo $user->email; ?> </td>
                <td> <?php echo $user->social_no; ?> </td>
                <td> <?php echo $user->phone_no; ?> </td>
                <td> <?php echo $user->paytm; ?> </td>
                <td> <?php echo $user->point; ?> </td>
                <td> <?php echo $user->last_question; ?> </td>
                <td> <?php echo $user->active; ?> </td>
                <td>
                  <a href="<?php echo $_SERVER['REQUEST_URI']; ?>user-bank-accounts.php?id=<?php echo $user->id?>">View</a> 
                </td>
              </tr>

        <?php
              unset($user);
            }
        ?>

      </table>

    <?php $connect->close(); ?>
  </div>
</div>
