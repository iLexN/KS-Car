<?php

include('../db/db_info.php');
include('../model/occ.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];


$occ = new Occ;
$occ->removeOccRule(intval($data['id']));


