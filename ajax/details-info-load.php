<?php 

/*
url: "ajax/make-model.php",
                type: "GET",
                data: {id: id},
                dataType: "json"
*/

include('../db/db_info.php');
include('../model/details-info.php');

$df = new DetailsInfo();

$rs = $df->getDetailsInfoByID($_GET['id'], 'all');

echo( json_encode($rs) );

