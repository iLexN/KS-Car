<?php
/*
data:  {
                            id : id
                        }
}*/

include('../db/db_info.php');
include('../model/rule.php');

//print_r($_POST);
//exit();

if (empty($_POST['id'])) {
    echo('Error');
    exit();
}

$rule = new Rule(intval($_POST['id']));
$rule->reMoveRule();


echo('updated success');
