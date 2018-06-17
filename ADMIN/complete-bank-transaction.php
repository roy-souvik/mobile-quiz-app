<?php
require_once('check_user_session.php');
require_once('../ADMIN/config.php');
require_once('../UserService.class.php');

if (empty($_POST['transaction_id'])) {
  die('Missing params');
}

if (isset($_POST['transaction_id']) && intval($_POST['transaction_id']) > 0) {
  $transactionId = intval($_POST['transaction_id']);
}

$userService = new UserService();
$currentTransaction = $userService->getBankTransactionById($transactionId);
$userService->setUser($currentTransaction['user_id']);
$updated = $userService->updateBankTransaction($_POST);
$connect->close();

if ($updated) {
  header('location: user-details.php?id=' . $currentTransaction['user_id']);
  die;
}

die('Unable to update data');
