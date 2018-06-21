<?php

if (!function_exists('scoreToRupees')) {

  function scoreToRupees($score)
  {
    if ($score <= 0) {
      return 0;
    }

    $unitAmount = AMOUNT_BLOCK / SCORE_BLOCK;

    return intval($score) * $unitAmount;
  }
}


function convertDateToTimestamp($format = 'Y-m-d H:i:s', $date)
{
    return DateTime::createFromFormat($format, $date)->getTimestamp();
}
