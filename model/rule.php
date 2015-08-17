<?php

/**
 *rule clas
 */


/**
 * rule class
 */
class rule
{

    /**
     *seem no use anymore
     * @var string
     */
    public $path = 'rule-details/';

    /**
     * rule id
     * @param int $r rule id
     */
    public function __construct($r = null)
    {
        $this -> r = $r;
    }

    /**
     * get all rule
     * @return array
     */
    public function getAll()
    {
        //$rule = ORM::for_table('rule') -> where('active', 1) -> order_by_asc('id') -> find_array();
                $rule = ORM::for_table('rule')  
                        -> order_by_desc('active')
                        -> order_by_asc('id') 
                        -> find_array();
        return $this -> transform($rule);
    }

   /**
    * edit update
    * @param array $ar
    */
    public function editUpdate($ar)
    {
        $this -> getOne();
        $this -> rule -> rule_name = $ar['ruleName'];
        $this -> rule -> price = $ar['price'];
        $this -> rule -> price_add = $ar['priceAdd'];
        $this -> rule -> age_from = $ar['age_from'];
        $this -> rule -> age_to = $ar['age_to'];
        $this -> rule -> NCD = $ar['NCD'];
        $this -> rule -> DrivingExp = $ar['DrivingExp'];
        $this -> rule -> TypeofInsurance = $ar['TypeofInsurance'];
        $this -> rule -> Yearofmanufacture = $ar['Yearofmanufacture'];
        $this -> rule -> Yearofmanufacture_from = $ar['Yearofmanufacture_from'];
        $this -> rule -> motor_accident_yrs =  $ar['MotorAccidentYrs'];
        $this -> rule -> drive_offence_point = $ar['DriveOffencePoint'];
        $this -> rule -> active = $ar['Active'];

        $this -> rule -> save();
    }

    /**
     * get one id info
     */
    public function getOne()
    {
        $this -> rule = ORM::for_table('rule') -> find_one($this -> r);
    }

    /**
     * match rule with id
     * getOne use the $this->r , this pass $r
     *
     * @param int $r
     * @return array
     */
    public function matchRuleWithID($r)
    {
        $match_rule = ORM::for_table('rule')
                        -> select('*')
                        -> select_expr('price+price_add', 'total_price')
                        -> where('id', $r)
                        -> where('active', 1)
                        -> find_array();
        return $match_rule;
    }

    /**
     * macthc rule with var
     * find match rule with given data
     *
     * @param arry $ar
     * @return type
     */
    public function matchRuleWithVar($ar,$isTest)
    {

            //error_log( 'abc'.print_r($ar,true) );
            
        $match_rule = ORM::for_table('rule') -> table_alias('p1')
        // -> select('p1.price')
        //->select('p1.id')
        //->select('p1.rule_name')
                -> select('p1.*')
                -> select_expr('p1.price+p1.price_add', 'total_price')
                -> join('rule-model', array('p1.id', '=', 'p2.rule'), 'p2')
                -> join('rule-occ', array('p1.id', '=', 'p3.rule'), 'p3')
                -> where('p2.model', $ar['carModel'])
                -> where('p3.occ', $ar['occupation'])
                -> where_lte('p1.age_from', $ar['age'])
                -> where_gte('p1.age_to', $ar['age'])
                -> where('p1.NCD', $ar['ncd'])
                -> where('p1.DrivingExp', $ar['drivingExp'])
                -> where('p1.TypeofInsurance', $ar['insuranceType'])
                -> where('p1.motor_accident_yrs', $ar['motor_accident_yrs'])
                -> where('p1.drive_offence_point', $ar['drive_offence_point'])
                -> where_gte('p1.Yearofmanufacture', $ar['calYrMf'])
                -> where_lte('p1.Yearofmanufacture_from', $ar['calYrMf'])
                ;
                //-> where('p1.active', 1)
                //-> find_array();
        
        if (!$isTest) {
            $match_rule = $match_rule-> where('p1.active', 1);
        }
        
        return $match_rule->find_array();
    }
    
    /**
     * remove rule , rule-mode,rule-details-info,rule-occ, sub-plan
     */
    public function reMoveRule()
    {
        if (!empty($this->r)) {
            $d = ORM::for_table('rule') -> find_one($this->r);
            $d -> delete();
                
            $d2 = ORM::for_table('rule-model')->where('rule', $this->r)->delete_many();
            $d2 = ORM::for_table('rule-details-info')->where('rule', $this->r)->delete_many();
            $d2 = ORM::for_table('rule-occ')->where('rule', $this->r)->delete_many();
            $d2 = ORM::for_table('sub-plan')->where('rule_id', $this->r)->delete_many();
        }
    }

    /**
     * transform , get subplans
     * @param array $r
     * @return array
     */
    private function transform($r)
    {
        $rule_ar = array();
        foreach ($r as $row) {
            $rule_ar[$row['id']] = $row;
            $rule_ar[$row['id']]['total'] = $row['price'] + $row['price_add'];
            $rule_ar[$row['id']]['subPlans'] = SubPlans::findSubPlansByRuleID($row['id']);
        }
        return $rule_ar;
    }
}
