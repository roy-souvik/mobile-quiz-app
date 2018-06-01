<?php 
 
require_once 'db_connect.php';
 
$user_id = $_POST['member_id'];
 
$sql = "SELECT * FROM tbl_user WHERE user_id = $user_id";
$query = $connect->query($sql);
$result = $query->fetch_assoc();
 
$connect->close();
 
echo json_encode($result);
 
?>