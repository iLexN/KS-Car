<?php

include('../db/db_info.php');
include('../model/car.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];



$displayName = $data['edit']['text'];


$car = new Car();
$car -> addNewMake($displayName);
    
$api = '?t=makeList' ;
foreach ($refresh_chunk as $k=>$v) {
    file_get_contents($v . $api);
}


