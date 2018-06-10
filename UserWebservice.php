<?php

require_once('UserService.class.php');

$userService = new UserService(intval($_REQUEST['user_id']));

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

		case 'edit_profile':
				$result = $userService->editProfile($_REQUEST);
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

/*
req=edit_profile&user_id=23&promoter_id=promoter_1@gmail.com&user_name=Pintu%20Das&user_email=pintu.ntss@gmail.com&user_social_no=ABCPINTU123&user_phone_no=9733759225&user_paytm&user_bank&user_bank_ac&user_bank_ifsc&user_image=
 */
