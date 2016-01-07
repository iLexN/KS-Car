<?php

include('../db/db_info.php');
include('../model/details-info.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);


$df = new DetailsInfo();
$df->updateDetailInfoByID($obj['data']);

$api = '?t=planRow' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
