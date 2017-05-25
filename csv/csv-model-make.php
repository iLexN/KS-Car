<?php

require_once '../db/db_info.php';
include('../model/occ.php');
include('../model/car.php');
include('../model/calTotalPrice.php');

$car = new Car();
$occ = new Occ;

$make = array_column($car->getAllsMake(), 'make', 'id');

$tmp = $car->getAllsModel();
$model = [];
foreach ($tmp as $t) {
    $model[$t['id']] = $t;
}

uasort($model, function ($a, $b) {
    if ($a['make'] == $b['make']) {
        return ($a['id'] < $b['id']) ? -1 : 1;
    }
    return ($a['make'] < $b['make']) ? -1 : 1;
}
);

$filename = 'make_model' .date('Y-m-d'). '.csv';

$fp = fopen($filename, 'w');
$header = false;
foreach ($model as $m) {

            //$tmp = $m ;
            $tmp = [];
            $tmp['model_id'] = $m['id'];
            $tmp['model_name'] = (string)$m['model'];
            $tmp['make_id'] = $m['make'];
            $tmp['make_name'] = $make[$m['make']];

            if ($header === false) {
                $header = true;
                fputcsv($fp, array_keys($tmp));
            }

            fputcsv($fp, $tmp);
}

fclose($fp);

header('Content-Type: type:application/csv;charset=UTF-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);
