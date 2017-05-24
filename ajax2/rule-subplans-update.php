<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/sub-plans.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

$s = new SubPlans();

$s->updateSubPlans($data);
