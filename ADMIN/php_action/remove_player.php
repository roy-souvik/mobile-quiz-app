<?php 

require_once 'db_connect.php';
 
$output = array('success' => false, 'messages' => array());
 
$id = $_POST['user_id'];

$sql = "UPDATE tbl_user SET user_delete = 0 WHERE user_id = {$id}";
$query = $connect->query($sql);
if($query === TRUE) {
    $output['success'] = true;
    $output['messages'] = 'Successfully removed';
} else {
    $output['success'] = false;
    $output['messages'] = 'Error while removing the member information';
}
 
// close database connection
$connect->close();
 
echo json_encode($output);


 ?>