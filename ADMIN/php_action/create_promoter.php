<?php 

 require_once 'db_connect.php'; 
 //if form is submitted if($_POST) 
 //{ 
        //$validator = array('success' => false, 'messages' => array());
     
        $promoter_name = $_POST['promoter_name'];
        $promoter_email = $_POST['promoter_email'];
        $promoter_pass = $_POST['promoter_pass'];
        $promoter_phone = $_POST['promoter_phone'];
        $promoter_point = 50;
        $promoter_active = $_POST['promoter_active'];
        $promoter_delete = 1;

     
        $sql = "INSERT INTO tbl_promoter (promoter_name, promoter_email, promoter_pass, promoter_phone, promoter_point, promoter_active, promoter_delete) VALUES ('$promoter_name', '$promoter_email', '$promoter_pass', '$promoter_phone', '$promoter_point', '$promoter_active', '$promoter_delete')";
        $query = $connect->query($sql);
     
        if($query === TRUE) {           
            $validator['success'] = true;
            $validator['messages'] = "Successfully Added";      
        } else {        
            $validator['success'] = false;
            $validator['messages'] = "Error while adding the member information";
        }
     
        // close the database connection
        $connect->close();
     
        echo json_encode($validator);
 
//}



 ?>