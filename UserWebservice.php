<?php

require_once('UserService.class.php');

$userService = new UserService();

switch($_REQUEST['req']) {

		case 'save_bank_details':
				$result = $userService->saveBankDetails($_REQUEST);
		break;

		default:
		break;
}

echo json_encode($result);
die();
