<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/car.php');

$car = new Car();

$driveExp = $car->getDriveExp(1);

$out = array_map(function ($a) {
    return htmlspecialchars_decode($a);
}, $driveExp);


header('Content-Type: application/json');
echo(json_encode($out));
