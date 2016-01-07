<?php

include('../db/db_info.php');
include('../model/car.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$data = $obj['data'];



foreach ( $data as $v){
    $save_ar = array();
    $save_ar['active'] = $v['active'];
    $save_ar['price_add'] = $v['price_add'];
    car::updateRuleNcd($v['id'], $save_ar);
}
