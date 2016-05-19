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
    public $isTest;
    public $saveUser;
    public $skipFindRule;

    /* @var $occ Occ */
    public $occ; // occ object

    /* @var $car Car */
    public $car; // car object
    public $hasDriver2 = false;
    /**
     * need summary
     */
    public function __construct($data = array())
    {
        $this->allVar['refID'] = (isset($data['refID']) && !empty($data['refID']))  ? $data['refID'] : false;

        // rule data (required)
        $this->allVar['dob'] = (isset($data['dob']) && !empty($data['dob']))  ? $data['dob'] : '00-00-0000'; // 25-02-2014
        $this->allVar['age'] = isset($data['age']) ? $data['age'] : ''; // provide age/dob
        $this->allVar['ncd'] = isset($data['ncd']) ? $data['ncd'] : '100';
        $this->allVar['drivingExp'] = isset($data['drivingExp']) ? $data['drivingExp'] : '';
        $this->allVar['drivingExpText'] = isset($data['drivingExpText']) ? $data['drivingExpText'] : '' ;
        $this->allVar['insuranceType'] = isset($data['insuranceType']) ? $data['insuranceType'] : '' ;
        $this->allVar['yearManufacture'] = isset($data['yearManufacture']) ? $data['yearManufacture'] : 2000 ;
        $this->allVar['carMake']  = isset($data['carMake']) ? $data['carMake'] : '';
        $this->allVar['carModel']  = isset($data['carModel']) ? $data['carModel'] : '';
        $this->allVar['carModelOther'] = isset($data['carModelOther']) ? $data['carModelOther'] : '';
        $this->allVar['occupation'] =  isset($data['occupation']) ? $data['occupation'] : '' ;
        $this->allVar['occupationText'] = isset($data['occupationText']) ? $data['occupationText'] : '' ;
        $this->allVar['motor_accident_yrs']  = isset($data['motor_accident_yrs']) ? $data['motor_accident_yrs'] : null; //Did the main driver have any accidents or claims in the last 3 years?
        $this->allVar['drive_offence_point']  = isset($data['drive_offence_point']) ? $data['drive_offence_point'] : null; //Did the main driver have any driving offence points in the last 2 years

        //user data or car data 
        $this->allVar['name'] =  isset($data['name']) ? $data['name'] : '';
        $this->allVar['email'] =  isset($data['email']) ? trim($data['email']) : '';
        $this->allVar['contactno'] = isset($data['contactno']) ? $data['contactno'] : '';
        $this->allVar['address'] = isset($data['address']) ? $data['address'] : '';
        $this->allVar['address2'] = isset($data['address2']) ? $data['address2'] : '';
        $this->allVar['address3'] = isset($data['address3']) ? $data['address3'] : '';
        $this->allVar['address4'] = isset($data['address4']) ? $data['address4'] : '';
        $this->allVar['residential_district'] = isset($data['residential_district']) ? $data['residential_district'] : ''; // address line 5
        $this->allVar['gender'] = isset($data['gender']) ? $data['gender'] : '';
        $this->allVar['marital_status'] = isset($data['marital_status']) ? $data['marital_status'] : '';
        $this->allVar['lang'] = isset($data['lang']) ? $data['lang'] : 'en';
        $this->allVar['hkid_1'] = isset($data['hkid_1']) ? $data['hkid_1'] : '';
        $this->allVar['hkid_2'] = isset($data['hkid_2']) ? $data['hkid_2'] : '';
        $this->allVar['hkid_3'] = isset($data['hkid_3']) ? $data['hkid_3'] : '';
        $this->allVar['vehicle_registration'] = isset($data['vehicle_registration']) ? $data['vehicle_registration'] : '' ;
        $this->allVar['yearly_mileage'] = isset($data['yearly_mileage']) ? $data['yearly_mileage'] : '';
        $this->allVar['referer'] = (isset($data['referer']) && !empty($data['referer'])) ? $data['referer'] : 'kwiksure';
        $this->allVar['policy_start_date'] = (isset($data['policy_start_date']) && !empty($data['policy_start_date']))  ? $data['policy_start_date'] : ''; // 25-02-2014
        $this->allVar['policy_end_date'] = (isset($data['policy_end_date']) && !empty($data['policy_end_date']))  ? $data['policy_end_date'] : ''; // 25-02-2014
        $this->allVar['drive_to_work']  = isset($data['drive_to_work']) ? $data['drive_to_work'] : null;
        $this->allVar['course_of_work']  = isset($data['course_of_work']) ? $data['course_of_work'] : null;
        $this->allVar['convictions_5_yrs']  = isset($data['convictions_5_yrs']) ? $data['convictions_5_yrs'] : null;
        $this->allVar['sum_insured']  = isset($data['sum_insured']) ? $data['sum_insured'] : '0.00';

        // additional car data
        $this->allVar['bodyType']  = isset($data['bodyType']) ? $data['bodyType'] : '';
        $this->allVar['numberOfDoors']  = isset($data['numberOfDoors']) ? $data['numberOfDoors'] : '';
        $this->allVar['chassisNumber']  = isset($data['chassisNumber']) ? $data['chassisNumber'] : '';
        $this->allVar['engineNumber']  = isset($data['engineNumber']) ? $data['engineNumber'] : '';
        $this->allVar['cylinderCapacity']  = isset($data['cylinderCapacity']) ? $data['cylinderCapacity'] : '';
        $this->allVar['numberOfSeats']  = isset($data['numberOfSeats']) ? $data['numberOfSeats'] : '';

        //driver2
        $this->allVar['name2'] =  isset($data['name2']) ? $data['name2'] : '';
        $this->allVar['email2'] =  isset($data['email2']) ? $data['email2'] : '';
        $this->allVar['gender2'] = isset($data['gender2']) ? $data['gender2'] : '';
        $this->allVar['relationship2'] = isset($data['relationship2']) ? $data['relationship2'] : '';
        $this->allVar['dob2'] = (isset($data['dob2']) && !empty($data['dob2']))  ? $data['dob2'] : '00-00-0000'; // 25-02-2014
        $this->allVar['marital_status2'] = isset($data['marital_status2']) ? $data['marital_status2'] : '';
        
        $this->allVar['hkid_1_2'] = isset($data['hkid_1_2']) ? $data['hkid_1_2'] : '';
        $this->allVar['hkid_2_2'] = isset($data['hkid_2_2']) ? $data['hkid_2_2'] : '';
        $this->allVar['hkid_3_2'] = isset($data['hkid_3_2']) ? $data['hkid_3_2'] : '';
        
        $this->allVar['motor_accident_yrs2']  = (isset($data['motor_accident_yrs2']) && $data['motor_accident_yrs2'] != '')    ? $data['motor_accident_yrs2'] : null;
        $this->allVar['drive_offence_point2']  = (isset($data['drive_offence_point2']) && $data['drive_offence_point2']!='')    ? $data['motor_accident_yrs2'] : null;
        $this->allVar['drivingExp2'] = isset($data['drivingExp2']) ? $data['drivingExp2'] : '';
        $this->allVar['occupation2'] =  isset($data['occupation2']) ? $data['occupation2'] : '' ;
        $this->allVar['occupationText2'] =  isset($data['occupationText2']) ? $data['occupationText2'] : '' ;

        // no need process if driver2 not exist
        $this->allVar['drivingExpText2'] = '';
        $this->allVar['age2'] = isset($data['age2']) ? $data['age2'] : ''; // provide age/dob
        
        $this->isTest = isset($data['testRule']) ? true : false;
        if ($this->isTest) {
            $this->saveUser = false;
        }
        
        $this->saveUser = (isset($data['isSave']) && $data['isSave']) ? true : false;
        
        $this->skipFindRule = (isset($data['skipFindRule']) && $data['skipFindRule']) ? true : false;
        
        
        $this->allVar['planID'] = (isset($data['planID']) && !empty($data['planID'])) ? $data['planID'] : false;
        $this->allVar['subPlanID']  = (isset($data['subPlanID']) && !empty($data['subPlanID'])) ? $data['subPlanID'] : false;
        
        $this->allVar['payButtonClick'] = (isset($data['payButtonClick']) && !empty($data['payButtonClick'])) ? 1 : 0;
        
        
        //google ad
        $this->allVar['keywords'] =  isset($data['keywords']) ? $data['keywords'] : '' ;
        $this->allVar['cmid'] =  isset($data['cmid']) ? $data['cmid'] : '' ;
        $this->allVar['dgid'] =  isset($data['dgid']) ? $data['dgid'] : '' ;
        $this->allVar['kwid'] =  isset($data['kwid']) ? $data['kwid'] : '' ;
        $this->allVar['netw'] =  isset($data['netw']) ? $data['netw'] : '' ;
        $this->allVar['dvce'] =  isset($data['dvce']) ? $data['dvce'] : '' ;
        $this->allVar['crtv'] =  isset($data['crtv']) ? $data['crtv'] : '' ;
        $this->allVar['adps'] =  isset($data['adps']) ? $data['adps'] : '' ;

        $this->allVar['save_reason'] = isset($data['save_reason']) ? $data['save_reason'] : '';
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
            try {
                checkEmpty('drivingExp', $this->allVar['drivingExp'], $this->allVar['drivingExpText']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmpty('yearManufacture', $this->allVar['yearManufacture']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmpty('carMake', $this->allVar['carMake']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmpty('occupation', $this->allVar['occupation'], $this->allVar['occupationText']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
        }
        
        try {
            checkEmpty('insuranceType', $this->allVar['insuranceType']) ;
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        try {
            if (!empty($this->allVar['carModelOther'])) {
                $this->allVar['carModel'] = $this->allVar['carModelOther'];
            }
            checkEmpty('carModel', $this->allVar['carModel']) ;
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        try {
            $this->allVar['lang'] = checkLang($this->allVar['lang']);
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        if (!empty($this->allVar['hkid_1']) || !empty($this->allVar['hkid_2']) || !empty($this->allVar['hkid_3'])) {
            // not must fill in, but need check format
            try {
                check_hkid($this->allVar['hkid_1'], $this->allVar['hkid_2'], $this->allVar['hkid_3']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
        }
        if (!empty($this->allVar['hkid_1_2']) || !empty($this->allVar['hkid_2_2']) || !empty($this->allVar['hkid_3_2'])) {
            // not must fill in, but need check format
            try {
                check_hkid($this->allVar['hkid_1_2'], $this->allVar['hkid_2_2'], $this->allVar['hkid_3_2']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage() . ' (hkid 2) ';
            }
        }

        //checking for user data must fill in data for user
        if ($this->saveUser) {
            try {
                checkEmpty('name', $this->allVar['name']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmpty('contactno', $this->allVar['contactno']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmpty('email', $this->allVar['email']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
            try {
                checkEmail($this->allVar['email']) ;
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
        }
        
        try {
            $this->allVar['insuranceTypeText']  = $this->car -> getInsuranceTypeByID($this->allVar['insuranceType']);
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        try {
            if (empty($this->allVar['drivingExpText'])) {
                $this->allVar['drivingExpText'] = $this->car -> getDriveExpByID($this->allVar['drivingExp']);
            }
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        try {
            $this->allVar['carMakeText'] = $this->car -> getMakeByID($this->allVar['carMake']);
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }
        try {
            $this->allVar['carModelText'] = $this->car -> getModelByID($this->allVar['carModel'], $this->allVar['carModelOther'], $this->allVar['carMake']);
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }

        try {
            if (empty($this->allVar['occupationText'])) {
                $this->allVar['occupationText'] = $this->occ -> getOccByID($this->allVar['occupation'], $this->allVar['lang']);
            }
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }

        try {
            $this->allVar['calYrMf'] = calYrMf($this->allVar['yearManufacture']);
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }

        if (empty($this->allVar['age'])) {
            try {
                $this->allVar['age'] = calAge($this->allVar['dob']);
            } catch (Exception $e) {
                $er[] = $e->getMessage();
            }
        }

        try {
            $this->hasDriver2 = $this->hasDriver2();
        } catch (Exception $e) {
            $er[] = $e->getMessage();
        }

        if ($this->hasDriver2) {
            $eMsg = 'Driver2';
            try {
                $this->allVar['drivingExpText2'] = $this->car -> getDriveExpByID($this->allVar['drivingExp2']);
            } catch (Exception $e) {
                $er[] = $e->getMessage() . $eMsg;
            }
            try {
                if (empty($this->allVar['occupationText2'])) {
                    $this->allVar['occupationText2'] = $this->occ -> getOccByID($this->allVar['occupation2'], $this->allVar['lang']);
                }
            } catch (Exception $e) {
                $er[] = $e->getMessage() . $eMsg;
            }
            if (empty($this->allVar['age2'])) {
                try {
                    $this->allVar['age2'] = calAge($this->allVar['dob2']);
                } catch (Exception $e) {
                    $er[] = $e->getMessage() . $eMsg;
                }
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
}
