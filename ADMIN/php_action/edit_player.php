<?php 

require_once 'db_connect.php';

//if form is submitted
if($_POST) {    

    $validator = array('success' => false, 'messages' => array());

    $id = $_POST['member_id'];    
    $active = $_POST['editActive'];
   
    $sql = "UPDATE tbl_user SET user_active = $active WHERE user_id = $id";
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