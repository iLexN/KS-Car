<?php           

include('../db/db_info.php');
include('../model/car.php');



$car = new Car();

$insuranceType = $car->getInsuranceType(1);



echo(json_encode($insuranceType));
