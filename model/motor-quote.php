<?php
/**
 * MotorQuote
 */

/**
 * MotorQuote Class
 */
class MotorQuote
{
    public $allVar;
    public $isTest = false;
    public $saveUser;
    public $skipFindRule;

    /* @var $occ Occ */
    public $occ; // occ object

    /* @var $car Car */
    public $car; // car object
    public $hasDriver2 = false;

    private $defaultData = array(
    'age'=>'',
    'ncd'=>'100',
    'drivingExp'=>'',
    'drivingExpText'=>'',
    'insuranceType'=>'',
    'yearManufacture'=>'2000',
    'carMake'=>'',
    'carModel'=>'',
    'carModelOther'=>'',
    'occupation'=>'',
    'occupationText'=>'',
    'motor_accident_yrs'=>null,
    'drive_offence_point'=>null,
    'name'=>'',
    'email'=>'',
    'contactno'=>'',
    'address'=>'',
    'address2'=>'',
    'address3'=>'',
    'address4'=>'',
    'residential_district'=>'',
    'gender'=>'',
    'marital_status'=>'',
    'lang'=>'en',
    'hkid_1'=>'',
    'hkid_2'=>'',
    'hkid_3'=>'',
    'vehicle_registration'=>'',
    'yearly_mileage'=>'',
    'drive_to_work'=>null,
    'course_of_work'=>null,
    'convictions_5_yrs'=>null,
    'sum_insured'=>'0.00',
    'bodyType'=>'',
    'numberOfDoors'=>'',
    'chassisNumber'=>'',
    'engineNumber'=>'',
    'cylinderCapacity'=>'',
    'numberOfSeats'=>'',
    'name2'=>'',
    'email2'=>'',
    'gender2'=>'',
    'relationship2'=>'',
    'marital_status2'=>'',
    'hkid_1_2'=>'',
    'hkid_2_2'=>'',
    'hkid_3_2'=>'',
    'motor_accident_yrs2'=>null,
    'drive_offence_point2'=>null,
    'drivingExp2'=>'',
    'occupation2'=>'',
    'occupationText2'=>'',
    'drivingExpText2'=>'',
    'age2'=>'',
    'keywords'=>'',
    'cmid'=>'',
    'dgid'=>'',
    'kwid'=>'',
    'netw'=>'',
    'dvce'=>'',
    'crtv'=>'',
    'adps'=>'',
    'save_reason'=>'',
        'policy_start_date'=>'',
        'policy_end_date'=>'',
);
    /**
     * need summary
     */
    public function __construct($data = array())
    {
        $this->allVar = array_replace($this->defaultData, $data);

        $this->allVar['refID'] = $this->isSetNotEmpty($data, 'refID', false);
        $this->allVar['dob'] = $this->isSetNotEmpty($data, 'dob', '00-00-0000');
        $this->allVar['referer'] = $this->isSetNotEmpty($data, 'referer', 'kwiksure');
        $this->allVar['motor_accident_yrs2']  = $this->isSetNotEmpty($data, 'motor_accident_yrs2', null);
        $this->allVar['drive_offence_point2']  = $this->isSetNotEmpty($data, 'drive_offence_point2', null);
        $this->allVar['dob2'] = $this->isSetNotEmpty($data, 'dob2', '00-00-0000');
        $this->allVar['planID'] = $this->isSetNotEmpty($data, 'planID', false);
        $this->allVar['subPlanID']  = $this->isSetNotEmpty($data, 'subPlanID', false);
        $this->allVar['payButtonClick'] =  $this->isSetNotEmpty($data, 'payButtonClick', 0);

        if (isset($data['testRule'])) {
            $this->isTest = true;
            $this->saveUser = false;
        }
        
        $this->saveUser = $this->isSetWithTrue($data, 'isSave');
        $this->skipFindRule = $this->isSetWithTrue($data, 'skipFindRule');
    }
    
    /**
    *save quote
    * @param array $ruleInfo rule array planName,totalPrice,price,details
    * @return array  id , refno
    * @throws Exception    error : cannot save
    */
    public function saveQuote($ruleInfo)
    {
        //format json for save 
        $planInfoAr = array();
        
        //should pass planID for save plan details.
        if ($this->allVar['planID']) {
            $planInfoAr = $this->savePlanFormat($ruleInfo);
        }
        
        if ($this->allVar['subPlanID']) {
            foreach ($this->allVar['subPlanID'] as $subPlanAr) {
                $planInfoAr[0]['subPlanName'][$subPlanAr] = $ruleInfo[0]['subPlans'][$subPlanAr]['name'] . '-' . $ruleInfo[0]['subPlans'][$subPlanAr]['name_sub'];
            }
        }
        
        $exist = 0;
        if ($this->allVar['refID']) {
            $rm = ORM::for_table('motor_quote')->select('*')->where('id', $this->allVar['refID'])->where('download', 0);
            $exist = $rm->count();
        }

        if (!$exist) {
            $rm = ORM::for_table('motor_quote') -> create();
            $rm -> refno  =  $this->genRefno(); 
            $rm -> oldRefID = $this->allVar['refID'];
        } else {
            $rm = $rm->find_one();
        }
        
        $rm -> name  = $this->allVar['name'];
        $rm -> email  = $this->allVar['email'];
        $rm -> contactno = $this->allVar['contactno'];
        $rm -> address = $this->allVar['address'];
        $rm -> address2 = $this->allVar['address2'];
        $rm -> address3 = $this->allVar['address3'];
        $rm -> address4 = $this->allVar['address4'];
        $rm -> residential_district  = $this->allVar['residential_district']; //address 5
        $rm -> lang = $this->allVar['lang'];
        $rm -> referer = $this->allVar['referer'];
        $rm -> hkid_1  = $this->allVar['hkid_1'];
        $rm -> hkid_2  = $this->allVar['hkid_2'];
        $rm -> hkid_3  = $this->allVar['hkid_3'];
        $rm -> gender  = $this->allVar['gender'];
        
        $rm -> marital_status  = $this->allVar['marital_status'];
        $rm -> dob  = $this->allVar['dob'];
        $rm -> age  = $this->allVar['age'];
        $rm -> ncd  = $this->allVar['ncd'];
        $rm -> drivingExp  = $this->allVar['drivingExpText'];
        $rm -> insuranceType  = $this->allVar['insuranceTypeText'];
        $rm -> yearManufacture  = $this->allVar['yearManufacture'];
        $rm -> vehicle_registration  = $this->allVar['vehicle_registration'];
        $rm -> yearly_mileage  = $this->allVar['yearly_mileage'];
        $rm -> carMake  = $this->allVar['carMakeText'];
        $rm -> carModel  = $this->allVar['carModelText'];
        $rm -> occupation  = $this->allVar['occupationText'];
        $rm -> motor_accident_yrs  = $this->allVar['motor_accident_yrs'];
        $rm -> drive_offence_point = $this->allVar['drive_offence_point'];

        $rm -> drive_to_work = $this->allVar['drive_to_work'];
        $rm -> course_of_work = $this->allVar['course_of_work'];
        $rm -> convictions_5_yrs = $this->allVar['convictions_5_yrs'];
        $rm -> sum_insured = $this->allVar['sum_insured'];

        $rm -> plan_match_json = json_encode($planInfoAr);
                        
        $rm -> create_datetime = date("Y-m-d H:i:s");
        $rm -> policy_start_date  = $this->allVar['policy_start_date'];
        $rm -> policy_end_date  = $this->allVar['policy_end_date'];
        $rm -> payButtonClick = $this->allVar['payButtonClick'];
        
        //driver 2
        $rm -> name2  = $this->allVar['name2'];
        $rm -> email2  = $this->allVar['email2'];
        $rm -> relationship2  = $this->allVar['relationship2'];
        $rm -> drivingExp2  = $this->allVar['drivingExpText2'];
        $rm -> occupation2  = $this->allVar['occupationText2'];
        $rm -> dob2  = $this->allVar['dob2'];
        $rm -> age2  = $this->allVar['age2'];
        $rm -> gender2  = $this->allVar['gender2'];
        $rm -> hkid_1_2  = $this->allVar['hkid_1_2'];
        $rm -> hkid_2_2  = $this->allVar['hkid_2_2'];
        $rm -> hkid_3_2  = $this->allVar['hkid_3_2'];
        $rm -> marital_status2  = $this->allVar['marital_status2'];
        
        $rm -> drive_offence_point2  = $this->allVar['drive_offence_point2'];
        $rm -> motor_accident_yrs2  = $this->allVar['motor_accident_yrs2'];
                
        //additational car info
        $rm -> bodyType  = $this->allVar['bodyType'];
        $rm -> numberOfDoors  = $this->allVar['numberOfDoors'];
        $rm -> chassisNumber  = $this->allVar['chassisNumber'];
        $rm -> engineNumber  = $this->allVar['engineNumber'];
        $rm -> cylinderCapacity  = $this->allVar['cylinderCapacity'];
        $rm -> numberOfSeats  = $this->allVar['numberOfSeats'];
                
        //save key for get
        $rm -> insuranceType_key = $this->allVar['insuranceType'];
        $rm -> drivingExp_key = $this->allVar['drivingExp'];
        $rm -> carMake_key = $this->allVar['carMake'];
        $rm -> carModel_key = $this->allVar['carModel'];
        $rm -> occupation_key = $this->allVar['occupation'];
                
        //key for driver 2
        $rm -> occupation_key2 = $this->allVar['occupation2'];
        $rm -> drivingExp_key2 = $this->allVar['drivingExp2'];
        
        //google ad
        $rm -> keywords = $this->allVar['keywords'];
        $rm -> cmid = $this->allVar['cmid'];
        $rm -> dgid = $this->allVar['dgid'];
        $rm -> kwid = $this->allVar['kwid'];
        $rm -> netw = $this->allVar['netw'];
        $rm -> dvce = $this->allVar['dvce'];
        $rm -> crtv = $this->allVar['crtv'];
        $rm -> adps = $this->allVar['adps'];

        $rm -> save_reason = $this->allVar['save_reason'];
        
        if ($rm -> save()) {
            return array( $rm->id , $rm->refno ) ;
        } else {
            throw new Exception('error : cannot save');
        }
    }
    
    /**
     * get by refno
     * @param string $refno
     * @return array
     * @throws Exception
     */
    public function getByRefNo($refno)
    {
        
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
    
    
    public function validationInput()
    {
        $er = array();
        
        if (!$this->skipFindRule) {
            
                checkEmpty('drivingExp', $this->allVar['drivingExp'], $this->allVar['drivingExpText']) ;
            
            
                checkEmpty('yearManufacture', $this->allVar['yearManufacture']) ;
            
            
            
            
                checkEmpty('carMake', $this->allVar['carMake']) ;
            
            
            
            
                checkEmpty('occupation', $this->allVar['occupation'], $this->allVar['occupationText']) ;
            
        }
        
        
            checkEmpty('insuranceType', $this->allVar['insuranceType']) ;
        
        
            if (!empty($this->allVar['carModelOther'])) {
                $this->allVar['carModel'] = $this->allVar['carModelOther'];
            }
            checkEmpty('carModel', $this->allVar['carModel']) ;
        
        
            $this->allVar['lang'] = checkLang($this->allVar['lang']);
        
        if (!empty($this->allVar['hkid_1']) || !empty($this->allVar['hkid_2']) || !empty($this->allVar['hkid_3'])) {
            // not must fill in, but need check format
        
                check_hkid($this->allVar['hkid_1'], $this->allVar['hkid_2'], $this->allVar['hkid_3']) ;
        
        }
        if (!empty($this->allVar['hkid_1_2']) || !empty($this->allVar['hkid_2_2']) || !empty($this->allVar['hkid_3_2'])) {
            // not must fill in, but need check format
        
                check_hkid($this->allVar['hkid_1_2'], $this->allVar['hkid_2_2'], $this->allVar['hkid_3_2']) ;
        
        }

        //checking for user data must fill in data for user
        if ($this->saveUser) {
            
                checkEmpty('name', $this->allVar['name']) ;
            
            
                checkEmpty('contactno', $this->allVar['contactno']) ;
            
            
                checkEmpty('email', $this->allVar['email']) ;
            
            
                checkEmail($this->allVar['email']) ;
            
        }
        
        
            $this->allVar['insuranceTypeText']  = $this->car -> getInsuranceTypeByID($this->allVar['insuranceType']);
        
        
            if (empty($this->allVar['drivingExpText'])) {
                $this->allVar['drivingExpText'] = $this->car -> getDriveExpByID($this->allVar['drivingExp']);
            }
        
        
            $this->allVar['carMakeText'] = $this->car -> getMakeByID($this->allVar['carMake']);
        
        
            $this->allVar['carModelText'] = $this->car -> getModelByID($this->allVar['carModel'], $this->allVar['carModelOther'], $this->allVar['carMake']);
        

        
            if (empty($this->allVar['occupationText'])) {
                $this->allVar['occupationText'] = $this->occ -> getOccByID($this->allVar['occupation'], $this->allVar['lang']);
            }
        

        
            $this->allVar['calYrMf'] = calYrMf($this->allVar['yearManufacture']);
        

        if (empty($this->allVar['age'])) {
            
                $this->allVar['age'] = calAge($this->allVar['dob']);
            
        }

        
            $this->hasDriver2 = $this->hasDriver2();
        

        if ($this->hasDriver2) {
            
                $this->allVar['drivingExpText2'] = $this->car -> getDriveExpByID($this->allVar['drivingExp2']);
            
            
                if (empty($this->allVar['occupationText2'])) {
                    $this->allVar['occupationText2'] = $this->occ -> getOccByID($this->allVar['occupation2'], $this->allVar['lang']);
                }
            
            if (empty($this->allVar['age2'])) {
            
                    $this->allVar['age2'] = calAge($this->allVar['dob2']);
            
            }
        }
        
        return $er;
    }
    
    public function setOcc($occ)
    {
        $this->occ = $occ;
    }
    
    public function setCar($car)
    {
        $this->car = $car;
    }
    
    public function hasDriver2()
    {
        error_log($this->allVar['occupation2']);
        error_log($this->allVar['drivingExp2']);
        error_log($this->allVar['motor_accident_yrs2']);
        error_log($this->allVar['drive_offence_point2']);

        if (!empty($this->allVar['occupation2']) &&
                !empty($this->allVar['drivingExp2']) &&
                !is_null($this->allVar['motor_accident_yrs2']) &&
                !is_null($this->allVar['drive_offence_point2'])
            ) {
            return true;
        }
        if (empty($this->allVar['occupation2']) &&
                empty($this->allVar['drivingExp2']) &&
                is_null($this->allVar['motor_accident_yrs2']) &&
                is_null($this->allVar['drive_offence_point2'])
            ) {
            return false;
        }
        
        throw new Exception('error driver2 :: missing info');
        
    }
    
    public function buildDriver1()
    {
        $ar = array();
        $ar['carModel'] = $this->allVar['carModel'];
        $ar['occupation'] = $this->allVar['occupation'];
        $ar['age'] = $this->allVar['age'];
        $ar['ncd'] = $this->allVar['ncd'];
        $ar['drivingExp'] = $this->allVar['drivingExp'];
        $ar['insuranceType'] = $this->allVar['insuranceType'];
        $ar['motor_accident_yrs'] = $this->allVar['motor_accident_yrs'];
        $ar['drive_offence_point'] = $this->allVar['drive_offence_point'];
        $ar['calYrMf'] = $this->allVar['calYrMf'];
        
        return new Driver($ar);
    }
    
    public function buildDriver2()
    {
        $ar = array();
        $ar['carModel'] = $this->allVar['carModel'];
        $ar['occupation'] = $this->allVar['occupation2'];
        $ar['age'] = $this->allVar['age2'];
        $ar['ncd'] = $this->allVar['ncd'];
        $ar['drivingExp'] = $this->allVar['drivingExp2'];
        $ar['insuranceType'] = $this->allVar['insuranceType'];
        $ar['motor_accident_yrs'] = $this->allVar['motor_accident_yrs2'];
        $ar['drive_offence_point'] = $this->allVar['drive_offence_point2'];
        $ar['calYrMf'] = $this->allVar['calYrMf'];
        
        return new Driver($ar);
    }
    
    private function savePlanFormat($ruleInfo)
    {
        $planInfoAr = array();
        foreach ($ruleInfo as $rowKey => $rowArray) {
            $planInfoAr[$rowKey]['planName'] = $rowArray['rule_name'];
            $planInfoAr[$rowKey]['totalPrice'] = $rowArray['total_price'];
            $planInfoAr[$rowKey]['price'] = $rowArray['price'];
            $planInfoAr[$rowKey]['TypeofInsurance'] = $rowArray['TypeofInsurance'];

            $tmpDetailsArry = array();
            foreach ($rowArray['details'] as $k => $v) {
                $tmpDetailsArry[$k]['value'] = $v['value'];
                $tmpDetailsArry[$k]['deatils_id'] = $v['deatils_id'];
            }

            
            $planInfoAr[$rowKey]['details'] = $tmpDetailsArry;

            $planInfoAr[$rowKey]['premium'] = $rowArray['premium'];
            $planInfoAr[$rowKey]['loading'] = $rowArray['loading'];
            $planInfoAr[$rowKey]['otherDiscount'] = $rowArray['otherDiscount'];
            $planInfoAr[$rowKey]['clientDiscount'] = $rowArray['clientDiscount'];
            $planInfoAr[$rowKey]['commission'] = $rowArray['commission'];
            $planInfoAr[$rowKey]['mib'] = $rowArray['mibValue'];
            $planInfoAr[$rowKey]['gross'] = $rowArray['gross'];
        }
        return $planInfoAr;
    }

    /**
     *
     * @param array $data
     * @param string $k
     * @param mix $d
     * @return mix
     */
    private function isSetNotEmpty($data , $k , $d){
        return (isset($data[$k]) && $data[$k]!='')  ? $data[$k] : $d;
    }

    /**
     *
     * @param array $data
     * @param string $k
     * @param mix $d
     * @return mix
     */
    private function isSetWithTrue($data , $k ){
        return (isset($data[$k]) && $data[$k]) ? true : false;
    }
}
