<?php

/*

{
                      url: "ajax/rule-add.php",
                      type: "POST",
                      data: { make : $MakeList.val(),
                            model : $ModelList.val(),
                            rule : $( "input:radio[name=selectRule]:checked" ).val()
                        }
                    }
*/
                  

include('../db/db_info.php');
include('../model/car.php');



$car = new Car(intval($_POST['rule']), intval($_POST['model']));

//print_r($_POST);



// TODO : need test here.
$e = false;
foreach ($_POST['model'] as $m) {
    if ($car->checkNotExist($m)) {
        // insert
        $car->addModelRule($m);
    } else {
        //echo ('There have model already exits in this rule, please check');
        $e = true;
    }
}

if ($e) {
    echo('There have model already exits in this rule, please check');
}
