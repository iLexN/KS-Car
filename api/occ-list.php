<?php

include('../db/db_info.php');
include('../model/occ.php');

$occ = new Occ;
$occupation_ar = $occ->getAll();

$occupation_ar[9999] = array(
        'en'=>'Other (please specific)',
        'zh'=>'其他 (請說明)',
        'zh_order' => -10 ,
        'en_order' => -10 
    );

echo(json_encode($occupation_ar));
