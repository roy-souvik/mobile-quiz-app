<?php 

require_once 'db_connect.php';
 
$output = array('success' => false, 'messages' => array());
 
$promoter_id = $_POST['promoter_id'];
 
//$sql = "DELETE FROM tbl_promoter WHERE promoter_id = {$promoter_id}";
$sql = "UPDATE tbl_promoter SET promoter_delete = 0 WHERE promoter_id = {$promoter_id}";
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