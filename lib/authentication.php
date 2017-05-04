<?php

$headerArray = getallheaders();

if (array_key_exists('Authorization', $headerArray) ) {
    $authKey = 'Authorization';
} else {
    $authKey = 'authorization';
}

$auth = $headerArray[$authKey];
$u = explode(':', base64_decode(substr($auth, 6)), 2);

/**
 * HTTP Basic Authentication
 */

// need login
if (!isset($u[0]) || !isset($u[0])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    header('Content-Type: application/json');
    $result = array();
    $result['error'][] = 'Need Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
//} elseif ($u[0] !== $user || $u[1] !== $pass) {
} elseif (!array_key_exists($u[0], $authInfo) || $u[1] !== $authInfo[$u[0]]) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    header('Content-Type: application/json');
    $result = array();
    $result['error'][] = 'Wrong Login';
    $result['result'] = -1;
    echo json_encode($result);
    exit;
}
