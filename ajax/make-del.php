<?php

/*
{
                        url: "ajax/make-del.php",
                        type: "POST",
                        data: {
                            make: $MakeList.val()
                        }
                    }
*/
                  

include('../db/db_info.php');
include('../model/car.php');



$car = new Car();


    $car->delMakeFromListByID($_POST['make']);

    $api = '?t=makeList' ;
    foreach ($refresh_chunk as $k=>$v) {
        file_get_contents($v . $api);
    }
