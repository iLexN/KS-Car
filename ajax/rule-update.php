<?php

/*var request = $.ajax({
		url: "rule-update.php",
		type: "POST",
		data: { mID : mID}
	});
*/

include('../db/db_info.php');

include('../model/car.php');

if ( empty($_POST['mID']) ) {
	echo('Error');
	exit();
}

$car = new Car();
$car->removeModelRule(intval($_POST['mID']));
echo(1);

