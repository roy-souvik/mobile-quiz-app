<?php 

require_once 'db_connect.php';
 
$user_id = $_POST['member_id'];
 
//$sql = "SELECT * FROM tbl_user WHERE user_id = $user_id";
$sql = "SELECT c.user_id, user_name, user_email, user_social_no, user_phone_no, user_paytm, user_bank, user_bank_ac, user_bank_ifsc, user_point, user_amount FROM tbl_user c RIGHT JOIN tbl_user_amount USING (user_id) WHERE user_id=$user_id";
$query = $connect->query($sql);
$result = $query->fetch_assoc();
 
$connect->close();
 
echo json_encode($result);

 ?>