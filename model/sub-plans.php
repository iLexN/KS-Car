<?php
/**
 * subPlans class
 */


/**
 * subPlans class
 */
class SubPlans
{
   /**
    * summary
    */
    public function __construct()
    {
    }
    
    /**
     * DEPRECATED , use addSubPlan
     * add sub plans (old)
     * @param array $ar
     */
    public function addSubPlans($ar)
    {
        $a = ORM::for_table('sub-plan')->create();
        $a->name = $ar['name'];
        $a->name_zh = $ar['name_zh'];
        $a->name_sub = $ar['name_sub'];
        $a->name_sub_zh = $ar['name_sub_zh'];
        $a->add_price = $ar['add_price'];
        $a->zh = $ar['zh'];
        $a->en = $ar['en'];
        $a->rule_id = $ar['rule'];
        $a->pdf_url_en = $ar['pdf_url_en'];
        $a->pdf_url_zh = $ar['pdf_url_zh'];
        $a->sortOrder = $ar['sortOrder'];
        $a->groupID = $ar['groupID'];
        $a->save();
    }
    
    /**
     * add sub plans (new )
     * @param array $ar
     */
    public function addSubPlan($ar){
        $a = ORM::for_table('sub-plan')->create();
        $a->set($ar);
        $a->save();
    }
    
    /**
     * update subplans
     * @param array $ar
     */
    public function updateSubPlans($ar)
    {
        $a = ORM::for_table('sub-plan')->find_one($ar['id']);
        $a->name = $ar['name'];
        $a->name_zh = $ar['name_zh'];
        $a->name_sub = $ar['name_sub'];
        $a->name_sub_zh = $ar['name_sub_zh'];
        $a->add_price = $ar['add_price'];
        $a->zh = $ar['zh'];
        $a->en = $ar['en'];
        $a->pdf_url_en = $ar['pdf_url_en'];
        $a->pdf_url_zh = $ar['pdf_url_zh'];
        $a->sortOrder = $ar['sortOrder'];
        $a->groupID = $ar['groupID'];
        $a->save();
    }
    
    /**
     * del subplans
     * @param id $id
     */
    public function delSubPlans($id)
    {
        $d = ORM::for_table('sub-plan') -> find_one($id);
        $d -> delete();
    }
    
    /**
     * find subplans by rule id
     * @param int $r
     * @return array
     */
    public static function findSubPlansByRuleID($r)
    {
        $r_ar = ORM::for_table('sub-plan')->where('rule_id', $r)
                    ->order_by_asc('sortOrder')
                    ->find_array();
        return $r_ar;
    }
    
    /**
     * find sub plan by rule with lang
     * @param int $r
     * @param string $lang en/zh
     * @return array
     */
    public static function findSubPlansByRuleIdWithLang($r, $lang)
    {
        /** @var $r_ar \ORM */
        $r_ar = ORM::for_table('sub-plan')
                    ->select('name')
                    ->select('name_zh')
                    ->select('name_sub')
                    ->select('name_sub_zh')
                    ->select('id')
                    ->select('add_price')
                    ->select('groupID')
                    ->select($lang, 'desc')
                    ->select('pdf_url_'.$lang, 'pdf')
                    ->where('rule_id', $r)
                    ->order_by_asc('sortOrder')
                    ->order_by_asc('id')
                    ->find_array();
        
        $ar = array();
        foreach ($r_ar as $row) {
            $ar[$row['id']] = $row;
        }
        
        return $ar;
    }
    
}
