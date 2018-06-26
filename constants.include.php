<?php
date_default_timezone_set('Asia/Kolkata');

// Bank Account Statuses
define('BANK_ACCOUNT_DO_NOT_EXIST', 0);
define('BANK_ACCOUNT_NOT_REVIEWED', 1);
define('BANK_ACCOUNT_ADMIN_REVIEW', 2);
define('BANK_ACCOUNT_APPROVED', 3);

define('DAYS_TO_REQUEST_BANK_TRANSACTION', 30);
define('MINIMUM_AMOUNT_FOR_REQUEST', 500);

// Score
define('SCORE_BLOCK', 1000);
define('AMOUNT_BLOCK', 50);

define('WATCHED_VIDEO_STATE', 2);
define('CORRECT_ANSWER_STATE', 1);
define('WRONG_ANSWER_STATE', 0);
