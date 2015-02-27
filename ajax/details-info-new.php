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
include('../model/details-info.php');

$zh = $_POST['zhText'];
$en = $_POST['enText'];
$enDesc = $_POST['enTextDesc'];
$zhDesc = $_POST['zhTextDesc'];
$sortOrder = $_POST['sortOrder'];

if ( !empty($zh) && !empty($en) ) {
	$df = new DetailsInfo();
	$df->newDetailsInfo($en, $zh,$enDesc, $zhDesc,$sortOrder);
	
	$api = '?t=planRow' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
	
} else {
	echo ("ERROR...");
}

