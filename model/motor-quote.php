<?php
/**
 * MotorQuote
 */

/**
 * MotorQuote Class
 */
class MotorQuote implements \PartnerInterface
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
        'sum_insured'=>'0',
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
    public function __construct($data = array(), \Car $car, \Occ $occ)
    {
        $this->setCar($car);
        $this->setOcc($occ);

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

        $this->setTest(isset($data['testRule']));

        $this->saveUser = $this->isSetWithTrue($data, 'isSave');
        $this->skipFindRule = $this->isSetWithTrue($data, 'skipFindRule');
    }

    private function setTest($isTest)
    {
        if ($isTest) {
            $this->isTest = true;
            $this->saveUser = false;
        }
    }

    /**
     *
     * @param int $rid
     * @return \ORM
     */
    private function getDBObject($rid)
    {
        $exist = 0;

        $rm = ORM::for_table('motor_quote')->select('*');

        if ($rid) {
            $rm->where('id', $rid)->where('download', 0);
            $exist = $rm->count();
        }

        if (!$exist) {
            $rm = ORM::for_table('motor_quote') -> create();
            $rm -> refno  =  $this->genRefno();
            $rm -> oldRefID = $this->allVar['refID'];
        } else {
            $rm = $rm->find_one();
        }

        return $rm;
    }

    /**
    * save quote
    * @param array $ruleInfo rule array planName,totalPrice,price,details
    * @return array  id , refno
    * @throws Exception    error : cannot save
    */
    public function saveQuote($ruleInfo)
    {
        //format json for save
        $planInfoAr = $this->proccessPlans($ruleInfo);

        $rm = $this->getDBObject($this->allVar['refID']);

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
        $rm -> motor_accident_yrs  = $this->nullOrEmpty($this->allVar['motor_accident_yrs']);
        $rm -> drive_offence_point = $this->nullOrEmpty($this->allVar['drive_offence_point']);

        $rm->drive_to_work = $this->nullOrEmpty($this->allVar['drive_to_work']);

        $rm -> course_of_work = $this->allVar['course_of_work'] === '' ? null : $this->allVar['course_of_work'] ;
        $rm -> convictions_5_yrs = $this->allVar['convictions_5_yrs'];
        $rm -> sum_insured = $this->nullOrEmpty($this->allVar['sum_insured']);

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
        $rm -> age2  = $this->nullOrEmpty($this->allVar['age2']); //$this->allVar['age2'];
        $rm -> gender2  = $this->allVar['gender2'];
        $rm -> hkid_1_2  = $this->allVar['hkid_1_2'];
        $rm -> hkid_2_2  = $this->allVar['hkid_2_2'];
        $rm -> hkid_3_2  = $this->allVar['hkid_3_2'];
        $rm -> marital_status2  = $this->allVar['marital_status2'];

        $rm -> drive_offence_point2  = $this->nullOrEmpty($this->allVar['drive_offence_point2']);
        $rm -> motor_accident_yrs2  = $this->nullOrEmpty($this->allVar['motor_accident_yrs2']);

        //additational car info
        $rm -> bodyType  = $this->allVar['bodyType'];
        $rm -> numberOfDoors  = $this->allVar['numberOfDoors'];
        $rm -> chassisNumber  = $this->allVar['chassisNumber'];
        $rm -> engineNumber  = $this->allVar['engineNumber'];
        $rm -> cylinderCapacity  = $this->nullOrEmpty($this->allVar['cylinderCapacity']);
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

        $this->validationSkipFindRule();

        $this->validationGerenal();

        $this->validationHKID($this->allVar['hkid_1'], $this->allVar['hkid_2'], $this->allVar['hkid_3']);
        $this->validationHKID($this->allVar['hkid_1_2'], $this->allVar['hkid_2_2'], $this->allVar['hkid_3_2']);

        //checking for user data must fill in data for user
        $this->validationSaveUser();
        $this->validationRuleData();

        $this->hasDriver2 = $this->hasDriver2();
        $this->validationDriver2();

        return $er;
    }

    /**
     * @param Occ $occ
     */
    public function setOcc($occ)
    {
        $this->occ = $occ;
    }

    /**
     * @param Car $car
     */
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

    public function getDriver1Data()
    {
        $ar = $this->getDriverGeneralInfo();

        $ar['occupation'] = $this->allVar['occupation'];
        $ar['age'] = $this->allVar['age'];
        $ar['drivingExp'] = $this->allVar['drivingExp'];
        $ar['motor_accident_yrs'] = $this->allVar['motor_accident_yrs'];
        $ar['drive_offence_point'] = $this->allVar['drive_offence_point'];

        return $ar;
    }

    private function getDriverGeneralInfo()
    {
        $ar = array();
        $ar['carModel'] = $this->allVar['carModel'];
        $ar['ncd'] = $this->allVar['ncd'];
        $ar['insuranceType'] = $this->allVar['insuranceType'];
        $ar['calYrMf'] = $this->allVar['calYrMf'];
        $ar['owner'] = $this->getRefererOwner();
        $ar['sum_insured'] = $this->allVar['sum_insured'];

        return $ar;
    }

    public function getDriver2Data()
    {
        $ar = $this->getDriverGeneralInfo();

        $ar['occupation'] = $this->allVar['occupation2'];
        $ar['age'] = $this->allVar['age2'];
        $ar['drivingExp'] = $this->allVar['drivingExp2'];
        $ar['motor_accident_yrs'] = $this->allVar['motor_accident_yrs2'];
        $ar['drive_offence_point'] = $this->allVar['drive_offence_point2'];

        return $ar;
    }

    /**
     * get the first part of referer eg. google-a-ad
     * @return string
     */
    private function getRefererOwner()
    {
        $ar = explode('-', $this->allVar['referer']);
        return $ar[0];
    }

    private function savePlanFormat($ruleInfo)
    {
        $planInfoAr = array();
        foreach ($ruleInfo as $rowKey => $rowArray) {
            $planInfoAr[$rowKey]['planName'] = $rowArray['rule_name'];
            $planInfoAr[$rowKey]['totalPrice'] = $rowArray['total_price'];
            $planInfoAr[$rowKey]['price'] = $rowArray['price'];
            $planInfoAr[$rowKey]['TypeofInsurance'] = $rowArray['TypeofInsurance'];

            $planInfoAr[$rowKey]['details'] = $this->detailInfoFormat($rowArray['details']);

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

    private function detailInfoFormat($rowArray)
    {
        $tmpDetailsArry = array();
        foreach ($rowArray as $k => $v) {
            $tmpDetailsArry[$k]['value'] = $v['value'];
            $tmpDetailsArry[$k]['deatils_id'] = $v['deatils_id'];
        }
        return $tmpDetailsArry;
    }

    /**
     *
     * @param array $data
     * @param string $k
     * @param mixed|boolean $d
     * @return mixed|boolean
     */
    private function isSetNotEmpty($data, $k, $d)
    {
        return (isset($data[$k]) && $data[$k]!='')  ? $data[$k] : $d;
    }

    /**
     *
     * @param array $data
     * @param string $k
     * @return bool
     */
    private function isSetWithTrue($data, $k)
    {
        return (isset($data[$k]) && $data[$k]) ? true : false;
    }

    private function validationSaveUser()
    {
        if ($this->saveUser) {
            checkEmpty('name', $this->allVar['name']) ;
            checkEmpty('contactno', $this->allVar['contactno']) ;
            checkEmpty('email', $this->allVar['email']) ;
            checkEmail($this->allVar['email']) ;
        }
    }

    private function validationSkipFindRule()
    {
        if (!$this->skipFindRule) {
            checkEmpty('drivingExp', $this->allVar['drivingExp'], $this->allVar['drivingExpText']) ;
            checkEmpty('yearManufacture', $this->allVar['yearManufacture']) ;
            checkEmpty('carMake', $this->allVar['carMake']) ;
            checkEmpty('occupation', $this->allVar['occupation'], $this->allVar['occupationText']) ;
        }
    }

    private function validationRuleData()
    {
        $this->allVar['insuranceTypeText']  = $this->car -> getInsuranceTypeByID($this->allVar['insuranceType']);

        if (empty($this->allVar['drivingExpText'])) {
            $this->allVar['drivingExpText'] = $this->car -> getDriveExpByID($this->allVar['drivingExp']);
        }

        $this->allVar['carMakeText'] = $this->car -> getMakeByID($this->allVar['carMake']);
        $this->allVar['carModelText'] = $this->car -> getModelByID($this->allVar['carModel'], $this->allVar['carModelOther'], $this->allVar['carMake']);

        if ($this->allVar['occupationText'] == '') {
            $this->allVar['occupationText'] = $this->occ -> getOccByID($this->allVar['occupation'], $this->allVar['lang']);
        }

        $this->allVar['calYrMf'] = calYrMf($this->allVar['yearManufacture']);


        if (empty($this->allVar['age'])) {
            $this->allVar['age'] = calAge($this->allVar['dob']);
        }
    }

    private function validationHKID($v1, $v2, $v3)
    {
        if (!empty($v1) || !empty($v2) || !empty($v3)) {
            // not must fill in, but need check format
                check_hkid($v1, $v2, $v3) ;
        }
    }

    private function validationDriver2()
    {
        if (!$this->hasDriver2) {
            return;
        }

        $this->allVar['drivingExpText2'] = $this->car -> getDriveExpByID($this->allVar['drivingExp2']);

        if ($this->allVar['occupationText2'] == '') {
            $this->allVar['occupationText2'] = $this->occ -> getOccByID($this->allVar['occupation2'], $this->allVar['lang']);
        }

        if (empty($this->allVar['age2'])) {
            $this->allVar['age2'] = calAge($this->allVar['dob2']);
        }
    }

    private function validationGerenal()
    {
        checkEmpty('insuranceType', $this->allVar['insuranceType']) ;
        $this->allVar['lang'] = checkLang($this->allVar['lang']);

        if (!empty($this->allVar['carModelOther'])) {
            $this->allVar['carModel'] = $this->allVar['carModelOther'];
        }
        checkEmpty('carModel', $this->allVar['carModel']) ;
    }

    private function proccessPlans($ruleInfo)
    {
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
        return $planInfoAr;
    }

    public function getData($k = '')
    {
        if ($k === '') {
            return $this->allVar;
        }

        return $this->allVar[$k];
    }

    /**
     * @param array $rules
     * @return array
     */
    public function formatRules($rules)
    {
        $ar = [];

        foreach ($rules as $rule) {
            $ar[] = $this->formatRule($rule);
        }

        return $ar;
    }

    /**
     * @param array $rule
     * @return array
     */
    private function formatRule($rule)
    {
        $match_rule = [];
        $match_rule['premium'] = $rule['premium'];
        $match_rule['id'] = $rule['id'];
        $match_rule['planName'] = $rule['rule_name'];
        $match_rule['total_price'] = number_format($rule['total_price'], 0, '.', '');
        $match_rule['TypeofInsurance'] = $rule['TypeofInsurance'];
        $match_rule['loading'] = $rule['loading'];
        $match_rule['clientDiscount'] = $rule['clientDiscount'];
        $match_rule['mibValue'] = $rule['mibValue'];
        $match_rule['msg'] = $rule['msg_'.$this->allVar['lang']];

        $tmp_ar = [];
        foreach ($rule['details'] as $k=>$v) {
            $tmp_ar[$v['deatils_id']] = (int) $v['value'];
            if (!empty($v['text_'.$this->allVar['lang']])) {
                $tmp_ar[$v['deatils_id'].'_text'] = $v['text_'.$this->allVar['lang']];
            }
        }
        $match_rule['details'] = $tmp_ar;
        $match_rule['subPlans'] = $rule['subPlans'];

        return $match_rule;
    }

    public function getOwner()
    {
        return 'Kwiksure';
    }

    public function formatResultMatchRule($result)
    {
        return $result;
    }
    public function formatResultSaveUser($result)
    {
        $result['pdf']['age'] = $this->allVar['age'];
        $result['pdf']['age2'] = $this->allVar['age2'];
        unset($result['plans']['subPlans']);
        unset($result['planRowKey']);

        return $result;
    }

    /**
     * @return int
     */
    private function nullOrEmpty($v)
    {
        return $v === null || $v === '' ? 0 : $v;
    }
}
