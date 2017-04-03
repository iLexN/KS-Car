<?php

//$headerArray = apache_request_headers();

//error_log($_SERVER['HTTP_AUTHORIZATION']);
//error_log($_SERVER['PHP_AUTH_USER']);
//error_log(print_r($headerArray,1));

/**
 * HTTP Basic Authentication
 */
/******
$user = 'ksApi';
$pass = 'mLaE%E9WGQEJU5Q';


// need login
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Need Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}else if ($_SERVER['PHP_AUTH_USER'] !== $user || $_SERVER['PHP_AUTH_PW'] !== $pass) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Wrong Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}
***/