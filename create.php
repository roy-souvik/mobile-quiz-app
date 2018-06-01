<?php
  require_once 'php_action/db_connect.php';
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>

    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 20px;
            width: 35%;
        }

    </style>

</head>
<body>

 <form action="php_action/create.php" method="post">
   <fieldset>
     <legend>QUESTION CATEGORY</legend>
     <select name="qus_category">
       <?php
          $category = $connect->query("SELECT * FROM tbl_cat");
          while ($row = $category->fetch_assoc())
          {
       ?>
            <option value="<?php echo $row['category_id'];?>"><?php echo $row['category'];?></option>
        <?php
          }
        ?>
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
    <a href="index.php"><button type="button">Back</button></a></td>
  </fieldset>

</form>

</body>
</html>
