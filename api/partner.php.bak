<?php

header('Content-Type: application/json');

$authInfo = require_once '../db/auth.php';
include '../lib/authentication.php';

include('../model/driver.php');
include('../model/rule.php');
include('../model/sub-plans.php');
include('../model/calTotalPrice.php');
include('../model/details-info.php');
include('../model/occ.php');
include('../model/car.php');

include('../model/PartnerInterface.php');
include('../model/PartnerFactory.php');
include('../model/GoBear.php');

require_once '../db/db_info.php';

//checking function start
include '../lib/function.inc.php';

$partnerFactory = new PartnerFactory($_GET);
/* @var $partner \PartnerInterface */
$partner = $partnerFactory->createPartner($u[0]);


try {
    $partner->validationInput();
} catch (Exception $e) {
     $result['error'] = $e->getMessage();
     $result['result'] = -1;
     $result['resultDesc'][] = '300 checking have error';
     echo(json_encode($result));

     file_put_contents('../log/'.date('Ymd'). '_' . $partner->getOwner() .'.log', date('H:i:s') . "\n\t" .
                json_encode($result) ."\n\t"  .
                json_encode($partner->getData()) ."\n\t"  .
                json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);

     return false;
}

$driver1 = new Driver($partner->getDriver1Data());

$rule = new Rule;
$match_rule = array(); // for output
$save_rule = array(); // to db

$save_rule = $rule->matchRuleWithVar($driver1->getDriverInfo(), false);

$count_Third_Party_Only = 0;

    $DetailsInfo = new DetailsInfo;
    $details_ukey = array();
    foreach ($save_rule as $k => $v_ar) {

        $dfInfo_ar = $DetailsInfo->getByRule($v_ar['id']);

        $calTotalPriceObj = new CalTotalPrice($v_ar);

        if ($v_ar['TypeofInsurance'] == 'Comprehensive') {
            $save_rule[$k]['premium'] = $match_rule[$k]['premium'] = number_format($calTotalPriceObj->calPremium($partner->getData('sum_insured')), 2,'.','');
        } else {
            $save_rule[$k]['premium'] = $match_rule[$k]['premium'] = number_format($v_ar['premium'],2,'.','');
            $count_Third_Party_Only++;
        }
        $calTotalPriceArray = $calTotalPriceObj->calPrice($partner->getData('ncd'), $v_ar['price_add'],$v_ar['TypeofInsurance']);

        $df_ar = array_column($dfInfo_ar, 'value', 'deatils_id');
        $match_rule[$k]['id'] = $v_ar['id'];
        $match_rule[$k]['planName'] = $v_ar['rule_name'];
        $match_rule[$k]['total_price'] = number_format($calTotalPriceArray['total_price'], 0,'.','');
        $save_rule[$k]['TypeofInsurance'] = $match_rule[$k]['TypeofInsurance'] = $v_ar['TypeofInsurance'];

        $match_rule[$k]['loading'] = $v_ar['loading'];
        $match_rule[$k]['clientDiscount'] = $v_ar['clientDiscount'];
        $match_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $match_rule[$k]['details'] = $df_ar;

        $save_rule[$k]['details'] = $dfInfo_ar;
        $save_rule[$k]['subPlans'] = $match_rule[$k]['subPlans'] = SubPlans::findSubPlansByRuleIdWithLang($v_ar['id'], 'en');

        $details_ukey = array_merge($details_ukey, array_keys($df_ar));

        $save_rule[$k]['gross'] = $calTotalPriceArray['gross'];
        $save_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $save_rule[$k]['price'] = $calTotalPriceArray['price'];
        $save_rule[$k]['total_price'] = $calTotalPriceArray['total_price'];
    }

if (!empty($match_rule)) {
    $result['result'] = 1;
    $result['resultDesc'][] = '100 : Plan find';
    $result['plans'] = $partner->formatRules($match_rule);
    $result['planRowKey'] = $details_ukey;
} else {
    $result['result'] = 0;
    $result['resultDesc'][] = '105 : Plan not find';
}

$result = $partner->formatResultMatchRule($result);

//todo : after save user user to db
$result = $partner->formatResultSaveUser($result);

echo(json_encode($result));


if ( $count_Third_Party_Only >= 2){
    require_once '../lib/PHPMailer/PHPMailerAutoload.php';
    $mail = new \PHPMailer();
    $mail->setFrom('motor@kwiksure.com', 'Kwiksure');
    $mail->addAddress('ken@kwiksure.com', 'Ken');
    $mail->addAddress('alex@kwiksure.com', 'Alex');
    $mail->Subject = 'Motor Online Quote Rule hit more than 1 Rule';
    $mail->Body = print_r($partner->getData(),TRUE) . print_r($save_rule,TRUE);
    $mail->send();
}


