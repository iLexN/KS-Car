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

$tmp = $car->getAllsModel();
$model = [];
foreach ($tmp as $t) {
    $model[$t['id']] = $t;
}

$fp = fopen('make_model.csv', 'w');
$header = false;
foreach ($model as $m) {

            $tmp = $m ;
            $tmp['makename'] = $make[$m['make']];

            if ($header === false) {
                $header = true;
                fputcsv($fp, array_keys($tmp));
            }

            fputcsv($fp, $tmp);


}

fclose($fp);
