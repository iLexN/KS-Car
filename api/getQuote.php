<?php

include '../lib/authentication.php';

include('../db/db_info.php');
include('../model/motor-quote.php');
include('../lib/function.inc.php');

// for json return
$result = array();

// check
$refno = isset($_GET['refno']) ? $_GET['refno'] : '';
try {
    checkEmpty('refno', $refno);
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}

// stop and return with error

if (!empty($result['error'])) {
    $result['result'] = -1;
    echo json_encode($result);
    exit();
}

$motor_quote = new MotorQuote;
try {
    $result['result'] = 1;
    $result['motor_details'] = $motor_quote->getByRefNo($refno);
    
    unset($result['motor_details']['plan_match_json']);
    unset($result['motor_details']['refno']);
    unset($result['motor_details']['create_datetime']);
} catch (Exception $e) {
    $result['result'] = -1;
    $result['error'][] = $e->getMessage();
}

echo json_encode($result);

exit();
