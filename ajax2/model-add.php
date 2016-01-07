<?php

/**
displayName : mmDisplayName,
newType : mmNewType,
make : $MakeList.val()
***/

include('../db/db_info.php');
include('../model/car.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];


$displayName = $data['edit']['text'];
$makeID = $data['make_id'];

$car = new Car('', $makeID);



    $car -> addNewModel($displayName);
    
    $api = '?t=modelList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }

