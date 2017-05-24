<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/car.php');

$car = new Car;
$make_ar = $car->getAllsMake();

header('Content-Type: application/json');
echo(json_encode($make_ar));
