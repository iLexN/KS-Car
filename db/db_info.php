<?php
error_reporting(E_ALL);

$host = "localhost";
$dbname = "ks-car2";
//$dbname = "ks-car20141022";
$dbusername = "root";
$dbpassword = "";


require_once( dirname(__FILE__) . "/../lib/idiorm.php");
ORM::configure('mysql:host='.$host.';dbname='.$dbname);
ORM::configure('username', $dbusername);
ORM::configure('password', $dbpassword);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
ORM::configure('return_result_sets', true); 
ORM::configure('logging', false );
ORM::configure('logger', function($log_string, $query_time) {
   echo $log_string . ' in ' . $query_time . '<br/>';
});

//$checkCode = 'motor.V1.abc';


$refresh_chunk = array();
$refresh_chunk['ks.com'] = 'http://kwiksure.localhost/gen-motor-chunk/';
//$refresh_chunk['car.ins'] = 'http://ks-modx.dev/genmotorchunk/';
//$refresh_chunk['car.zh.hk'] = 'http://ks-modx-zh.dev/genmotorchunk/';
