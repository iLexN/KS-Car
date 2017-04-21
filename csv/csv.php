<?php

require_once '/db/db_info.php';
include('model/occ.php');
include('model/car.php');
include('model/calTotalPrice.php');

$car = new Car();
$occ = new Occ;

$rules = ORM::for_table('rule')
            ->where('TypeofInsurance', 'Third_Party_Only')
            ->where('active', 1)
            ->order_by_asc('id')
            //->limit(1)
            ->find_array();

$make = array_column($car->getAllsMake(), 'make', 'id');
//print_r($make);

$tmp = $car->getAllsModel();
$model = [];
foreach ($tmp as $t) {
    $model[$t['id']] = $t;
}
//print_r($model);

$tmp = ORM::for_table('rule-model')->find_array();
$rulesModel = [];
foreach ($tmp as $t) {
    $rulesModel[$t['rule']][$t['model']]['make'] = $make[$model[$t['model']]['make']];
    $rulesModel[$t['rule']][$t['model']]['model'] = $model[$t['model']]['model'];
}
//print_r($rulesModel);

//$occInfo = $occ->getAlls();
$occInfo = array_column($occ->getAlls(), 'en', 'id');
//print_r($occInfo);
$tmp = ORM::for_table('rule-occ')->find_array();
$rulesOcc = [];
foreach ($tmp as $t) {
    $rulesOcc[$t['rule']][$t['occ']] = $occInfo[$t['occ']];
}
//print_r($rulesOcc);

//$ncd = $car->getNCD();
$tmp = ORM::for_table('rule-ncd')->where('active', 1)->find_array();
$rulesNcd = [];
foreach ($tmp as $t) {
    $rulesNcd[$t['rule_id']][$t['ncd']] = $t;
}
//print_r($rulesNcd);

//$out = [];
$fp = fopen('file.csv', 'w');
$header = false;
foreach ($rules as $rule) {
    //print_r($rule);
    foreach ($rulesModel[$rule['id']] as $mInfo) {
        //print_r($mInfo);
        foreach ($rulesOcc[$rule['id']] as $oInfo) {
            //print_r($oInfo);
            $ncd =[];
            foreach ($rulesNcd[$rule['id']] as $nInfo) {
                //print_r($nInfo);
                $cal = new CalTotalPrice($rule);
                $calpriceAR =  $cal->calPrice($nInfo['ncd'], $nInfo['price_add'], 'Third_Party_Only');
                //print_r($calpriceAR);

                $ncd['ncd '.$nInfo['ncd']. ' price'] = $calpriceAR['price'];
                $ncd['ncd '.$nInfo['ncd']. ' total price'] = $calpriceAR['total_price'];
            }
            $tmp_ar = array_merge($rule, $mInfo, ['occ'=>$oInfo], $nInfo, $ncd);

            unset($tmp_ar['active']);
            unset($tmp_ar['a2']);
            unset($tmp_ar['a3']);
            unset($tmp_ar['rule_id']);
            unset($tmp_ar['id']);
            unset($tmp_ar['premium']);
            unset($tmp_ar['loading']);
            unset($tmp_ar['otherDiscount']);
            unset($tmp_ar['clientDiscount']);
            unset($tmp_ar['mib']);
            unset($tmp_ar['commission']);
            unset($tmp_ar['price_add']);
            unset($tmp_ar['gross']);
            unset($tmp_ar['mibValue']);
            unset($tmp_ar['ncd']);

            if ($header === false) {
                $header = true;
                fputcsv($fp, array_keys($tmp_ar));
            }

            fputcsv($fp, $tmp_ar);
            //break;
        }
        //break;
    }
}

fclose($fp);
