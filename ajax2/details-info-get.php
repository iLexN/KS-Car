<?php

include('../db/db_info.php');
include('../model/details-info.php');

$detailsInfo = new DetailsInfo;
$detailsInfo_ar = $detailsInfo->getAlls();


header('Content-Type: application/json');
echo(json_encode($detailsInfo_ar));
