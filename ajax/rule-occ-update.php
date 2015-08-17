<?php

/*{
    url: "rule-occ-update.php",
    type: "POST",
    data: { oID : oID}
}
*/

include('../db/db_info.php');
include('../model/occ.php');


if (empty($_POST['oID'])) {
    echo('Error');
    exit();
}

$occ = new Occ;
$occ->removeOccRule(intval($_POST['oID']));


echo(1);
