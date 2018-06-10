<?php
require_once('check_user_session.php');
require_once('../ADMIN/config.php');
require_once('../UserService.class.php');

if (isset($_GET['id']) && !empty($_GET['id']) && intval($_GET['id']) > 0) {
  $user_id = intval($_GET['id']);
}

$userService = new UserService();
$userData = $userService->setUser($user_id);
?>

<!DOCTYPE html>
<html lang="en">
  <?php include_once('views/layout/partials/_head.php'); ?>
  <body>

    <?php include_once('views/layout/partials/_nav.php'); ?>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1>
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              Details of <small><?php echo $userService->user->name; ?></small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

              <?php include_once('user/views/bank-accounts.php'); ?>

              <?php include_once('user/views/bank-transactions.php'); ?>

              <?php include_once('user/views/mobile-recharge-transactions.php'); ?>

          </div>
        </div>
      </div>
    </section>

    <?php
        $connect->close();
        include_once('views/layout/partials/_footer.php');
        include_once('views/layout/partials/_scripts.php');
    ?>

  </body>
</html>
