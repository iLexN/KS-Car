<?php

include('../db/db_info.php');
include('../model/occ.php');

$occ = new Occ;
$occupation_ar = $occ->getAlls();



echo(json_encode($occupation_ar));
