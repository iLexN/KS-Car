<?php

class GoBear implements \PartnerInterface
{
    private $data = [];

    /**
     * @var \Car
     */
    private $car;


    /**
     * @var \Occ
     */
    private $occ;

    public $saveUser = false;
    public $skipFindRule = false;
    public $hasDriver2 = false;
    public $isTest = false;

    public function __construct($data, \Car $car, \Occ $occ)
    {
        $this->car = $car ;
        $this->occ = $occ;

        $this->data['carModel'] = (int) $data['model'];
        $this->data['carMake'] = (int) $data['make'];
        $this->data['occupation'] = (int) $data['occupation'];
        $this->data['age'] = (int) $data['age'];
        $this->data['ncd'] = (int)  $data['ncd'] ;
        $this->data['drivingExp'] = $data['drivingExp']; //gt_2yr / 1to2 / lt_1yr
        $this->data['insuranceType'] = $data['insuranceType']; //Third_Party_Only / Comprehensive / Comprehensive_Third_Party
        $this->data['motor_accident_yrs'] = 0;
        $this->data['drive_offence_point'] = 0;
        $this->data['calYrMf'] = calYrMf($data['year']);
        $this->data['sum_insured'] = isset($data['sum_insured']) ? $data['sum_insured'] : 0;

        $this->data['lang'] = 'en';
    }

    public function getData($k = '')
    {
        if ($k === '') {
            return $this->data;
        }

        return isset($this->data[$k]) ? $this->data[$k] : null;
    }

    public function getDriver1Data()
    {
        $ar = [];
        $ar['carModel'] = $this->data['carModel'];
        $ar['carMake'] = $this->data['carMake'];
        $ar['occupation'] = $this->data['occupation'];
        $ar['age'] = $this->data['age'];
        $ar['ncd'] = $this->data['ncd'];
        $ar['drivingExp'] = $this->data['drivingExp'];
        $ar['insuranceType'] = $this->data['insuranceType'];
        $ar['motor_accident_yrs'] = $this->data['motor_accident_yrs'];
        $ar['drive_offence_point'] = $this->data['drive_offence_point'];
        $ar['calYrMf'] = $this->data['calYrMf'];

        return $ar;
    }

    public function getDriver2Data()
    {
        return null;
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
     * @param array $rules
     * @return array
     */
    private function formatRule($rule)
    {
        return $rule;
    }

    public function validationInput()
    {
        $this->car->getInsuranceTypeByID($this->data['insuranceType']);
        $this->car->getDriveExpByID($this->data['drivingExp']);
        $this->car->getMakeByID($this->data['carMake']);
        $this->car->getModelByID($this->data['carModel'], '', $this->data['carMake']);
        $this->occ->getOccByID($this->data['occupation'], 'en');
    }

    public function getOwner()
    {
        return 'gobear';
    }

    public function formatResultMatchRule($result)
    {
        return $result;
    }

    public function formatResultSaveUser($result)
    {
        return $result;
    }

    public function saveQuote($ruleInfo){
        
    }
}
