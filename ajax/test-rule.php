<?php
$_SERVER['PHP_AUTH_USER'] = 'ksApi';
$_SERVER['PHP_AUTH_PW'] = 'mLaE%E9WGQEJU5Q';


$r = include('../api/getPrice.php');

echo('<pre>');
echo( json_encode($r, JSON_PRETTY_PRINT) );
echo('</pre>');
