<?php

require_once 'db_connect.php';
//$connect->query("SET NAMES 'utf8'");
//$connect->query("SET CHARACTER SET utf8");
//$connect->query("SET SESSION collation_connection = ’utf8_general_ci’");

$row_cnt = $connect->query("SELECT * FROM tbl_question");
echo $row_cnt = $row_cnt->num_rows;echo "<br>";
echo ++$row_cnt;

if($_POST) {
    $qus_category = $_POST['qus_category'];
    /*$en_qus = string utf8_encode($_POST['en_qus']);
    $en_op_1 = string utf8_encode($_POST['en_op_1']);
    $en_op_2 = string utf8_encode($_POST['en_op_2']);
    $en_op_3 = string utf8_encode($_POST['en_op_3']);
    $en_op_4 = string utf8_encode($_POST['en_op_4']);
    $en_ans = string utf8_encode($_POST['en_ans']);

    $bn_qus = string utf8_encode($_POST['bn_qus']);
    $bn_op_1 = string utf8_encode($_POST['bn_op_1']);
    $bn_op_2 = string utf8_encode($_POST['bn_op_2']);
    $bn_op_3 = string utf8_encode($_POST['bn_op_3']);
    $bn_op_4 = string utf8_encode($_POST['bn_op_4']);
    $bn_ans = string utf8_encode($_POST['bn_ans']);

    $hn_qus = string utf8_encode($_POST['hn_qus']);
    $hn_op_1 = string utf8_encode($_POST['hn_op_1']);
    $hn_op_2 = string utf8_encode($_POST['hn_op_2']);
    $hn_op_3 = string utf8_encode($_POST['hn_op_3']);
    $hn_op_4 = string utf8_encode($_POST['hn_op_4']);
    $hn_ans = string utf8_encode($_POST['hn_ans']);*/

    $en_qus = $_POST['en_qus'];
    $en_op_1 = $_POST['en_op_1'];
    $en_op_2 = $_POST['en_op_2'];
    $en_op_3 = $_POST['en_op_3'];
    $en_op_4 = $_POST['en_op_4'];
    $en_ans = $_POST['en_ans'];

    $bn_qus = $_POST['bn_qus'];
    $bn_op_1 = $_POST['bn_op_1'];
    $bn_op_2 = $_POST['bn_op_2'];
    $bn_op_3 = $_POST['bn_op_3'];
    $bn_op_4 = $_POST['bn_op_4'];
    $bn_ans = $_POST['bn_ans'];


    $hn_qus = $_POST['hn_qus'];
    $hn_op_1 = $_POST['hn_op_1'];
    $hn_op_2 = $_POST['hn_op_2'];
    $hn_op_3 = $_POST['hn_op_3'];
    $hn_op_4 = $_POST['hn_op_4'];
    $hn_ans = $_POST['hn_ans'];

    $sql = "INSERT INTO tbl_question(qus_id, qus_category, qus_en_qustion, qus_en_option_1, qus_en_option_2, qus_en_option_3, qus_en_option_4, qus_en_right_ans, qus_bn_qustion, qus_bn_option_1, qus_bn_option_2, qus_bn_option_3, qus_bn_option_4, qus_bn_right_ans, qus_hn_qustion, qus_hn_option_1, qus_hn_option_2, qus_hn_option_3, qus_hn_option_4, qus_hn_right_ans) VALUES ('$row_cnt', '$qus_category', '$en_qus', '$en_op_1', '$en_op_2', '$en_op_3', '$en_op_4', '$en_ans', '$bn_qus', '$bn_op_1', '$bn_op_2', '$bn_op_3', '$bn_op_4', '$bn_ans', '$hn_qus', '$hn_op_1', '$hn_op_2', '$hn_op_3', '$hn_op_4', '$hn_ans')";

    if($connect->query($sql) === TRUE) {
        echo "<p>New Record Successfully Created</p>";
        echo "<a href='../create.php'><button type='button'>Back</button></a>";
        echo "<a href='../index.php'><button type='button'>Home</button></a>";
    } else {
        echo "Error " . $sql . ' ' . $connect->connect_error;
    }

    $connect->close();
}

?>
