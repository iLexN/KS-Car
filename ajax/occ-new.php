<?php 

/*
{
	url: "ajax/occ-new.php",
	type: "POST",
	data: {	enText : enText,
			zhText : zhText	}
}
*/

include('../db/db_info.php');
include('../model/occ.php');

$zh = $_POST['zhText'];
$en = $_POST['enText'];

if ( !empty($zh) && !empty($en) ) {
	$occ = new Occ();
	$occ->newOcc($en, $zh);
	
	$api = '?t=occ' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
	
} else {
	echo ("ERROR...");
}


