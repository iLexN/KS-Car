<?php

include('../db/db_info.php');
include('../model/car.php');

$car = new Car;
$m_ar = $car->getModelByMake($_GET['mID']);

echo(json_encode($m_ar));
