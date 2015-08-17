<?php

/*
{
        url: "ajax/rule-details-update.php",
        type: "POST",
        data: { id : id,
            file_content : $DetialsTextarea.val();
        }
}
*/

include('../db/db_info.php');
include('../model/rule.php');



$r = new Rule($_POST['id']);

$r->putDetails($_POST['file_content'], __DIR__ . '/../');
