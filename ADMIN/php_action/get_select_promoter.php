<?php 
 
require_once 'db_connect.php';
 
$promoter_id = $_POST['member_id'];
 
$sql = "SELECT * FROM tbl_promoter WHERE promoter_id = $promoter_id";
$query = $connect->query($sql);
$result = $query->fetch_assoc();
 
$connect->close();
 
echo json_encode($result);
 
?>