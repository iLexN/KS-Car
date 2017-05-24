<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/Owner.php');

$json = file_get_contents('php://input');
$input = json_decode($json,1);

$id = $_GET['id'];
$owner = new \Owner($id);
$owner->update($input['data']);
