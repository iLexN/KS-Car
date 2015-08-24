<?php             

include('../db/db_info.php');
include('../model/car.php');



$c = new car();
$ncd_ar = $c->getNCD();

foreach ( $ncd_ar as $k=>$v){
    car::createRuleNcd($_POST['id'], $k, 0);
}

