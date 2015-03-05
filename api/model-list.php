<?php

include('../ajax/model-list.php');
exit();


include('db/db_info.php');

//$sql = "select id,model from model where make = '{$_GET['mID']}' and active = 1";
//$rs = mysql_query($sql);

$m = ORM::for_table('model')
        ->select_many('id', 'model')
        ->where('make', $_GET['mID'])
        ->where('active', 1)
        ->find_array();

$m_ar = array();
//while($row = mysql_fetch_assoc($rs)){
foreach ($m as $row) {
    $m_ar[$row['id']] = $row['model'];
}


echo(json_encode($m_ar));
