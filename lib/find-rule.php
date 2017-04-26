<?php

include('../model/rule.php');
include('../model/sub-plans.php');
include('../model/calTotalPrice.php');
include('../model/details-info.php');

$rule = new Rule;
$save_rule = array(); // to db

//print_r($quote->allVar);

if ($quote->getData('planID')) {
    $save_rule = $rule->matchRuleWithID($quote->getData('planID'), $quote->getData('ncd'));
} else {
    $save_rule = $rule->matchRuleWithVar($driver1->getDriverInfo(), $quote->isTest);
    if ($quote->hasDriver2) {
        $save_rule2 = $rule->matchRuleWithVar($driver2->getDriverInfo(), $quote->isTest);
        $save_rule = $rule->compareDriverRule($save_rule, $save_rule2);
    } // end driver2
}

$count_Third_Party_Only = 0;

if (!empty($save_rule)) {
    $DetailsInfo = new DetailsInfo;
    $details_ukey = array();
    foreach ($save_rule as $k => $v_ar) {

        $dfInfo_ar = $DetailsInfo->getByRule($v_ar['id']);

        $calTotalPriceObj = new CalTotalPrice($v_ar);

        if ($v_ar['TypeofInsurance'] == 'Comprehensive') {
            $save_rule[$k]['premium'] = number_format($calTotalPriceObj->calPremium($quote->getData('sum_insured')), 2,'.','');
        } else {
            $save_rule[$k]['premium'] = number_format($v_ar['premium'],2,'.','');
            $count_Third_Party_Only++;
        }
        $calTotalPriceArray = $calTotalPriceObj->calPrice($quote->getData('ncd'), $v_ar['price_add'],$v_ar['TypeofInsurance']);

        $df_ar = array_column($dfInfo_ar, 'value', 'deatils_id');
        $save_rule[$k]['TypeofInsurance'] =  $v_ar['TypeofInsurance'];

        $save_rule[$k]['details'] = $dfInfo_ar;
        $save_rule[$k]['subPlans'] =  SubPlans::findSubPlansByRuleIdWithLang($v_ar['id'], $quote->getData('lang'));

        $details_ukey = array_merge($details_ukey, array_keys($df_ar));

        $save_rule[$k]['gross'] = $calTotalPriceArray['gross'];
        $save_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $save_rule[$k]['price'] = $calTotalPriceArray['price'];
        $save_rule[$k]['total_price'] = $calTotalPriceArray['total_price'];
    }

    $details_ukey = array_column($DetailsInfo->getOrderByID(array_unique($details_ukey)), 'id');
}

if ( $count_Third_Party_Only >= 2 && !$quote->isTest){
    //error_log('count third party only');
    require_once '../lib/PHPMailer/PHPMailerAutoload.php';
    $mail = new \PHPMailer();
    $mail->setFrom('motor@kwiksure.com', 'Kwiksure');
    $mail->addAddress('ken@kwiksure.com', 'Ken');
    $mail->addAddress('alex@kwiksure.com', 'Alex');
    $mail->Subject = 'Motor Online Quote Rule hit more than 1 Rule';
    $mail->Body = print_r($quote->getData,TRUE) . print_r($save_rule,TRUE);
    $mail->send();
}