<?php

require_once('UserService.class.php');

$userService = new UserService(intval($_REQUEST['user_id']));

switch((string) $_REQUEST['req']) {

		case 'check_bank_status':
				$result = $userService->checkBankStatus($_REQUEST['user_id']);
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

		case 'edit_profile':
				$result = $userService->updateProfileInfo($_REQUEST);
		break;

		case 'wallet_status':
				$result = $userService->getWalletStatus(intval($_REQUEST['user_id']));
		break;

		case 'payment_list':
				$result = $userService->getPaymentList(intval($_REQUEST['user_id']));
		break;

		default:
				$result = [
					'flag' => false,
					'message' => 'Your request is not valid.'
				];
		break;
}

echo json_encode($result);
die();
