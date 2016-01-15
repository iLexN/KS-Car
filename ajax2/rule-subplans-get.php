<?php


include('../db/db_info.php');
include('../model/sub-plans.php');

$out = SubPlans::findSubPlansByRuleID($_GET['id']);
header('Content-Type: application/json');


foreach ( $out as $k=> &$v) {
    $v['sortOrder'] = (int) $v['sortOrder'];
}

echo( json_encode($out) );
