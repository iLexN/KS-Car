<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//error_log(print_r($_POST,TRUE) );

include('../db/db_info.php');
include('../model/car.php');

foreach ( $_POST['ruleNcd'] as $k=>$v){
    car::updateRuleNcd($k, $v);
}