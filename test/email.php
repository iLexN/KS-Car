<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('../lib/function.inc.php');

try {
    checkEmail(' cheuk1998@gmail.com');
    echo('1');
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
    print_r($result);
}