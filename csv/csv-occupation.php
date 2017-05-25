<?php

require_once '../db/db_info.php';
include('../model/occ.php');



$occ = new Occ;

$ar = $occ->getAlls();

$filename = 'occupation' . date('Y-m-d') . '.csv';

$fp = fopen($filename, 'w');
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
$header = false;
foreach ($ar as $m) {

            //$tmp = $m ;
            $tmp = [];
            $tmp['id'] = $m['id'];
            $tmp['zh'] = $m['zh'];
            $tmp['en'] = $m['en'];

            if ($header === false) {
                $header = true;
                fputcsv($fp, array_keys($tmp));
            }

            fputcsv($fp, $tmp);
}

fclose($fp);

header('Content-Type: type:application/csv;');
header('Content-Disposition: attachment; filename="'.$filename.'"');
readfile($filename);