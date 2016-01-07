<?php


include('../db/db_info.php');
include('../model/sub-plans.php');

$out = SubPlans::findSubPlansByRuleID($_GET['id']);

echo( json_encode($out) );
