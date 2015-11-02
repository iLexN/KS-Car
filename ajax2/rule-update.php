<?php

include('../db/db_info.php');
include('../model/rule.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];


$rule = new Rule(intval($data['id']));
$rule->update($data);


$ar['done'] = 1;
