<?php

include('../db/db_info.php');
include('../model/occ.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];


$data['id'] = $data['id'][0];







    $occ = new Occ();
    $occ->updateOccupation($data);
    
    $api = '?t=occ' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
