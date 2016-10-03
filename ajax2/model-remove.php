<?php
             

include('../db/db_info.php');
include('../model/car.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$car = new Car();

if (is_array($obj['data'])) {
    foreach ($obj['data'] as $m) {
        $car->delModelFromListByID($m);
    }
} else {
    $car->delModelFromListByID($obj['data']);
}

 $api = '?t=modelList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
