<?php

/*
{
    url: "ajax/occ-new.php",
    type: "POST",
   data: {enText: enText,
                        zhText: zhText,
                        en_order: enOrder,
                        zh_order: zhOrder,
                        id:id
                    }
}
*/

include('../db/db_info.php');
include('../model/occ.php');

$zh = $_POST['zhText'];
$en = $_POST['enText'];
$zh_order = $_POST['zh_order'];
$en_order = $_POST['en_order'];
$id = $_POST['id'];


if (!empty($zh) && !empty($en) && !empty($id) ) {
    $occ = new Occ();
    $occ->updateOcc($en, $zh,$id,$en_order,$zh_order);
    
    $api = '?t=occ' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
} else {
    echo("ERROR...");
}
