<?php

$headerArray = getallheaders();
$auth = $headerArray['Authorization'];
$u = explode(':', base64_decode(substr($auth, 6)), 2);

/**
 * HTTP Basic Authentication
 */


$user = 'ksApi';
$pass = 'mLaE%E9WGQEJU5Q';

// need login
if (!isset($u[0]) || !isset($u[0])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Need Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
} elseif ($u[0] !== $user || $u[1] !== $pass) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    $result = array();
    $result['error'][] = 'Wrong Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}
