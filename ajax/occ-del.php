<?php

/*
{
    url: "occ-del.php",
    type: "POST",
    data: { occ : $OccList.val()
    }
}
*/

include('../db/db_info.php');
include('../model/occ.php');

//error_log( print_r($_POST,1) );

//$occ = New Occ(intval($_POST['rule']),intval($_POST['occ']));
$occ = new Occ();

$occ->removeOcc($_POST['occ']);
$occ->removeOccRuleByOcids($_POST['occ']);


$api = '?t=occ' ;
foreach ($refresh_chunk as $k=>$v) {
    file_get_contents($v . $api);
}
