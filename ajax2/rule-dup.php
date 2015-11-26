<?php
                  

include('../db/db_info.php');
include('../model/occ.php');
include('../model/car.php');
include('../model/rule.php');
include('../model/details-info.php');
include('../model/sub-plans.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

//error_log( print_r($data,true) );
//exit();


$oldRuleID = $data;
// get old rule data
$r = new Rule($oldRuleID);
$r->getOne();
$oldRuleDateAr = $r->rule->as_array() ;
$oldRuleDateAr['active'] = 0;
$oldRuleDateAr['ruleName'] = 'Dup' . $oldRuleDateAr['rule_name'];
//$oldRuleDateAr['priceAdd'] = $oldRuleDateAr['price_add'];
$oldRuleDateAr['DriveOffencePoint'] = $oldRuleDateAr['drive_offence_point'];
$oldRuleDateAr['MotorAccidentYrs'] = $oldRuleDateAr['motor_accident_yrs'];
$oldRuleDateAr['Active'] = $oldRuleDateAr['active'];

unset($oldRuleDateAr['id']);
unset($oldRuleDateAr['rule_name']);
unset($oldRuleDateAr['drive_offence_point']);
unset($oldRuleDateAr['motor_accident_yrs']);
unset($oldRuleDateAr['active']);


// new rule
$rule = new Rule();
$dupRuleID = $rule->newRule();

//update new rule
$newRule =new Rule($dupRuleID);
$newRule->editUpdate($oldRuleDateAr); // DEPRECATED

// add make/model
$car = new Car();
$oldMakeModeListAr = $car->getModelByRule($oldRuleID);
foreach ($oldMakeModeListAr as $oldMakeModeAr) {
    $dupCar = new Car($dupRuleID, $oldMakeModeAr['make']);
    $dupCar->addModelRule($oldMakeModeAr['model']);
    unset($dupCar);
}


// add Occ
$oldOcc = new Occ();
$oldOccListAr = $oldOcc->getByRule($oldRuleID);

foreach ($oldOccListAr as $oldOccAr) {
    $dupOcc = new Occ($dupRuleID);
    $dupOcc->addOccRule($oldOccAr['occ']);
    unset($dupOcc);
}

//add Detail
$df = new DetailsInfo;
$df_ar = $df->getByRule($oldRuleID);
foreach ($df_ar as $dfList) {
    $dupDF = new DetailsInfo($dupRuleID, $dfList['deatils_id']);
    $dupDF->addDetailsInfoRule($dfList['value']);
    unset($dupDF);
}

//add sup plan
$odlSPListAr = SubPlans::findSubPlansByRuleID($oldRuleID);
foreach ($odlSPListAr as $oldSPList) {
    $sp = new SubPlans();
    
    $oldSPList['rule'] = $dupRuleID;
    
    $sp->addSubPlans($oldSPList);//DEPRECATED
    unset($sp);
}


//ncd
$c = new car();
$ncd_ar = $c->getNCD();
foreach ( $ncd_ar as $k=>$v){
    car::createRuleNcd($dupRuleID, $k, 0);
}

exit();
