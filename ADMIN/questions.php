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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <body>

    <?php include_once('views/layout/partials/_nav.php'); ?>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1>
              <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
              Questions
            </h1>
          </div>

          <div class="col-md-3">
            <a href="create-question.php" class="pull-right" style="font-size: 1.5em; color: #ffffff; margin-top: 1.4em;">
              Add New Question
            </a>
          </div>

        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <table id="example" class="display nowrap" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <td>ID</td>
                        <td>EN QUEST:</td>
                      <td>OPTION - 1</td>
                      <td>OPTION - 2</td>
                      <td>OPTION - 3</td>
                      <td>OPTION - 3</td>
                      <td>ANSWER</td>
                        <td>বাংলাা প্রশ্ন</td>
                      <td>অপশন - 1</td>
                      <td>অপশন - 2</td>
                      <td>অপশন - 3</td>
                      <td>অপশন - 3</td>
                      <td>উত্তর</td>
                        <td>हिंदी सवाल</td>
                      <td>विकल्प - 1</td>
                      <td>विकल्प - 2</td>
                      <td>विकल्प - 3</td>
                      <td>विकल्प - 3</td>
                      <td>उत्तर</td>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM tbl_question";
                      $result = $connect->query($sql);

                      if($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                              echo "<tr>
                                  <td>".$row['qus_id']."</td>
                                  <td>".$row['qus_en_qustion']."</td>
                                  <td>".$row['qus_en_option_1']."</td>
                                  <td>".$row['qus_en_option_2']."</td>
                                  <td>".$row['qus_en_option_3']."</td>
                                  <td>".$row['qus_en_option_4']."</td>
                                  <td>".$row['qus_en_right_ans']."</td>

                                  <td>".$row['qus_bn_qustion']."</td>
                                  <td>".$row['qus_bn_option_1']."</td>
                                  <td>".$row['qus_bn_option_2']."</td>
                                  <td>".$row['qus_bn_option_3']."</td>
                                  <td>".$row['qus_bn_option_4']."</td>
                                  <td>".$row['qus_bn_right_ans']."</td>

                                  <td>".$row['qus_hn_qustion']."</td>
                                  <td>".$row['qus_hn_option_1']."</td>
                                  <td>".$row['qus_hn_option_2']."</td>
                                  <td>".$row['qus_hn_option_3']."</td>
                                  <td>".$row['qus_hn_option_4']."</td>
                                  <td>".$row['qus_hn_right_ans']."</td>
                              </tr>";
                          }
                      } else {
                          echo "<tr><td colspan='5'><center>No Data Avaliable</center></td></tr>";
                      }
                      ?>

                    </tbody>
                </table>

          </div>
        </div>
      </div>
    </section>


    <?php
        $connect->close();
        include_once('views/layout/partials/_footer.php');
        include_once('views/layout/partials/_scripts.php');
    ?>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').DataTable({
            // "scrollY": 200,
            "scrollX": true
        });
    } );
    </script>

  </body>
</html>
