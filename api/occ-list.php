<?php

include('../db/db_info.php');
include('../model/occ.php');

$occ = New Occ;
$occupation_ar = $occ->getAll();

$occupation_ar[9999] = array('en'=>'Other','zh'=>'其他');

echo (json_encode($occupation_ar));
