<?php

include('../db/db_info.php');
include('../model/sub-plans.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data']['subplanInfo'];

$data['rule_id'] = $obj['data']['rule_id'];

unset($data['id']);


$s = new SubPlans();

$s->addSubPlan($data);
