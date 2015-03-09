<?php
/**
 * occ class
 */


/**
 * occ class
 */
class occ
{
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
     * get all occ
     * @return array
     */
    public function getAll()
    {
        $occupation = ORM::for_table('occupation')->where('active', 1)->order_by_asc('en')->find_array();
        return $this->transform($occupation);
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
        //return $this->transform($occupation);
                return $occupation;
    }
    
    /*cos need multi select
    public function checkNotExist(){
        $count = ORM::for_table('rule-occ')
            ->where('rule',$this->r)
            ->where('occ',$this->o)
            ->count();
        
        return $count > 0 ? false : true;
    }*/
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
    /*cos need multi select
    public function addOccRule(){
        $a = ORM::for_table('rule-occ')->create();
        $a->occ = $this->o;
        $a->rule = $this->r;
        $a->save();
    }*/
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
    public function newOcc($en, $zh)
    {
        $a = ORM::for_table('occupation')->create();
        $a->zh = $zh;
        $a->en = $en;
        $a->active = 1;
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
