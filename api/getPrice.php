<?php

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

//checking function start
include '../lib/function.inc.php';

// for json return
$result = array();
$partnerFactory = new PartnerFactory($_REQUEST);
/* @var $quote \MotorQuote|\GoBear */
$quote = $partnerFactory->createPartner($u[0]);

if ($quote->saveUser) {
    require_once '../lib/PHPMailer/PHPMailerAutoload.php';
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
    $result['error'] = $e->getMessage();
    $result['result'] = -1;
    $result['resultDesc'][] = '300 checking have error';
    if (!$quote->isTest) {
        header('Content-Type: application/json');
        echo(json_encode($result));
        //Log
        file_put_contents('../log/'.date('Ymd'). '_' . $quote->getOwner() .'.log', date('H:i:s') . "\n\t" .
                json_encode($result) ."\n\t"  .
                json_encode($quote->getData()) ."\n\t"  .
                json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);

        return false;
    } else {
        return $result;
    }
}

// find rule
if ($quote->skipFindRule) {
    $match_rule = array();
    $save_rule= array();
} else {
    $driver1 = new Driver($quote->getDriver1Data());
    if ($quote->hasDriver2) {
        $driver2 = new Driver($quote->getDriver2Data());
    }
    include '../lib/find-rule.php';
}

if (!empty($match_rule)) {
    $result['result'] = 1;
    $result['resultDesc'][] = '100 : Plan find';
    $result['plans'] = $quote->formatRules($match_rule);
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
