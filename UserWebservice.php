<?php

require_once('UserService.class.php');
// require_once('ADMIN/user/user.model.php');

$userService = new UserService();
// var_dump($userService);die;
switch($_REQUEST['req']) {

		case 'save_bank_details':
				$result = $userService->saveBankDetails($_REQUEST);
		break;

		default:
		break;
}

echo json_encode($result);
die();
