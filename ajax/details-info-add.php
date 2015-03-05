<?php

/*
{
    url: "occ-add.php",
    type: "POST",
    data: { deIn : $DeInList.val(),
        deInValue : $DeInValue.val(),
        rule : $( "input:radio[name=selectRule]:checked" ).val()
    }
}
*/

include('../db/db_info.php');
include('../model/details-info.php');

$df = new DetailsInfo(intval($_POST['rule']), intval($_POST['deIn']));

if ($df->checkNotExist()) {
    // insert
    $df->addDetailsInfoRule($_POST['deInValue']);
     //echo('done');
} else {
    echo('This detailsInfo already exits in this rule, please check');
}
