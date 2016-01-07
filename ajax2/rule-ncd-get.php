<?php             

include('../db/db_info.php');
include('../model/car.php');
include('../model/rule.php');
include('../model/calTotalPrice.php');



$c = new car();

$r = new Rule($_GET['id']);
$r->getOne();

$cal = new CalTotalPrice($r->rule->as_array());

$ar = car::getRuleNcd($_GET['id']);

if ( $r->rule->TypeofInsurance != 'Third_Party_Only' ) {
    echo(json_encode($ar));
    
} else {
    $out = array();
foreach ( $ar as $k => $v ){
    $calpriceAR =  $cal->calPrice($v['ncd'], $v['price_add']);
    $out[$k] = array_merge($calpriceAR, $v);
}
echo(json_encode($out));
}



