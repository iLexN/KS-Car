<?php

include '../lib/authentication.php';
include('../model/occ.php');
include('../model/car.php');
include('../model/driver.php');
include('../model/motor-quote.php');

$car = new Car;
$occ = new Occ;

require_once '../db/db_info.php';

/***
flow:
1 define data
2 check data
3 process data
4 find match rule/plan
isTest from tool return array / real api echo json
*****/

//checking function start
include '../lib/function.inc.php';



if (empty($_POST)) {
    return 'no data';
}

// for json return
$result = array();
$quote = new MotorQuote($_POST);


if ( $quote->saveUser ){
    require '../lib/PHPMailer/PHPMailerAutoload.php';
    $mail = new \PHPMailer();
    $mail->setFrom($quote->allVar['email'], $quote->allVar['name']);
    $mail->addAddress('webenquiries@kwiksure.com', 'KS Motor Quote');
    $mail->Subject = $quote->allVar['name'] . "-" . $quote->allVar['email'] . "-" . $quote->allVar['contactno'];
    $mail->Body = print_r($quote->allVar,TRUE);
    $mail->send();
}


$quote->setCar($car);
$quote->setOcc($occ);
$result['error'] = $quote->validationInput();

// stop and return with error
if (!empty($result['error'])) {
    $result['result'] = -1;
    $result['resultDesc'][] = '300 checking have error';
    if (!$quote->isTest) {
        header('Content-Type: application/json');
        echo(json_encode($result));
        //Log
        file_put_contents('../log/'.date('Ymd').'.log', date('H:i:s') . "\n\t" .
                json_encode($result) ."\n\t"  .
                json_encode($quote->allVar) ."\n\t"  .
                json_encode($_POST) . PHP_EOL, FILE_APPEND);
        
        return false;
    } else {
        return $result;
    }
    
}
unset($result['error']);

// find rule
if ($quote->skipFindRule) {
    $match_rule = false;
    $save_rule= array();
} else {
    $driver1 = $quote->buildDriver1();
    if ($quote->hasDriver2) {
        $driver2 = $quote->buildDriver2();
    }
    include '../lib/find-rule.php';
}

if ($match_rule) {
    $result['result'] = 1;
    $result['resultDesc'][] = '100 : Plan find';
    $result['plans'] = $match_rule;
    $result['planRowKey'] = $details_ukey;
} else {
    $result['result'] = 0;
    $result['resultDesc'][] = '105 : Plan not find';
}

// save user data
if ($quote->saveUser) {
    try {
        $result['result'] = 1;
        $result['resultDesc'][] = '200 : save ok';
        list($result['refid'], $result['refno'])  = $quote->saveQuote($save_rule);
    } catch (Exception $e) {
        $result['result-save'] = -1;
        $result['error'][] = $e->getMessage();
    }
    $result['pdf']['age'] = $quote->allVar['age'];
    $result['pdf']['age2'] = $quote->allVar['age2'];
    unset($result['plans']['subPlans']);
    unset($result['planRowKey']);
    
} elseif ($quote->isTest) {
    return $result;
}

header('Content-Type: application/json');
//may be for dubug
unset($result['resultDesc']);
echo json_encode($result);

