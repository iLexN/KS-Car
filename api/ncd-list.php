<?php

include('../db/db_info.php');
include('../model/car.php');

$c = new Car;
$r = $c->getNCD(2);

echo(json_encode($r));
