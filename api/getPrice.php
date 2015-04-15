<?php

include '../lib/authentication.php';


require_once '../db/db_info.php';

/***
flow:
1 define data
2 check data
3 process data
4 find match rule/plan
isTest from tool return array / real api echo json
*****/

//checking function start
include '../lib/function.inc.php';

error_log( print_r($_POST,1) );

if (empty($_POST)) {
    exit();
}

/* need more safe being hack?
$k = isset ( $_POST['k'] ) ? $_POST['k'] : '';
$v = isset ( $_POST[$k] ) ? $_POST[$k] : '';
if ($v != $checkCode) { echo ('stop');exit(); };
 */

// for json return
$result = array();

//error_log('Post ar');
//error_log( print_r($_POST,true) );

$allVar['refID'] = (isset($_POST['refID']) && !empty($_POST['refID']))  ? $_POST['refID'] : false;

// rule data (required)
$allVar['dob'] = (isset($_POST['dob']) && !empty($_POST['dob']))  ? $_POST['dob'] : '00-00-0000'; // 25-02-2014
$allVar['age'] = isset($_POST['age']) ? $_POST['age'] : ''; // provide age/dob
$allVar['ncd'] = isset($_POST['ncd']) ? $_POST['ncd'] : '100';
$allVar['drivingExp'] = isset($_POST['drivingExp']) ? $_POST['drivingExp'] : '';
$allVar['drivingExpText'] = isset($_POST['drivingExpText']) ? $_POST['drivingExpText'] : '' ;
$allVar['insuranceType'] = $_POST['insuranceType'];
$allVar['yearManufacture'] = $_POST['yearManufacture'];  // 2010
$allVar['carMake']  = $_POST['carMake'];
$allVar['carModel']  = isset($_POST['carModel']) ? $_POST['carModel'] : '';
$allVar['carModelOther'] = isset($_POST['carModelOther']) ? $_POST['carModelOther'] : '';
$allVar['occupation'] =  isset($_POST['occupation']) ? $_POST['occupation'] : '' ;
$allVar['occupationText'] = isset($_POST['occupationText']) ? $_POST['occupationText'] : '' ;
$allVar['motor_accident_yrs']  = isset($_POST['motor_accident_yrs']) ? $_POST['motor_accident_yrs'] : null; //Did the main driver have any accidents or claims in the last 3 years?
$allVar['drive_offence_point']  = isset($_POST['drive_offence_point']) ? $_POST['drive_offence_point'] : null; //Did the main driver have any driving offence points in the last 2 years

//user data or car data
$allVar['name'] =  isset($_POST['name']) ? $_POST['name'] : '';
$allVar['email'] =  isset($_POST['email']) ? $_POST['email'] : '';
$allVar['contactno'] = isset($_POST['contactno']) ? $_POST['contactno'] : '';
$allVar['address'] = isset($_POST['address']) ? $_POST['address'] : '';
$allVar['address2'] = isset($_POST['address2']) ? $_POST['address2'] : '';
$allVar['address3'] = isset($_POST['address3']) ? $_POST['address3'] : '';
$allVar['address4'] = isset($_POST['address4']) ? $_POST['address4'] : '';
$allVar['residential_district'] = isset($_POST['residential_district']) ? $_POST['residential_district'] : ''; // address line 5
$allVar['gender'] = isset($_POST['gender']) ? $_POST['gender'] : '';
$allVar['marital_status'] = isset($_POST['marital_status']) ? $_POST['marital_status'] : '';
$allVar['lang'] = isset($_POST['lang']) ? $_POST['lang'] : 'en';
$allVar['hkid_1'] = isset($_POST['hkid_1']) ? $_POST['hkid_1'] : '';
$allVar['hkid_2'] = isset($_POST['hkid_2']) ? $_POST['hkid_2'] : '';
$allVar['hkid_3'] = isset($_POST['hkid_3']) ? $_POST['hkid_3'] : '';
$allVar['vehicle_registration'] = isset($_POST['vehicle_registration']) ? $_POST['vehicle_registration'] : '' ;
$allVar['yearly_mileage'] = isset($_POST['yearly_mileage']) ? $_POST['yearly_mileage'] : '';
$allVar['referer'] = (isset($_POST['referer']) && !empty($_POST['referer'])) ? $_POST['referer'] : 'kwiksure';
$allVar['policy_start_date'] = (isset($_POST['policy_start_date']) && !empty($_POST['policy_start_date']))  ? $_POST['policy_start_date'] : ''; // 25-02-2014
$allVar['policy_end_date'] = (isset($_POST['policy_end_date']) && !empty($_POST['policy_end_date']))  ? $_POST['policy_end_date'] : ''; // 25-02-2014
$allVar['drive_to_work']  = isset($_POST['drive_to_work']) ? $_POST['drive_to_work'] : null;
$allVar['course_of_work']  = isset($_POST['course_of_work']) ? $_POST['course_of_work'] : null;
$allVar['convictions_5_yrs']  = isset($_POST['convictions_5_yrs']) ? $_POST['convictions_5_yrs'] : null;
$allVar['sum_insured']  = isset($_POST['sum_insured']) ? $_POST['sum_insured'] : '0.00';

// additional car data
$allVar['bodyType']  = isset($_POST['bodyType']) ? $_POST['bodyType'] : '';
$allVar['numberOfDoors']  = isset($_POST['numberOfDoors']) ? $_POST['numberOfDoors'] : '';
$allVar['chassisNumber']  = isset($_POST['chassisNumber']) ? $_POST['chassisNumber'] : '';
$allVar['engineNumber']  = isset($_POST['engineNumber']) ? $_POST['engineNumber'] : '';
$allVar['cylinderCapacity']  = isset($_POST['cylinderCapacity']) ? $_POST['cylinderCapacity'] : '';
$allVar['numberOfSeats']  = isset($_POST['numberOfSeats']) ? $_POST['numberOfSeats'] : '';

//driver2
$allVar['name2'] =  isset($_POST['name2']) ? $_POST['name2'] : '';
$allVar['email2'] =  isset($_POST['email2']) ? $_POST['email2'] : '';
$allVar['gender2'] = isset($_POST['gender2']) ? $_POST['gender2'] : '';
$allVar['relationship2'] = isset($_POST['relationship2']) ? $_POST['relationship2'] : '';
$allVar['dob2'] = (isset($_POST['dob2']) && !empty($_POST['dob2']))  ? $_POST['dob2'] : '00-00-0000'; // 25-02-2014
$allVar['marital_status2'] = isset($_POST['marital_status2']) ? $_POST['marital_status2'] : '';
//$allVar['residential_district2'] = isset ( $_POST['residential_district2'] ) ? $_POST['residential_district2'] : '';
$allVar['hkid_1_2'] = isset($_POST['hkid_1_2']) ? $_POST['hkid_1_2'] : '';
$allVar['hkid_2_2'] = isset($_POST['hkid_2_2']) ? $_POST['hkid_2_2'] : '';
$allVar['hkid_3_2'] = isset($_POST['hkid_3_2']) ? $_POST['hkid_3_2'] : '';
$allVar['motor_accident_yrs2']  = isset($_POST['motor_accident_yrs2'])    ? $_POST['motor_accident_yrs2'] : null;
$allVar['drive_offence_point2']  = isset($_POST['drive_offence_point2']) ? $_POST['drive_offence_point2'] : null;
$allVar['drivingExp2'] = isset($_POST['drivingExp2']) ? $_POST['drivingExp2'] : '';
$allVar['occupation2'] =  isset($_POST['occupation2']) ? $_POST['occupation2'] : '' ;
$allVar['occupationText2'] =  isset($_POST['occupationText2']) ? $_POST['occupationText2'] : '' ;

// no need process if driver2 not exist
$allVar['drivingExpText2'] = '';
$allVar['age2'] = '';

//error_log('allvar');
//error_log( print_r($allVar,true) );

//special change the flow start
$isTest = isset($_POST['testRule']) ? true : false;
if ($isTest) {
    $saveUser = false;
}
$saveUser = (isset($_POST['isSave']) && $_POST['isSave']) ? true : false;
$skipFindRule = (isset($_POST['skipFindRule']) && $_POST['skipFindRule']) ? true : false;
// special change end

$allVar['planID'] = $planID = (isset($_POST['planID']) && !empty($_POST['planID'])) ? $_POST['planID'] : false;
$allVar['subPlanID']  = (isset($_POST['subPlanID']) && !empty($_POST['subPlanID'])) ? $_POST['subPlanID'] : false;

//for checking stat
$allVar['payButtonClick'] = (isset($_POST['payButtonClick']) && !empty($_POST['payButtonClick'])) ? 1 : 0;

//checking  for rule data ( must fill in data for rule )
/*try {
    checkEmpty('ncd',$ncd) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}*/
try {
    checkEmpty('drivingExp', $allVar['drivingExp'], $allVar['drivingExpText']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
try {
    checkEmpty('insuranceType', $allVar['insuranceType']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
try {
    checkEmpty('yearManufacture', $allVar['yearManufacture']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
try {
    checkEmpty('carMake', $allVar['carMake']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
try {
    $allVar['lang'] = checkLang($allVar['lang']);
} catch (Exception $ex) {
    $result['error'][] = $e->getMessage();
}
try {
    if (!empty($allVar['carModelOther'])) {
        $allVar['carModel'] = $allVar['carModelOther'];
    }
    checkEmpty('carModel', $allVar['carModel']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
try {
    checkEmpty('occupation', $allVar['occupation'], $allVar['occupationText']) ;
} catch (Exception $e) {
    $result['error'][] = $e->getMessage();
}
if (!empty($allVar['hkid_1']) || !empty($allVar['hkid_2']) || !empty($allVar['hkid_3'])) {
    // not must fill in, but need check format
        try {
            check_hkid($allVar['hkid_1'] . $allVar['hkid_2'], $allVar['hkid_3']) ;
        } catch (Exception $e) {
            $result['error'][] = $e->getMessage();
        }
}

//if driver 2 exist
$driver2 = false;
if (!empty($allVar['occupation2']) && !empty($allVar['drivingExp2'])) {
    $driver2 = true;
    if (!empty($allVar['hkid_1_2']) || !empty($allVar['hkid_2_2']) || !empty($allVar['hkid_3_2'])) {
        // not must fill in, but need check format
            try {
                check_hkid($allVar['hkid_1_2'] . $allVar['hkid_2_2'], $allVar['hkid_3_2']) ;
            } catch (Exception $e) {
                $result['error'][] = $e->getMessage() . ' (hkid 2) ';
            }
    }
}

//checking for user data must fill in data for user
if ($saveUser) {
    try {
        checkEmpty('name', $allVar['name']) ;
    } catch (Exception $e) {
        $result['error'][] = $e->getMessage();
    }
    try {
        checkEmpty('contactno', $allVar['contactno']) ;
    } catch (Exception $e) {
        $result['error'][] = $e->getMessage();
    }
    try {
        checkEmpty('email', $allVar['email']) ;
    } catch (Exception $e) {
        $result['error'][] = $e->getMessage();
    }
    try {
        checkEmail($allVar['email']) ;
    } catch (Exception $e) {
        $result['error'][] = $e->getMessage();
    }
        
        //back up email ?
        /*
        $body = 'Post : ' . print_r($_POST,true) .
                'All : ' . print_r($allVar,true) ;
        mail('email','subjust',$body);*/
}

// extra process data , transfer id to text
include '../lib/process-data.php';

// stop and return with error
if (!empty($result['error'])) {
    $result['result'] = -1;
    $result['resultDesc'][] = '300 checking have error';

    if (!$isTest) {
        //error_log( print_r($result,true) );
        //echo json_encode($result);
        file_put_contents('../log/'.date('Ymd').'.log', date('H:i:s') . "\n\t" . json_encode($result) ."\n\t"  . json_encode($allVar) . PHP_EOL, FILE_APPEND);
    } else {
        return $result;
    }
    exit();
}

// find rule
if ($skipFindRule) {
    $match_rule = false;
    $save_rule= array();
} else {
    include '../lib/find-rule.php';
}

if ($match_rule) {
    $result['result'] = 1;
    $result['resultDesc'][] = '100 : Plan find';
    $result['plans'] = $match_rule;
    $result['planRowKey'] = $details_ukey;
} else {
    $result['result'] = 0;
    $result['resultDesc'][] = '105 : Plan not find';
}

// save user data
if ($saveUser) {
    include '../lib/save-data.php';
        
    $result['pdf']['bodyType'] = $allVar['bodyType'];
    $result['pdf']['drivingExpText'] = $allVar['drivingExpText'];
    $result['pdf']['drivingExpText2'] = $allVar['drivingExpText2'];
    $result['pdf']['carMakeText'] = $allVar['carMakeText'];
    $result['pdf']['carModelText'] = $allVar['carModelText'];
    $result['pdf']['age'] = $allVar['age'];
    $result['pdf']['age2'] = $allVar['age2'];
    $result['pdf']['occupationText'] = $allVar['occupationText'];
    $result['pdf']['occupationText2'] = $allVar['occupationText2'];
        //unset($result['plans']);
        unset($result['planRowKey']);
} elseif ($isTest) {
    $result['process'] = $process;
    //error_log( json_encode($result) );
    return $result;
}

error_log( print_r( $result , true ) );
error_log( json_encode($result) );



//may be for dubug
unset($result['resultDesc']);
echo json_encode($result);

exit();
