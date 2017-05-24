<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/ComprehensiveRange.php');

$cr = new \ComprehensiveRange();
$ar = $cr->getList($_GET['id']);

echo( json_encode($ar));

