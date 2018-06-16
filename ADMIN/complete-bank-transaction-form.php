<?php
require_once('check_user_session.php');
require_once('../ADMIN/config.php');
require_once('../UserService.class.php');

if (empty($_GET['id']) || empty($_GET['user_id'])) {
  die('Missing params');
}

if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $transactionId = intval($_GET['id']);
}

$userService = new UserService();
$currentTransaction = $userService->getBankTransactionById($transactionId);
$userService->setUser($currentTransaction['user_id']);

if (intval($currentTransaction['user_id']) !== intval($_GET['user_id'])) {
  die('No valid transactions found or the user has not done this transactions');
}

var_dump($currentTransaction);
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
              Pay money to <small><?php echo $userService->user->name; ?></small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <form class="form-horizontal" method="POST" action="/action_page.php">
              <div class="form-group">
                <label class="control-label col-sm-2" for="transaction_date">Transaction Date:</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="transaction_date" id="transaction_date" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="transaction_amount">Transaction Amount:</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="transaction_amount" id="transaction_amount" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="transaction_status">Transaction Status:</label>
                <div class="col-sm-10">

                  <select name="transaction_status" id="transaction_status" required>
                    <option value="">Select</option>
                    <option value="1">Complete</option>
                    <option value="2">Cancel</option>
                  </select>

                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2" for="comment">Comment:</label>
                <div class="col-sm-10">
                  <textarea name="comment" id="comment" rows="8" cols="80"></textarea>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Submit</button>
                </div>
              </div>
            </form>

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
