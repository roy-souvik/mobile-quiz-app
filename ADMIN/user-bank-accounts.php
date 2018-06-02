<!DOCTYPE html>
<html lang="en">
  <?php include_once('views/layout/partials/_head.php'); ?>
  <body>

    <?php include_once('views/layout/partials/_nav.php'); ?>

    <?php include_once('views/layout/partials/_header.php'); ?>

    <?php // include_once('views/layout/partials/_breadcrumb.php'); ?>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

              <?php include_once('user/views/bank-accounts.php'); ?>

          </div>
        </div>
      </div>
    </section>

    <?php
        include_once('views/layout/partials/_footer.php');
        include_once('views/layout/partials/_scripts.php');
    ?>

  </body>
</html>
