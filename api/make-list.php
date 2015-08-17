<?php

include('../db/db_info.php');

$m = ORM::for_table('make')->select_many('id', 'make')->where('active', 1)->order_by_asc('make')->find_array();

//$sql = "select id,make from make where active = 1";
//$rs = mysql_query($sql);
$m_ar = array();
//while($row = mysql_fetch_assoc($rs)){
foreach ($m as $row) {
    $m_ar[$row['id']]=$row['make'];
}

$m_ar[9999] = array('en'=>'Other','zh'=>'其他');

unset($m);


echo(json_encode($m_ar));
