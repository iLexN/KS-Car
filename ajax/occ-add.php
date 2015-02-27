<?php 

/*
{
	url: "occ-add.php",
	type: "POST",
	data: { occ : $OccList.val(),
		rule : $( "input:radio[name=selectRule]:checked" ).val()
	}
}
*/

include('../db/db_info.php');
include('../model/occ.php');

//$occ = New Occ(intval($_POST['rule']),intval($_POST['occ']));
$occ = New Occ(intval($_POST['rule']));

$e = false;
foreach ( $_POST['occ'] as $occID ) {
    if ( $occ->checkNotExist($occID) ) {
        // insert 
        $occ->addOccRule($occID);
         //echo('done');
    } else {
        //echo ('This Occupation already exits in this rule, please check');
         $e = true;
    }
}

if ( $e ) {
    echo ('This Occupation already exits in this rule, please check');
}