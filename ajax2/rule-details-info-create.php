<?php

include('../db/db_info.php');
include('../model/details-info.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);





$rule_id = $obj['data']['rule_id'];
$deIn = $obj['data']['detailInfo']['id'];
$deInValue = isset($obj['data']['detailInfo']['value']) ? $obj['data']['detailInfo']['value'] : '';

$df = new DetailsInfo($rule_id, $deIn);

if ($df->checkNotExist()) {
    // insert
    $df->addDetailsInfoRule($deInValue);
     $ar['e'] = '0';
} else {
    $ar['e'] = '1';
}
echo(json_encode($ar));
