<?php

include('../db/db_info.php');
include('../model/details-info.php');

$df = new DetailsInfo;
$df_ar = $df->getAll();

echo(json_encode($df_ar));
