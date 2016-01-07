<?php

include('../db/db_info.php');
include('../model/occ.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

;
$occ = new Occ(intval($data['rule_id']));

$e = false;
foreach ($data['occ']['id'] as $occID) {
    if ($occ->checkNotExist($occID)) {
        // insert
        $occ->addOccRule($occID);
         
    } else {
        
    }
}

