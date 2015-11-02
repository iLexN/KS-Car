<?php

include('../db/db_info.php');
include('../model/car.php');

$car = new Car();
$model_ar = $car->getModelByRule($_GET['id']);


echo(json_encode($model_ar));
