<?php

include('../model/rule.php');
include('../model/sub-plans.php');
include('../model/calTotalPrice.php');
include('../model/details-info.php');

// array_column is php5.5
include('../lib/array_column.php');

$rule = new Rule;
$match_rule = array(); // for output
$save_rule = array(); // to db

//print_r($quote->allVar);

if ($quote->allVar['planID']) {
    $save_rule = $rule->matchRuleWithID($quote->allVar['planID'], $quote->allVar['ncd']);
} else {
    $save_rule = $rule->matchRuleWithVar($driver1->getDriverInfo(), $quote->isTest);
    if ($quote->hasDriver2) {
        $save_rule2 = $rule->matchRuleWithVar($driver2->getDriverInfo(), $quote->isTest);
        $save_rule = $rule->compareDriverRule($save_rule, $save_rule2);
    } // end driver2
}


if (!empty($save_rule)) {
    $DetailsInfo = new DetailsInfo;
    $details_ukey = array();
    foreach ($save_rule as $k => $v_ar) {
        
        $dfInfo_ar = $DetailsInfo->getByRule($v_ar['id']);

        $calTotalPriceObj = new calTotalPrice($v_ar);
        if ($v_ar['TypeofInsurance'] == 'Comprehensive') {
            $save_rule[$k]['premium'] = $match_rule[$k]['premium'] = number_format($calTotalPriceObj->calPremium($quote->allVar['sum_insured']), 2,'.','');
        } else {
            $save_rule[$k]['premium'] = $match_rule[$k]['premium'] = number_format($v_ar['premium'],2,'.','');
        }
        $calTotalPriceArray = $calTotalPriceObj->calPrice($quote->allVar['ncd'], $v_ar['price_add']);

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
        $save_rule[$k]['subPlans'] = $match_rule[$k]['subPlans'] = SubPlans::findSubPlansByRuleIdWithLang($v_ar['id'], $quote->allVar['lang']);

        $details_ukey = array_merge($details_ukey, array_keys($df_ar));
        
        $save_rule[$k]['gross'] = $calTotalPriceArray['gross'];
        $save_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $save_rule[$k]['price'] = $calTotalPriceArray['price'];
        $save_rule[$k]['total_price'] = $calTotalPriceArray['total_price'];
    }
    
    $details_ukey = array_column($DetailsInfo->getOrderByID(array_unique($details_ukey)), 'id');
}
