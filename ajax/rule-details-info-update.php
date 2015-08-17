<?php

/*{
                      url: "ajax/rule-details-info-update.php",
                      type: "POST",
                      data: { oID : oID,
                             type : 'update',  // update // remove
                             value : $(this).val()
                             
                      }
                    }
*/

include('../db/db_info.php');
include('../model/details-info.php');


if (empty($_POST['oID'])) {
    echo('Error');
    exit();
}

$df = new DetailsInfo;

if ($_POST['type'] == 'remove') {
    $df->removeDetailsInfoRule(intval($_POST['oID']));
} elseif ($_POST['type'] == 'update') {
    $df->updateDetailsInfoRule(intval($_POST['oID']), $_POST['value']);
} else {
    echo('Error .. .');
    exit();
}

echo(1);
