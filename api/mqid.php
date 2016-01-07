<?php
include '../db/db_info.php';

$mqid = (isset($_POST['mqid']) && !empty($_POST['mqid']))  ? $_POST['mqid'] : false;

$mode = (isset($_POST['mode']) && in_array($_POST['mode'], array('write','remove')  ) )  ? $_POST['mode'] : false;

$result = array();



if ( !$mqid ) {
    $result['result'] = -1 ;
    $result['desc'][] = 'Need mqid';
}

if ( !$mode ) {
    $result['result'] = -1 ;
    $result['desc'][] = 'Wrong mode';
}


if  ($mode == 'write'){
    $a = ORM::for_table('mqid')->create();
    $a->mqid = $mqid;
    $a->datetime = date('Y-m-d H:i:s');
    $a->save();
    $result['result'] = 1 ;
    $result['desc'][] = 'write mode';
} 

if ($mode == 'remove'){
   $a = ORM::for_table('mqid')->where('mqid',$mqid)->delete_many();
   $result['result'] = 1 ;
   $result['desc'][] = 'remove mode';
}

echo(json_encode($result));

