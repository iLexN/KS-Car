<?php

include('../db/db_info.php');
include('../model/occ.php');

$occ = new Occ;
$occupation_ar = $occ->getAlls();

header('Content-Type: application/json');
echo(json_encode($occupation_ar));
