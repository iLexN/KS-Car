<?php

include('../db/db_info.php');
include('../model/car.php');

$c = New Car();
$m_ar = $c->getAllModel();

echo (json_encode($m_ar));