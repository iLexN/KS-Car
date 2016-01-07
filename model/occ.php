<?php
/**
 * occ class
 */


/**
 * occ class
 */
class Occ
{
    
    public $r;
    public $o;
    
    /**
     * $r = rule id,$o = occ id
     * @param int $r rule id
     * @param int $o occ id
     */
    public function __construct($r=null, $o=null)
    {
        $this->r = $r;
        $this->o = $o;
    }

    /**
     * DEPRECATED , use getAlls
     * get all occ (old)
     * @return array
     */
    public function getAll()
    {
        $occupation = $this->getAlls();
        return $this->transform($occupation);
    }
    
    /**
     * get all occ (new)
     * @return array
     */
    public function getAlls()
    {
        $occupation = ORM::for_table('occupation')->where('active', 1)->order_by_asc('en')->find_array();
        return $occupation;
    }
    
    /**
     * get occ by rule
     * @param id $rid
     * @return array
     */
    public function getByRule($rid)
    {
        $occupation = ORM::for_table('rule-occ')
                    ->table_alias('p1')
                    ->select('p1.id')
                    ->select('p1.occ')
                    ->select('p2.en', 'occupation')
                    ->join('occupation', array('p1.occ', '=', 'p2.id'), 'p2')
                    ->where('p1.rule', $rid)
                    ->order_by_asc('p2.en')
                    ->find_array();
        return $occupation;
    }
    
    
    /**
     * check the rule have occ exist
     * @param id $occID
     * @return boolean
     */
    public function checkNotExist($occID)
    {
        $count = ORM::for_table('rule-occ')
            ->where('rule', $this->r)
            ->where('occ', $occID)
            ->count();
        
        return $count > 0 ? false : true;
    }
    
    /**
     * get occ by id
     * @param id $id
     * @param string $lang en/zh
     * @return string
     * @throws Exception
     */
    public function getOccByID($id, $lang='en')
    {
        if (empty($id)){
            return '';
        }
        
        $m = ORM::for_table('occupation') -> find_one($id);
        if ($m) {
            if ($lang == 'en') {
                return $m->en;
            } else {
                return $m->zh;
            }
        } else {
            throw new Exception('not match :: occupation');
        }
    }
    
    public function removeOcc($ar)
    {
        ORM::for_table('occupation')->where_in('id',$ar)->delete_many();   
    }
    
    public function removeOccRuleByOcids($ar)
    {
            ORM::for_table('rule-occ')
                    ->where_in('occ',$ar)
                    ->delete_many();
    }


    /**
     * remove occ from rule
     * @param id $orid
     */
    public function removeOccRule($orid)
    {
        if (!empty($orid)) {
            $d = ORM::for_table('rule-occ')->find_one($orid);
            $d->delete();
        }
    }
    
    /**
     * add occ to rule
     * @param int $occID occ id
     */
    public function addOccRule($occID)
    {
        $a = ORM::for_table('rule-occ')->create();
        $a->occ = $occID;
        $a->rule = $this->r;
        $a->save();
    }
    
    /**
     * new occ
     * @param string $en
     * @param string $zh
     */
    public function newOcc($en, $zh,$en_order,$zh_order)
    {
        $a = ORM::for_table('occupation')->create();
        $a->zh = $zh;
        $a->en = $en;
        $a->active = 1;
        $a->en_order = $en_order;
        $a->zh_order = $zh_order;
        $a->save();
    }
    
    /**
     * Old update for occ
     * @param type $en
     * @param type $zh
     * @param type $id
     * @param type $en_order
     * @param type $zh_order
     */
    public function updateOcc($en, $zh,$id,$en_order,$zh_order)
    {
        $a = ORM::for_table('occupation')->find_one($id);
        $a->zh = $zh;
        $a->en = $en;
        $a->en_order = $en_order;
        $a->zh_order = $zh_order;
        $a->save();
    }
    
    /**
     * New update for Occupation
     * @param array $ar data array
     */
    public function updateOccupation($ar) {
        
         $a = ORM::for_table('occupation')->find_one($ar['id']);
         $a->set($ar);
         $a->save();
    }
    
    
    /**
     * transform the array info
     * @param array $occupation
     * @param string $field table field
     * @return array
     */
    private function transform($occupation, $field='')
    {
        $occupation_ar = array();
        foreach ($occupation as $row) {
            if (!empty($field)) {
                $occupation_ar[$row['id']] = $row[$field];
            } else {
                $occupation_ar[$row['id']] = $row;
                unset($occupation_ar[$row['id']]['active']);
            }
        }
        return $occupation_ar;
    }
}
