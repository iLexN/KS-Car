<?php
             

include('../db/db_info.php');
include('../model/car.php');


$json = file_get_contents('php://input');
$obj = json_decode($json, true);

//error_log( print_r($obj,true) );
//exit();


$car = new Car();

foreach ($obj['data'] as $m) {
    $car->delModelFromListByID($m);
}

 $api = '?t=modelList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
