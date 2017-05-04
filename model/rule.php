<?php

/**
 *rule clas
 */


/**
 * rule class
 */
class Rule
{
    /**
     *seem no use anymore
     * @var string
     */
    public $path = 'rule-details/';

    public $rule;

    public $r;

    /**
     * rule id
     * @param int|null $r rule id
     */
    public function __construct($r = null)
    {
        $this -> r = $r;
    }

    /**
     * DEPRECATED , may remove cos DEPRECATED
     * get all rule () for old rule.php
     * use getAlls
     * @return array
     */
    public function getAll()
    {
        $rule = $this->getAlls();
        return $this -> transform($rule);
    }

    /**
     * get all rule for new ajax
     * @return array
     */
    public function getAlls()
    {
        $rule = ORM::for_table('rule')
                    -> order_by_desc('active')
                    -> order_by_asc('id')
                    -> find_array();

        return $rule;
    }


   /**
    * DEPRECATED , use update
    * edit update(old)
    * @param array $ar
    */
    public function editUpdate($ar)
    {
        $this -> getOne();
        $this -> rule -> rule_name = $ar['ruleName'];
        $this -> rule -> age_from = $ar['age_from'];
        $this -> rule -> age_to = $ar['age_to'];
        $this -> rule -> DrivingExp = $ar['DrivingExp'];
        $this -> rule -> TypeofInsurance = $ar['TypeofInsurance'];
        $this -> rule -> Yearofmanufacture = $ar['Yearofmanufacture'];
        $this -> rule -> Yearofmanufacture_from = $ar['Yearofmanufacture_from'];
        $this -> rule -> motor_accident_yrs =  $ar['MotorAccidentYrs'];
        $this -> rule -> drive_offence_point = $ar['DriveOffencePoint'];
        $this -> rule -> active = $ar['Active'];
        $this -> rule -> premium = $ar['premium'];
        $this -> rule -> loading = $ar['loading'];
        $this -> rule -> otherDiscount = $ar['otherDiscount'];
        $this -> rule -> clientDiscount = $ar['clientDiscount'];
        $this -> rule -> mib = $ar['mib'];
        $this -> rule -> commission = $ar['commission'];
        $this -> rule -> a2 = $ar['a2'];
        $this -> rule -> a3 = $ar['a3'];
        $this -> rule -> save();
    }

    /**
    * edit update (new)
    * @param array $ar
    */
    public function update($ar)
    {
        $this->getOne();
        $this->rule->set($ar);
        $this->rule->save();
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
     * @param array $r
     * @return array
     */
    public function matchRuleWithID($r, $ncd)
    {
        $rIDsArray = explode(',', $r);

        $match_rule = ORM::for_table('rule')
                        -> table_alias('p1')
                        -> select('p1.*')
                        -> select('p4.price_add', 'price_add')
                        -> join('rule-ncd', array('p1.id', '=', 'p4.rule_id'), 'p4')
                        -> where_in('p1.id', $rIDsArray)
                        -> where('p4.ncd', $ncd)
                        -> where('active', 1)
                        -> find_array();
        return $match_rule;
    }

    /**
     * macthc rule with var
     * find match rule with given data
     *
     * @param array $ar
     * @return array
     */
    public function matchRuleWithVar($ar, $isTest)
    {
        $age = $this->processAge($ar['age']);
        if ( $age === -1 ) {
            return array();
        }

        $match_rule = ORM::for_table('rule')
                -> table_alias('p1')
                -> select('p1.*')
                -> select('p4.price_add', 'price_add')
                -> join('rule-model', array('p1.id', '=', 'p2.rule'), 'p2')
                -> join('rule-occ', array('p1.id', '=', 'p3.rule'), 'p3')
                -> join('rule-ncd', array('p1.id', '=', 'p4.rule_id'), 'p4')
                -> join('rule-owner', array('p1.id', '=', 'p5.rule_id'), 'p5')
                -> where('p2.model', $ar['carModel'])
                -> where('p3.occ', $ar['occupation'])
                -> where('p4.ncd', $ar['ncd'])
                -> where_lte('p1.age_from', $age)
                -> where_gte('p1.age_to', $age)
                -> where('p1.DrivingExp', $ar['drivingExp'])
                -> where('p1.motor_accident_yrs', $ar['motor_accident_yrs'])
                -> where('p1.drive_offence_point', $ar['drive_offence_point'])
                -> where_gte('p1.Yearofmanufacture', $ar['calYrMf'])
                -> where_lte('p1.Yearofmanufacture_from', $ar['calYrMf'])
                ->where('p5.owner',$ar['owner'])
                ;

        $match_rule = $this->matchRuleForInsType($match_rule, $ar);
        $match_rule = $this->matchRuleIsTest($match_rule, $isTest);

        return $match_rule->find_array();
    }

    private function matchRuleIsTest(\ORM $match_rule,$isTest)
    {
        if (!$isTest) {
            $match_rule-> where('p1.active', 1)
                        -> where('p4.active', 1);
        }
        return $match_rule;
    }

    private function matchRuleForInsType(\ORM $match_rule,$ar)
    {
        switch ($ar['insuranceType']) {
            case 'Comprehensive_Third_Party':
                $match_rule->where_any_is(array(
                        array('p1.TypeofInsurance' => 'Third_Party_Only'),
                        array('p1.TypeofInsurance' => 'Comprehensive', 'p6.to' => $ar['sum_insured'] , 'p6.from'=>$ar['sum_insured'])),
                        array('p6.to' => '>=', 'p6.from'=>'<='))
                    ->left_outer_join('rule-comprehensive-range', array('p1.id', '=', 'p6.rule_id'), 'p6');

                break;
            case 'Comprehensive':
                $match_rule-> where('p1.TypeofInsurance', $ar['insuranceType'])
                    ->join('rule-comprehensive-range', array('p1.id', '=', 'p6.rule_id'), 'p6')
                    -> where_gte('p6.to', $ar['sum_insured'])
                    -> where_lte('p6.from', $ar['sum_insured']);
                break;
            case 'Third_Party_Only':
                $match_rule-> where('p1.TypeofInsurance', $ar['insuranceType']);
                break;

            default:
                break;
        }

        return $match_rule;
    }

    /**
     * @param int $age
     * @return int
     */
    private function processAge($age)
    {
        if ($age == 99 || $age == 88) {
            return -1;
        }

        if ($age  == 1 || $age == 2) {
            return 30;
        }

        return $age;
    }

    /**
     * remove rule , rule-mode,rule-details-info,rule-occ, sub-plan
     */
    public function reMoveRule()
    {
        if (!empty($this->r)) {
            $d = ORM::for_table('rule') -> find_one($this->r);
            $d -> delete();

            ORM::for_table('rule-model')->where('rule', $this->r)->delete_many();
            ORM::for_table('rule-ncd')->where('rule_id', $this->r)->delete_many();
            ORM::for_table('rule-details-info')->where('rule_id', $this->r)->delete_many();
            ORM::for_table('rule-occ')->where('rule', $this->r)->delete_many();
            ORM::for_table('sub-plan')->where('rule_id', $this->r)->delete_many();
        }
    }

    /**
     * add new Rule
     *
     * @return int
     */
    public function newRule()
    {
        $rm = ORM::for_table('rule') -> create();
        $rm -> rule_name = 'rule name';
        $rm -> active = 0;
        $rm -> save();
        return $rm->id;
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
            $rule_ar[$row['id']]['subPlans'] = SubPlans::findSubPlansByRuleID($row['id']);
            $rule_ar[$row['id']]['ncd_rule'] = car::getRuleNcd($row['id']);
        }
        return $rule_ar;
    }

    public function compareDriverRule($rule1, $rule2)
    {
        $ruleOutArray = array();
        foreach ($rule1 as  $v_ar1) {
            foreach ($rule2 as $v_ar2) {
                if ($v_ar1['id'] == $v_ar2['id']) {
                    $ruleOutArray[] = $v_ar1;
                }
            }
        }
        return $ruleOutArray;
    }
}
