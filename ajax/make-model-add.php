<?php

/**
displayName : mmDisplayName,
newType : mmNewType,
make : $MakeList.val()
***/

include('../db/db_info.php');
include('../model/car.php');

$displayName = $_POST['displayName'];
$mmNewType = $_POST['newType'] ; // make ,model
$makeID = $_POST['make'];

$car = new Car('', $makeID);


if ($mmNewType == 'make') {
    $car -> addNewMake($displayName);
    
    $api = '?t=makeList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
} elseif ($mmNewType == 'model') {
    $car -> addNewModel($displayName);
    
    $api = '?t=modelList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
} else {
    echo("ERROR...$mmNewType");
}


// todo : call ks mode to gen new data
