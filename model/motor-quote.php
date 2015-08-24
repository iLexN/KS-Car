<?php
/**
 * MotorQuote
 */

/**
 * MotorQuote Class
 */
class MotorQuote
{

        /**
         *output array no use
         * @var array   output the field which website need for save action
         
    private $default_select_field = array(
            'gender',
            'residential_district',
            'marital_status',
            'ncd',
            'drivingExp_key',
            'insuranceType_key',
            'yearManufacture',
            'carMake_key',
            'carModel_key',
            'occupation_key',
            
                        'occupation_key2',
                        'drivingExp_key2',
            
            'vehicle_registration',
            'yearly_mileage',
            'motor_accident_yrs',
            'drive_offence_point',
                        'drive_to_work',
                        'course_of_work',
                        'sum_insured',
            'policy_start_date',
            'policy_end_date',
            
            'name',
            'email',
            'contactno',
            'hkid_1',
            'hkid_2',
            'hkid_3',
            'dob',
                        
                        'occupation_key2',
                        'drivingExp_key2',
                        'relationship2',
                        'dob2',
                        'hkid_1_2',
                        'hkid_2_2',
                        'hkid_3_2',
                        'name2',
                        'gender2',
            //'residential_district2',
            'marital_status2',
                        'motor_accident_yrs2',
            'drive_offence_point2'
            
        );*/
    
    /**
     * need summary
     */
    public function __construct()
    {
        //$this->r = $r;
    }
    
        /**
         *save quote
         * @param array $ar $_POST
         * @param arrya $ruleInfo rule array planName,totalPrice,price,details
         * @return array  id , refno
         * @throws Exception    error : cannot save
         */
    public function saveQuote($ar, $ruleInfo)
    {
        //error_log(print_r($ruleInfo, true));
        $planInfoAr = array();
        if ($ar['planID']) {
            $planInfoAr['planName'] = $ruleInfo[0]['rule_name'];
            $planInfoAr['totalPrice'] = $ruleInfo[0]['total_price'];
            $planInfoAr['price'] = $ruleInfo[0]['price'];
            $planInfoAr['details'] = $ruleInfo[0]['details'];
            
            $planInfoAr['premium'] = $ruleInfo[0]['premium'];
            $planInfoAr['loading'] = $ruleInfo[0]['loading'];
            $planInfoAr['otherDiscount'] = $ruleInfo[0]['otherDiscount'];
            $planInfoAr['clientDiscount'] = $ruleInfo[0]['clientDiscount'];
            $planInfoAr['commission'] = $ruleInfo[0]['commission'];
            $planInfoAr['mib'] = $ruleInfo[0]['mibValue'];
            $planInfoAr['gross'] = $ruleInfo[0]['gross'];
        }
        if ($ar['subPlanID']) {
            foreach ($ar['subPlanID'] as $subPlanAr) {
                $planInfoAr['subPlanName'][$subPlanAr] = $ruleInfo[0]['subPlans'][$subPlanAr]['name'] . '-' . $ruleInfo[0]['subPlans'][$subPlanAr]['name_sub'];
            }
            //$totalPrice +=  $ruleInfo[0]['subPlans'][$ar['subPlanID']]['add_price'];
        }
        
        $exist = 0;
        if ( $ar['refID'] ){
            $rm = ORM::for_table('motor_quote')->select('*')->where('id',$ar['refID'])->where('download',0);
            $exist = $rm->count();
        }
        //error_log('here  exist :: ' . $exist);
        if ( !$exist ){
            $rm = ORM::for_table('motor_quote') -> create();
            //error_log('create');
        } else {
            $rm = $rm->find_one();
        }
        
        $rm -> name  = $ar['name'];
        $rm -> email  = $ar['email'];
        $rm -> contactno = $ar['contactno'];
        $rm -> address = $ar['address'];
        $rm -> address2 = $ar['address2'];
        $rm -> address3 = $ar['address3'];
        $rm -> address4 = $ar['address4'];
        $rm -> residential_district  = $ar['residential_district']; //address 5
        $rm -> lang = $ar['lang'];
        $rm -> referer = $ar['referer'];
        $rm -> hkid_1  = $ar['hkid_1'];
        $rm -> hkid_2  = $ar['hkid_2'];
        $rm -> hkid_3  = $ar['hkid_3'];
        $rm -> gender  = $ar['gender'];
        
        $rm -> marital_status  = $ar['marital_status'];
        $rm -> dob  = $ar['dob'];
        $rm -> age  = $ar['age'];
        $rm -> ncd  = $ar['ncd'];
        $rm -> drivingExp  = $ar['drivingExpText'];
        $rm -> insuranceType  = $ar['insuranceTypeText'];
        $rm -> yearManufacture  = $ar['yearManufacture'];
        $rm -> vehicle_registration  = $ar['vehicle_registration'];
        $rm -> yearly_mileage  = $ar['yearly_mileage'];
        $rm -> carMake  = $ar['carMakeText'];
        $rm -> carModel  = $ar['carModelText'];
        $rm -> occupation  = $ar['occupationText'];
        $rm -> motor_accident_yrs  = $ar['motor_accident_yrs'];
        $rm -> drive_offence_point = $ar['drive_offence_point'];
                
        $rm -> drive_to_work = $ar['drive_to_work'];
        $rm -> course_of_work = $ar['course_of_work'];
        $rm -> convictions_5_yrs = $ar['convictions_5_yrs'];
        $rm -> sum_insured = $ar['sum_insured'];
                
        //$rm -> plan_match_json = json_encode($ruleInfo);
        $rm -> plan_match_json = json_encode($planInfoAr);
                
                
        $rm -> create_datetime = date("Y-m-d H:i:s");
        $rm -> policy_start_date  = $ar['policy_start_date'];
        $rm -> policy_end_date  = $ar['policy_end_date'];
        $rm -> payButtonClick = $ar['payButtonClick'];
        
                //driver 2
        $rm -> name2  = $ar['name2'];
        $rm -> email2  = $ar['email2'];
        $rm -> relationship2  = $ar['relationship2'];
        $rm -> drivingExp2  = $ar['drivingExpText2'];
        $rm -> occupation2  = $ar['occupationText2'];
        $rm -> dob2  = $ar['dob2'];
        $rm -> age2  = $ar['age2'];
        $rm -> gender2  = $ar['gender2'];
        $rm -> hkid_1_2  = $ar['hkid_1_2'];
        $rm -> hkid_2_2  = $ar['hkid_2_2'];
        $rm -> hkid_3_2  = $ar['hkid_3_2'];
        $rm -> marital_status2  = $ar['marital_status2'];
        //$rm -> residential_district2  = $ar['residential_district2'];
        $rm -> drive_offence_point2  = $ar['drive_offence_point2'];
        $rm -> motor_accident_yrs2  = $ar['motor_accident_yrs2'];
                
        //additational car info
        $rm -> bodyType  = $ar['bodyType'];
        $rm -> numberOfDoors  = $ar['numberOfDoors'];
        $rm -> chassisNumber  = $ar['chassisNumber'];
        $rm -> engineNumber  = $ar['engineNumber'];
        $rm -> cylinderCapacity  = $ar['cylinderCapacity'];
        $rm -> numberOfSeats  = $ar['numberOfSeats'];
                
        //save key for get
        $rm -> insuranceType_key = $ar['insuranceType'];
        $rm -> drivingExp_key = $ar['drivingExp'];
        $rm -> carMake_key = $ar['carMake'];
        $rm -> carModel_key = $ar['carModel'];
        $rm -> occupation_key = $ar['occupation'];
                
        //key for driver 2
        $rm -> occupation_key2 = $ar['occupation2'];
        $rm -> drivingExp_key2 = $ar['drivingExp2'];
        
        if ( !$exist ){
            $rm -> refno  =  $this->genRefno(); //$result['refno'];
            $rm -> oldRefID = $ar['refID'];
        }
        
        if ($rm -> save()) {
            return array( $rm->id , $rm->refno ) ;
        } else {
            throw new Exception('error : cannot save');
        }
    }
    
    /**
     * get by refno
     * @param string $refno
     * @param array $select_field
     * @return array
     * @throws Exception
     */
    public function getByRefNo($refno, $select_field=array())
    {
        //$fields = !empty($select_field) ? $select_field :  $this->default_select_field ;
    
        $quote = ORM::for_table('motor_quote')
                //->select_many($fields)
                ->where('refno', $refno)
                ->find_one();
        if ($quote) {
            return $quote->as_array();
        } else {
            throw new Exception('not find');
        }
    }
    
    /**
     * gen refno for web use
     * @return string
     */
    private function genRefno()
    {
        $code = time() . mt_rand(0, 1000000);
        return sha1($code);
    }
}
