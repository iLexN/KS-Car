<?php 

/*
{
                        url: "ajax/model-del.php",
                        type: "POST",
                        data: {
                            model: $ModelList.val()
                        }
                    }
*/  
                  

include('../db/db_info.php');
include('../model/car.php');



$car = new Car();

foreach ( $_POST['model'] as $m ) {
    $car->delModelFromListByID($m);
}

 $api = '?t=modelList' ;
	foreach ( $refresh_chunk as $k=>$v ) {
		file_get_contents($v . $api);
	}


