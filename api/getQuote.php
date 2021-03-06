<?php

$authInfo = require_once '../db/auth.php';
include '../lib/authentication.php';

include('../db/db_info.php');
include('../model/PartnerInterface.php');
include('../model/motor-quote.php');
include('../model/occ.php');
include('../model/car.php');
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
    header('Content-Type: application/json');
    echo json_encode($result);
    return ;
}

$motor_quote = new MotorQuote([], new Car , new Occ);
try {
    $result['result'] = 1;
    $result['motor_details'] = $motor_quote->getByRefNo($refno);

    unset($result['motor_details']['save_reason']);
    unset($result['motor_details']['plan_match_json']);
    unset($result['motor_details']['refno']);
    unset($result['motor_details']['create_datetime']);

} catch (Exception $e) {
    $result['result'] = -1;
    $result['error'][] = $e->getMessage();
}
header('Content-Type: application/json');
echo json_encode($result);

