<?php

include('../db/db_info.php');
include('../model/details-info.php');

$detailsInfo = new DetailsInfo;
$detailsInfo_ar = $detailsInfo->getAlls();



echo(json_encode($detailsInfo_ar));
