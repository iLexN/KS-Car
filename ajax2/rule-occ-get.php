<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/occ.php');

$occ = new Occ;
$occ_ar = $occ->getByRule($_GET['id']);
header('Content-Type: application/json');
echo(json_encode($occ_ar));
