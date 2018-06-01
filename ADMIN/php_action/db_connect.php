<?php 
 
$servername = "localhost"; 
$username = "ntss"; 
$password = "eerning"; 
$dbname = "quiz_competition"; 
 
// create connection 
$connect = new mysqli($servername, $username, $password, $dbname); 
 
// check connection 
if($connect->connect_error) {
    die("Connection Failed : " . $connect->connect_error);
} else {
    // echo "Successfully Connected";
}
 
?>