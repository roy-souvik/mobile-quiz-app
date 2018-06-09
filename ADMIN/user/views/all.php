<?php
  require_once('../ADMIN/config.php');
  require_once('../UserService.class.php');

  $userService = new UserService();
  $users = $userService->getAllUsers();
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">All Users</h3>
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
          <th>Details</th>
        </tr>

        <?php foreach ($users as $user) { ?>
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
              <a href="user-details.php?id=<?php echo $user->id?>">View</a>
            </td>
          </tr>

        <?php
              unset($user);
            }
          unset($userService);  
        ?>

      </table>

    <?php $connect->close(); ?>
  </div>
</div>
