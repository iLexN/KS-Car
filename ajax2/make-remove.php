<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/car.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$car = new Car();


$car->delMakeFromListByID($obj['data']);

$api = '?t=makeList' ;
foreach ($refresh_chunk as $k=>$v) {
    file_get_contents($v . $api);
}
