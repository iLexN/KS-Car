<?php

include('../model/rule.php');
include('../model/sub-plans.php');
include('../model/calTotalPrice.php');

$rule = new Rule;
$match_rule = array(); // for output
$save_rule = array(); // to db

//error_log( 'planID :: ' . $planID );
if ($planID) {
    $save_rule = $rule->matchRuleWithID($planID,$allVar['ncd']);
} else {
    $save_rule = $rule->matchRuleWithVar($allVar,$isTest);
        
        //save_rule2 must === to save_rule if driver2 exist
        if ($driver2) {
            $driver2InfoAr = array();
            $driver2InfoAr['carModel'] = $allVar['carModel'];
            $driver2InfoAr['occupation'] = $allVar['occupation2'];
            $driver2InfoAr['age'] = $allVar['age2'];
            $driver2InfoAr['ncd'] = $allVar['ncd'];
            $driver2InfoAr['drivingExp'] = $allVar['drivingExp2'];
            $driver2InfoAr['insuranceType'] = $allVar['insuranceType'];
            $driver2InfoAr['motor_accident_yrs'] = $allVar['motor_accident_yrs2'];
            $driver2InfoAr['drive_offence_point'] = $allVar['drive_offence_point2'];
            $driver2InfoAr['calYrMf'] = $allVar['calYrMf'];
            $save_rule2 = $rule->matchRuleWithVar($driver2InfoAr,$isTest);
            
            //error_log('1');
            //error_log( print_r( $save_rule , true ) );
            //error_log('2');
            //error_log( print_r( $save_rule2 , true ) );
            
            foreach ($save_rule as $k => $v_ar) {
                if (empty($save_rule2[$k])) {
                    $save_rule = array();
                    break;
                }
                $result = array_diff_assoc($save_rule[$k], $save_rule2[$k]);
                if (!empty($result)) {
                    $save_rule = array();
                    break;
                }
            } // end foreach
        } // end driver2
}


if (!empty($save_rule)) {
    include('../model/details-info.php');
    $DetailsInfo = new DetailsInfo;
    $details_ukey = array();
    foreach ($save_rule as $k => $v_ar) {
        $dfInfo_ar = $DetailsInfo->getByRule($v_ar['id']);
        
        //error_log( print_r($v_ar,true) );
        
        // array_column is php5.5
        include('../lib/array_column.php');
        
        $calTotalPriceObj = new calTotalPrice($v_ar);
        $calTotalPriceArray = $calTotalPriceObj->calPrice($allVar['ncd'],$v_ar['price_add']);
        //error_log('price_add:'.$v_ar['price_add']);
        
        $df_ar = array_column($dfInfo_ar, 'value', 'deatils_id');
        $match_rule[$k]['id'] = $v_ar['id'];
        $match_rule[$k]['planName'] = $v_ar['rule_name'];
        $match_rule[$k]['total_price'] = $calTotalPriceArray['total_price'];
        $match_rule[$k]['premium'] = $v_ar['premium'];
        $match_rule[$k]['loading'] = $v_ar['loading'];
        $match_rule[$k]['clientDiscount'] = $v_ar['clientDiscount'];
        $match_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $match_rule[$k]['details'] = $df_ar;
                
        $save_rule[$k]['details'] = $dfInfo_ar;
        $save_rule[$k]['subPlans'] = $match_rule[$k]['subPlans'] = SubPlans::findSubPlansByRuleIdWithLang($v_ar['id'], $allVar['lang']);
                //$match_rule[$k]['subPlans'] = SubPlans::findSubPlansByRuleIdWithLang($v_ar['id'],$allVar['lang']);
                
        $details_ukey = array_merge($details_ukey, array_keys($df_ar));
        
        $save_rule[$k]['gross'] = $calTotalPriceArray['gross'];
        $save_rule[$k]['mibValue'] = $calTotalPriceArray['mibValue'];
        $save_rule[$k]['price'] = $calTotalPriceArray['price'];
        $save_rule[$k]['total_price'] = $calTotalPriceArray['total_price'];
        
        
    }
    
    $details_ukey = array_unique($details_ukey);
}
