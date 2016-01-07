<?php

/**
 * Car Class
 */

/**
 * car class
 *
 * $r = rule id
 * $m = make id
 */
class Car
{
    
    public $r;
    public $m;
    
    /**
     * r = rlue id
     * m = make id
     *
     * @param int $r
     * @param int $m
     */
    public function __construct($r = null, $m = null)
    {
        $this -> r = $r;
        $this -> m = $m;
    }

    /**
     * DEPRECATED, use getAllsMake
     * get all make (old)
     *
     * @return array
     */
    public function getAllMake()
    {
        $m = $this->getAllsMake();
        $make_ar = array();
        foreach ($m as $row) {
            $make_ar[$row['id']] = $row;
        }
        return $make_ar;
    }
    
    /**
     * get all makes (new)
     * @return type
     */
    public function getAllsMake()
    {
        $m = ORM::for_table('make')
                        -> select_many('id', 'make')
                        -> where('active', 1)
                        -> order_by_asc('make')
                        -> find_array();
        return $m;
    }

    /**
     * get all model , for modx
     *
     * @return array
     */
    public function getAllModel()
    {
        $m = ORM::for_table('model')
                        -> select_many('id', 'model', 'make')
                        ->order_by_asc('model')
                        -> find_array();
        $m_ar = array();
        foreach ($m as $row) {
            $m_ar[$row['make']][$row['id']] = $row['model'];
        }
        return $m_ar;
    }
        
    /**
     * del model by id , also del from ruel-model, model tbl
     *
     * @param int $id   modelID
     * @return array     seem no use
     */
    public function delModelFromListByID($id)
    {
        $m = ORM::for_table('model')->find_one($id)->delete();
        $rm = ORM::for_table('rule-model')->where('model', $id)->delete_many();
        return array($m,$rm);
    }
        
    /**
     * use delModelFormListByID($id) to del the model under the make
     * @param int $id   makeID
     *
    * @return void
    */
    public function delMakeFromListByID($id)
    {
        ORM::for_table('make')->find_one($id)->delete();
            
        $ar = $this->getModelByMake($id);
        foreach ($ar as $model_ar) {
            $this->delModelFromListByID($model_ar['id']);
        }
    }

        /**
         * test the id in db or not
         *
         * @param int $id       makeID
         * @return string        makeText
         * @throws Exception    if can't find the id
         */
    public function getMakeByID($id)
    {
        if (empty($id)) {
            return '';
        }
        
        if ($id == '9999') {
            return '';
        }

        $m = ORM::for_table('make') -> find_one($id);
        if ($m) {
            return $m -> make;
        } else {
            throw new Exception('not match :: carMake');
        }
    }

    /**
     *get Model by id
     *
     * @param int $id
     * @param string $otherText
     * @param int $make_id
     * @return string model text / $otherText
     * @throws Exception
     */
    public function getModelByID($id, $otherText, $make_id)
    {

        // id/otherText 'is the free text'
        if ($make_id == '9999') {
            return $id;
        }
        if (!empty($otherText)) {
            return $otherText;
        }

        $m = ORM::for_table('model') -> find_one($id);
        if ($m) {
            return $m -> model;
        } else {
            throw new Exception('not match :: carModel');
        }
    }

    /**
     * get model by make id
     *
     * @param int $id
     * @return array
     */
    public function getModelByMake($id)
    {
        $m = ORM::for_table('model')
                        -> select_many('id', 'model')
                        -> where('make', $id)
                        -> order_by_asc('model')
                        -> find_array();
        $m_ar = array();
        foreach ($m as $row) {
            $m_ar[] = $row;
        }
        return $m_ar;
    }

    /**
     * * check model exist
     *
     * @param int $m
     * @return boolean
     */
    public function checkNotExist($m)
    {
        $count = ORM::for_table('rule-model')
                        -> where('rule', $this -> r)
                        -> where('model', $m)
                        -> count();
        return $count > 0 ? false : true;
    }
    

    /**
     * add new model
     *
     * @param string $displayName
     */
    public function addNewModel($displayName)
    {
        $rm = ORM::for_table('model') -> create();
        $rm -> model = $displayName;
        $rm -> make = $this -> m;
        $rm -> active = 1;
        $rm -> save();
    }

    /**
     * add new make
     *
     * @param string $displayName
     */
    public function addNewMake($displayName)
    {
        $rm = ORM::for_table('make') -> create();
        $rm -> make = $displayName;
        $rm -> active = 1;
        $rm -> save();
    }


        /**
         * add model rule
         *
         * @param int $m
         */
        public function addModelRule($m)
        {
            $rm = ORM::for_table('rule-model') -> create();
            $rm -> model = $m;
            $rm -> rule = $this -> r;
            $rm -> save();
        }

    /**
     *  get model by rule
     *
     * @param string $id
     * @return array
    */
    public function getModelByRule($id)
    {
        $make_ar = $this -> getAllMake();
        $m = ORM::for_table('rule-model')
                        -> table_alias('p1')
                        -> select('p1.id')
                        -> select('p1.model')
                        -> select('p2.model', 'modelText')
                        -> select('p2.make')
                        -> join('model', array('p1.model', '=', 'p2.id'), 'p2')
                        -> where('p1.rule', $id)
                        -> order_by_asc('p2.make')
                        -> order_by_asc('p2.model')
                        -> find_array();
        $model_ar = array();
        foreach ($m as $row) {
            $ar = $row;
            $ar['makeText'] = $make_ar[$row['make']]['make'];
            array_push($model_ar, $ar);
        }
        return $model_ar;
    }

    /**
     * get ncd
     *
     * @return array
     */
    public function getNCD()
    {
        $f = 'ncd';
        $m = ORM::for_table('ncd') -> order_by_asc($f) -> find_array();
        $r = array();
        foreach ($m as  $v) {
            $r[$v[$f]] = $v[$f] . '%';
        }
        return $r;
    }
    
    public static function getRuleNcd($rid)
    {
        $m = ORM::for_table('rule-ncd')
                ->where('rule_id', $rid)
                -> order_by_asc('ncd') -> find_array();
        return $m;
    }
    
    public static function createRuleNcd($rid, $ncd, $price_add)
    {
        $rm = ORM::for_table('rule-ncd') -> create();
        $rm -> rule_id = $rid;
        $rm -> ncd = $ncd;
        $rm -> active = 0;
        $rm -> price_add = $price_add;
        $rm -> save();
    }
    
    public static function updateRuleNcd($id, $ar)
    {
        $rm = ORM::for_table('rule-ncd') -> find_one($id);
        $rm->set($ar);
        $rm->save();
    }



    /**
     * get insurance type
     *
     * @param int $t 1=en,2=en+zh
     * @return array
     */
    public function getInsuranceType($t = 1)
    {
        $m = ORM::for_table('insurance-type') -> find_array();
        $r = array();
        switch ($t) {
            case 1 :
                // en
                foreach ($m as $k => $v) {
                    $r[$v['id_value']] = $v['name_en'];
                }
                break;
            case 2 :
                foreach ($m as $k => $v) {
                    $r[$v['id_value']]['en'] = $v['name_en'];
                    $r[$v['id_value']]['zh'] = $v['name_zh'];
                }
                break;
        }
        return $r;
    }

    /**
     * get insurance type by ID
     *
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function getInsuranceTypeByID($id)
    {
        $m = ORM::for_table('insurance-type')
                        -> where('id_value', $id)
                        -> find_one();
        if ($m) {
            return $m -> name_en;
        } else {
            throw new Exception('not match ::  insurance-type');
        }
    }

    /**
     * get DriveExp
     * @param int $t
     * @return array
     */
    public function getDriveExp($t = 1)
    {
        $m = ORM::for_table('driving-exp') -> find_array();

        $r = array();
        switch ($t) {
            case 1 :
                // en
                foreach ($m as $k => $v) {
                    $r[$v['id_value']] = $v['name_en'];
                }
                break;
            case 2 :
                foreach ($m as $k => $v) {
                    $r[$v['id_value']]['en'] = $v['name_en'];
                    $r[$v['id_value']]['zh'] = $v['name_zh'];
                }
                break;
        }
        return $r;
    }

    /**
     * get drive exp by id
     *
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function getDriveExpByID($id)
    {
        if (empty($id)) {
            return '';
        }
        
        $m = ORM::for_table('driving-exp')
                        -> where('id_value', $id)
                        -> find_one();
        if ($m) {
            return $m -> ksi;
        } else {
            throw new Exception('not match :: driving-exp');
        }
    }

    /**
     * remove model Rule
     * @param int $id
     */
    public function removeModelRule($id)
    {
        if (!empty($id)) {
            $d = ORM::for_table('rule-model') -> find_one($id);
            $d -> delete();
        }
    }
    
    /**
     * DEPRECATED 
     * add new Rule
     * not used . moved to Rule class
     *
     * @return int
     
    public function newRule()
    {
        $rm = ORM::for_table('rule') -> create();
        $rm -> rule_name = 'rule name';
        $rm -> active = 0;
        $rm -> save();
        return $rm->id;
    }
     */
}
