<?php

require_once('UserService.class.php');

$userService = new UserService();

switch((string) $_REQUEST['req']) {

		case 'check_bank_status':
				$result = $userService->checkBankstatus($_REQUEST['user_id']);
		break;

		case 'submit_bank_info':
				$result = $userService->submitBankInformation($_REQUEST);
		break;

		case 'verify_bank_info':
				$result = $userService->verifyBankInformation($_REQUEST);
		break;

		case 'apply_bank_payment':
				$result = $userService->applyForBankPayment($_REQUEST);
		break;

		default:
		break;
}

echo json_encode($result);
die();
