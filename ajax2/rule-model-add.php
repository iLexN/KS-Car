<?php
          

include('../db/db_info.php');
include('../model/car.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

//error_log( print_r($obj,1) );
//exit();

$car = new Car($obj['data']['rule_id']);

//print_r($_POST);




foreach ($obj['data']['model'] as $m) {
    if ($car->checkNotExist($m)) {
        $car->addModelRule($m);
    }
}


