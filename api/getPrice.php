<?php
//ini_set('serialize_precision', -1);

$authInfo = require_once '../db/auth.php';

include '../lib/authentication.php';

include('../model/occ.php');
include('../model/car.php');
include('../model/driver.php');

include('../model/PartnerInterface.php');
include('../model/PartnerFactory.php');
include('../model/motor-quote.php');
include('../model/GoBear.php');

require_once '../db/db_info.php';

/***
flow:
1 define data
2 check data
3 process data
4 find match rule/plan
isTest from tool return array / real api echo json
*****/
/* @var $logger \Monolog\Logger */

//checking function start
include '../lib/function.inc.php';

// for json return
$result = array();
$partnerFactory = new PartnerFactory($_POST);
/* @var $quote \MotorQuote|\GoBear */
$quote = $partnerFactory->createPartner($u[0]);

if ($quote->saveUser) {
    $mail = new \PHPMailer();
    $mail->setFrom($quote->getData('email'), $quote->getData('name'));
    $mail->addAddress('webenquiries@kwiksure.com', 'KS Motor Quote - ' . $quote->getOwner());
    $mail->Subject = $quote->getData('name') . "-" . $quote->getData('email') . "-" . $quote->getData('contactno');
    $mail->Body = print_r($quote->getData(), true);
    $mail->send();
}

try {
    $quote->validationInput();
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
    $result['result'] = -1;
    $result['resultDesc'][] = '300 checking have error';
    if (!$quote->isTest) {
        header('Content-Type: application/json');
        echo(json_encode($result));
        //Log
        $logger->error('ValidationError.'.$quote->getOwner(), [$result,$quote->getData(),$_POST]);

        return false;
    } else {
        return $result;
    }
}

// find rule
if ($quote->skipFindRule) {
    //$match_rule = array();
    $save_rule= array();
} else {
    $driver1 = new Driver($quote->getDriver1Data());
    if ($quote->hasDriver2) {
        $driver2 = new Driver($quote->getDriver2Data());
    }
    include '../lib/find-rule.php';
}

if (!empty($save_rule)) {
    $result['result'] = 1;
    $result['resultDesc'][] = '100 : Plan find';
    $result['plans'] = $quote->formatRules($save_rule);
    $result['planRowKey'] = $details_ukey;
} else {
    $result['result'] = 0;
    $result['resultDesc'][] = '105 : Plan not find';
}
$result = $quote->formatResultMatchRule($result);

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
    $result = $quote->formatResultSaveUser($result);
} elseif ($quote->isTest) {
    $countPlan = '<b style="color:red">'.count($result['plans']).'</b>';
    return array('countPlan'=>$countPlan) + $result;
}

header('Content-Type: application/json');
//may be for dubug
unset($result['resultDesc']);
echo json_encode($result);

//$logger->info('result',$result);
