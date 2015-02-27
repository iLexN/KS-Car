<?php

/**
 * Gen all the check from db
 */

include('../db/db_info.php');
$api = array();
$api['driveExp'] = 'drive-exp-list.php'; //motorDriveExpListData
$api['makeList'] = 'make-list.php'; //motorMakeListData
$api['modelList'] = 'model-list-all.php'; //motorModelListData
$api['ncd'] = 'ncd-list.php';//motorNcdListData
$api['occ'] = 'occ-list.php';//motorOccListData
$api['insType'] = 'insurance-type-list.php';//motorInsuranceTypeListData
$api['planRow'] = 'details-info-list.php';//motorPlanRowListData


foreach ( $api as $t=> $url){
    $apiUrl = '?t='.$t ;
    foreach ( $refresh_chunk as $k=>$v ) {
        $c = file_get_contents($v . $apiUrl);
        echo($t . " is Done (". $c .") <br/>\n");
    }
}

/*

	$api = '?t=occ' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
	
        $api = '?t=makeList' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
        
        $api = '?t=modelList' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
        
        $api = '?t=insType' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
        
        $api = '?t=planRow' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}
 * 
 */