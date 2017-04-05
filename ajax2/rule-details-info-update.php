<?php

include('../db/db_info.php');
include('../model/details-info.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

$df = new DetailsInfo;

foreach ($data as $ar) {
    $df->updateDetailsInfoRule($ar['id'], $ar['value']);
}
