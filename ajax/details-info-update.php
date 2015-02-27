<?php 

/*
data: {enText: enText,
                        zhText: zhText,
                        enTextDesc: enTextDesc,
                        zhTextDesc: zhTextDesc,
                        id : id
}
*/

include('../db/db_info.php');
include('../model/details-info.php');

$df = new DetailsInfo();
$df->updateDetailsInfoByID($_POST);

$api = '?t=planRow' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}




