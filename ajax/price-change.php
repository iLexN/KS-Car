<?php
/*
{ruleName: $RuleName.val(),
                        //price: $Price.val(),
                        priceAdd: $PriceAdd.val(),
                        age_from: $AgeFrom.val(),
                        age_to: $AgeTo.val(),
                        NCD: $NCD.val(),
                        DrivingExp: $DrivingExp.val(),
                        TypeofInsurance: $Insurance.val(),
                        Yearofmanufacture: $Yearofmanufacture.val(),
                        Yearofmanufacture_from: $YearofmanufactureFrom.val(),
                        DriveOffencePoint: $("input:radio[name=drive_offence_point" + id + "]:checked").val(),
                        MotorAccidentYrs: $("input:radio[name=motor_accident_yrs_" + id + "]:checked").val(),
                        Active: $("input:radio[name=active" + id + "]:checked").val(),
                        
                        premium: $Premium.val(),
                        loading: $Loading.val(),
                        otherDiscount: $otherDiscount.val(),
                        clientDiscount: $clientDiscount.val(),
                        mib: $mib.val(),
                        commission: $commission.val(),
                        
                        id: id
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
$rule->editUpdate($_POST);


echo('updated success');
