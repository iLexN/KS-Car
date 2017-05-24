<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/occ.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];

$occ = new Occ();

$occ->newOcc($data);

$api = '?t=occ' ;
foreach ($refresh_chunk as $k=>$v) {
    file_get_contents($v . $api);
}
