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
include('../model/sub-plans.php');

$s = new SubPlans();

$s->updateSubPlans($_POST);
