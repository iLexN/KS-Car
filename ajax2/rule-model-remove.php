<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/car.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

$car = new Car();
$car->removeModelRule(intval($data['id']));
