<?php
/**
 * HTTP Basic Authentication
 */



$user = 'ksApi';
$pass = 'mLaE%E9WGQEJU5Q';

//$_SERVER['PHP_AUTH_USER'] = $user;
//$_SERVER['PHP_AUTH_PW']  = $pass;


if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_USER']) ) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Need Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}

//echo($_SERVER['PHP_AUTH_USER']);
//echo("<br/>\n");
//echo($_SERVER['PHP_AUTH_PW']);

/*
if ( $_SERVER['PHP_AUTH_USER'] == $user && $_SERVER['PHP_AUTH_PW'] == $pass ) {
    echo 'Good';
    print_r($_POST);
} else {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'wrong .. login';
    exit;
}*/
if ( $_SERVER['PHP_AUTH_USER'] !== $user || $_SERVER['PHP_AUTH_PW'] !== $pass ) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Wrong Loing';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}