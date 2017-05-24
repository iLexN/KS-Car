<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/rule.php');
include('../model/car.php');


$rule = new Rule();
$id = $rule->newRule();

//ncd
$c = new car();
$ncd_ar = $c->getNCD();
foreach ($ncd_ar as $k=>$v) {
    car::createRuleNcd($id, $k, 0);
}

