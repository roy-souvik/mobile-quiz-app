<?php
//include "includes/dbconnect.php";
//session_start();
//ob_start();
//include '/home/ncmwing/public_html/wing/dashboard/includes/classes/class.phpmailer.php';
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
include "PromoterWebservice_class.php";
$userval = new PromoterWebservice();

switch($_REQUEST['req'])
{
	///// -- New API --////
	
	case "log_in":
	$val=$userval->log_in($_REQUEST);
	break;
	
	case "user_list":
	$val=$userval->user_list($_REQUEST);
	break;
}
echo json_encode($val);
//print_r($val);
?>
