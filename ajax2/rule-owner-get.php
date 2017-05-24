<?php
include('../lib/checkip.php');
include('../db/db_info.php');
include('../model/Owner.php');

$id = $_GET['id'];

$owner = new \Owner($id);

$out = [];

foreach ( $owner->getOwner() as $ar)
{
    $out[] = $ar['owner'];
}


echo(json_encode($out));
