<?php
//include "includes/dbconnect.php";
//session_start();
//ob_start();
//include '/home/ncmwing/public_html/wing/dashboard/includes/classes/class.phpmailer.php';
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
include "QuizWebService_Class.php";
$userval = new QuizWebService();

switch($_REQUEST['req'])
{
	///// -- New API --////
	case "registration":
	$val=$userval->registration($_REQUEST);
        break;
	case "log_in":
	$val=$userval->log_in($_REQUEST);
	break;
	case "question":
	$val=$userval->question($_REQUEST);
	break;

	case "answer":
	$val=$userval->answer($_REQUEST);
	break;

	case "video":
	$val=$userval->video($_REQUEST);
	break;

	case "point":
	$val=$userval->point($_REQUEST);
	break;

	case "version":
	$val=$userval->version($_REQUEST);
	break;

	case "wallet":
	$val=$userval->wallet($_REQUEST);
	break;

	case "withdrawal":
	$val=$userval->withdrawal($_REQUEST);
	break;

	case "recharge_withdrawal":
	$val=$userval->recharge_withdrawal($_REQUEST);
	break;

	case "edit_profile":
	$val=$userval->edit_profile($_REQUEST);
	break;

	case "tarnsaction_details":
	$val=$userval->tarnsaction_details($_REQUEST);
	break;
}
echo json_encode($val);
//print_r($val);
?>
