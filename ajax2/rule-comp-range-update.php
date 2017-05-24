<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/ComprehensiveRange.php');

$json = file_get_contents('php://input');
$input = json_decode($json,1);


$cr = new \ComprehensiveRange();
$cr->update($input['data']);

