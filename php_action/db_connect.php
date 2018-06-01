<?php

	$localhost = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "quiz_competition";

	// create connection
	$connect = new mysqli($localhost, $username, $password, $dbname);
	//$connect->query("SET NAMES 'utf8'");
	//$connect->query("SET CHARACTER SET utf8");
	//$connect->query("SET SESSION collation_connection = ’utf8_general_ci’");

	// check connection
	if($connect->connect_error) {
	    die("connection failed : " . $connect->connect_error);
	} else {
	    // echo "Successfully Connected";
	}
?>
