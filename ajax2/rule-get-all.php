<?php


include('../db/db_info.php');
include('../model/rule.php');
include('../model/sub-plans.php');
include('../model/car.php');

$rule = new Rule;
$rule_ar = $rule->getAlls();
header('Content-Type: application/json');
echo(json_encode($rule_ar));
