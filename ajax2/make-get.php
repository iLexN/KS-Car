<?php
            

include('../db/db_info.php');
include('../model/car.php');



$car = new Car;
$make_ar = $car->getAllsMake();



echo(json_encode($make_ar));
