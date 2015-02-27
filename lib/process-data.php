<?php
$process = array();
include('../model/occ.php');
include('../model/car.php');
$car = new Car;
try {
	$allVar['insuranceTypeText'] = $process['insuranceTypeText'] = $car -> getInsuranceTypeByID($allVar['insuranceType']);
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}
try {
    if ( empty($allVar['drivingExpText']) ) {
        $allVar['drivingExpText'] = $process['drivingExpText'] = $car -> getDriveExpByID($allVar['drivingExp']);
    }else{
        $process['drivingExpText'] = $allVar['drivingExpText'];
    }
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}
try {
	$allVar['carMakeText'] = $process['carMakeText'] = $car -> getMakeByID($allVar['carMake']);
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}
try {
	$allVar['carModelText'] = $process['carModelText'] = $car -> getModelByID($allVar['carModel'],$allVar['carModelOther'],$allVar['carMake']);
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}
$occ = new Occ;
try {
    if ( empty($allVar['occupationText']) ){
	$allVar['occupationText'] = $process['occupationText'] = $occ -> getOccByID($allVar['occupation'],$allVar['lang']);
    }else{
        $process['occupationText'] = $allVar['occupationText'];
    }
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}

try {
	$allVar['calYrMf'] = $process['calYrMf'] = $calYrMf = calYrMf($allVar['yearManufacture']);
} catch (Exception $e) {
	$result['error'][] = $e->getMessage();
}

if ( empty($allVar['age']) ) {
	try { 
		$allVar['age'] = $process['age']  = calAge($allVar['dob']);
	} catch (Exception $e) {
		$result['error'][] = $e->getMessage();
	}
} else {
	$process['age'] = $allVar['age'];
}


if ( $driver2 ) {
    $e = 'Driver2';
    try {
        $allVar['drivingExpText2'] = $process['drivingExpText2'] = $car -> getDriveExpByID($allVar['drivingExp2']);
    } catch (Exception $e) {
            $result['error'][] = $e->getMessage() . $e;
    }
    try {
        //$allVar['occupationText2'] = $process['occupationText2'] = $occ -> getOccByID($allVar['occupation2']);
        if ( empty($allVar['occupationText2']) ){
            $allVar['occupationText2'] = $process['occupationText2'] = $occ -> getOccByID($allVar['occupation2'],$allVar['lang']);
        }else{
            $process['occupationText2'] = $allVar['occupationText2'];
        }
    } catch (Exception $e) {
            $result['error'][] = $e->getMessage() . $e;
    }
    try { 
        $allVar['age2'] = $process['age2']  = calAge($allVar['dob2']);
    } catch (Exception $e) {
        $result['error'][] = $e->getMessage();
    }
}