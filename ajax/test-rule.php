<?php
$_SERVER['PHP_AUTH_USER'] = 'ksApi';
$_SERVER['PHP_AUTH_PW'] = 'mLaE%E9WGQEJU5Q';


$r = include('../api/getPrice.php');

echo('<pre>');
print_r($r);
echo('</pre>');
