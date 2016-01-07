<?php

include('../db/db_info.php');
include('../model/occ.php');

$occ = new Occ;
$occ_ar = $occ->getByRule($_GET['id']);

echo(json_encode($occ_ar));
