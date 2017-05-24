<?php

if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] !== '125.214.232.21') {
    header('Location: https://kwiksure.com/');
    exit();
}

