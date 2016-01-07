<?php

include('../db/db_info.php');
include('../model/car.php');

$c = new Car;
$r = $c->getNCD();

echo(json_encode($r));
