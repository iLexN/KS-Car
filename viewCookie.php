<?php

header('Content-Type: application/javascript;charset=utf-8 ');
$cookieValueJson = $_COOKIE['_KSMotor'];
$cookieValueArray = json_decode($cookieValueJson,true);
print_r($cookieValueArray);


