<?php
set_time_limit (0 );
include('db/db_info.php');
include('model/occ.php');
include('model/car.php');
include('model/rule.php');
include('model/details-info.php');
include('model/sub-plans.php');
include('model/calTotalPrice.php');


$r = new Rule;

$car = new Car();

$ncd = $car->getNCD();
$model = $car->getAllModels();

$occ = new Occ;
$occupation_ar = $occ->getAll();

$calYrMf = range (0,30);
$age = range(18, 65);
$driveExp = $car->getDriveExp(1);

$ar['motor_accident_yrs'] = 0;
$ar['drive_offence_point'] = 0;
$ar['insuranceType'] = 'Third_Party_Only';



$model = [ ['id'=>1] ];
$occupation_ar = [['id'=>1]];


foreach ( $model as $model_v ){
    $ar['carModel'] = $model_v['id'];
    
    foreach ( $occupation_ar as $occ_v ) {
        $ar['occupation'] = $occ_v['id'];
        
        foreach ( $age as $age_v ){
            $ar['age'] = $age_v;
            
            foreach ( $driveExp as $driverE_k => $driverE_v ) {
                $ar['drivingExp'] = $driverE_k;
                
                foreach ( $calYrMf as $calYrMf_v ){
                    $ar['calYrMf'] = $calYrMf_v;
                    
                    foreach ( $ncd as $ncd_k => $ncd_v ){
                        $ar['ncd'] = $ncd_k;
                        $out_ar = $r->matchRuleWithVar($ar,FALSE);
                        
                        if ( !empty($out_ar)){
                            print_r($out_ar);
                            exit();
                        }
                    }
                    
                }
            }
            
        }
        
    }
    
}

//print_r($ncd);
//print_r($model);