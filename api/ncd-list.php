<?php

include('../db/db_info.php');
include('../model/car.php');

$c = New Car;
$r = $c->getNCD(2);

echo (json_encode($r));
