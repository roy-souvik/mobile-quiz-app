<?php 

require_once 'db_connect.php';

//if form is submitted
if($_POST) {    

    $validator = array('success' => false, 'messages' => array());

    $id = $_POST['member_id'];
    //$id = $_POST['editId'];
    //$name = $_POST['editName'];
    //$email = $_POST['editEmail'];
    //$pass = $_POST['editPass'];
    //$phone = $_POST['editPhone'];
    //$point = $_POST['editPoint'];
    $active = $_POST['editActive'];

    //$sql = "UPDATE tbl_promoter SET promoter_name = '$name', promoter_email = '$email', promoter_pass = '$pass', promoter_phone = '$phone', promoter_point = '$point', promoter_active = '$active' WHERE promoter_id = $id";
    $sql = "UPDATE `tbl_promoter` SET `promoter_active` = '$active' WHERE `promoter_id` = $id";
    $execute = $connect->query($sql);

    if($execute === TRUE) {           
        $validator['success'] = true;
        $validator['messages'] = "Successfully Added";      
    } else {        
        $validator['success'] = false;
        $validator['messages'] = "Error while adding the member information";
    }

    // close the database connection
    $connect->close();

    echo json_encode($validator);

}