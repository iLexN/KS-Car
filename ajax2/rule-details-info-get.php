<?php

/*
{
    url: "rule-occ-get.php",
    type: "GET",
    data: { id : id },
    dataType: "json"
}
*/

include('../db/db_info.php');
include('../model/details-info.php');

$df = new DetailsInfo;
$df_ar = $df->getByRule($_GET['id']);


$out = array();
foreach ($df_ar as $ar) {
    $out[] = $ar;
}


echo(json_encode($out));
