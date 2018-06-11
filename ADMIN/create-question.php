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
          <div class="col-md-10">
            <h1>
              <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
              Add Question
            </h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <form action="php_action/create_question.php" method="post">
              <fieldset>
                <legend>QUESTION CATEGORY</legend>
                <select name="qus_category">
                  <?php
                     $category = $connect->query("SELECT * FROM tbl_cat");
                     while ($row = $category->fetch_assoc()) {
                  ?>
                       <option value="<?php echo $row['category_id'];?>">
                         <?php echo $row['category'];?></option>
                   <?php } ?>

                </select>
              </fieldset>

             <fieldset>
               <legend>ENGLISH</legend>
               <textarea name="en_qus" rows="5" cols="60"></textarea><br>
               <label>OPTION-1</label><input type="text" name="en_op_1" size="32"><br>
               <label>OPTION-2</label><input type="text" name="en_op_2" size="32"><br>
               <label>OPTION-3</label><input type="text" name="en_op_3" size="32"><br>
               <label>OPTION-4</label><input type="text" name="en_op_4" size="32"><br>
               <label>RIGHT AN</label><input type="text" name="en_ans" size="31"><br>
             </fieldset>

             <fieldset>
               <legend>বাংলাা</legend>
               <textarea name="bn_qus" rows="5" cols="60"></textarea><br>
               <label>অপশন-1</label><input type="text" name="bn_op_1" size="36"><br>
               <label>অপশন-2</label><input type="text" name="bn_op_2" size="36"><br>
               <label>অপশন-3</label><input type="text" name="bn_op_3" size="36"><br>
               <label>অপশন-4</label><input type="text" name="bn_op_4" size="36"><br>
               <label>সঠিক উত্তর</label><input type="text" name="bn_ans" size="35"><br>
             </fieldset>

             <fieldset>
               <legend>हिंदी</legend>
               <textarea name="hn_qus" rows="5" cols="60"></textarea><br>
               <label>विकल्प-1</label><input type="text" name="hn_op_1" size="36"><br>
               <label>विकल्प-2</label><input type="text" name="hn_op_2" size="36"><br>
               <label>विकल्प-3</label><input type="text" name="hn_op_3" size="36"><br>
               <label>विकल्प-4</label><input type="text" name="hn_op_4" size="36"><br>
               <label>सही उत्तर</label><input type="text" name="hn_ans" size="35"><br><br>
               <button type="submit">Save</button>
               <a href="questions.php"><button type="button">Back</button></a></td>
             </fieldset>

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
