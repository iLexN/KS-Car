<?php

class SubPlans{
	
    public function __construct() {
    }
    
    public function addSubPlans($ar) {
        $a = ORM::for_table('sub-plan')->create();
                $a->name = $ar['name'];
                $a->name_zh = $ar['name_zh'];
                $a->add_price = $ar['add_price'];
		$a->zh = $ar['zh'];
		$a->en = $ar['en'];
                $a->rule_id = $ar['rule'];
                $a->pdf_url_en = $ar['pdf_url_en'];
                $a->pdf_url_zh = $ar['pdf_url_zh'];
                $a->sortOrder = $ar['sortOrder'];
		$a->save();
    }
    
    public function updateSubPlans($ar){
        $a = ORM::for_table('sub-plan')->find_one($ar['id']);
        $a->name = $ar['name'];
        $a->name_zh = $ar['name_zh'];
        $a->add_price = $ar['add_price'];
        $a->zh = $ar['zh'];
        $a->en = $ar['en'];
        $a->pdf_url_en = $ar['pdf_url_en'];
        $a->pdf_url_zh = $ar['pdf_url_zh'];
        $a->sortOrder = $ar['sortOrder'];
        $a->save();
    }
    
    public function delSubPlans($id){
        $d = ORM::for_table('sub-plan') -> find_one($id);
        $d -> delete();
    }
    
    public static function findSubPlansByRuleID($r){
        $r_ar = ORM::for_table('sub-plan')->where('rule_id',$r)
                    ->order_by_asc('sortOrder')
                    ->find_array();
        return $r_ar;
    }
    
    public static function findSubPlansByRuleIdWithLang($r,$lang){
        
        $r_ar = ORM::for_table('sub-plan')
                    ->select('name')
                    ->select('name_zh')
                    ->select('id')
                    ->select('add_price')
                    ->select($lang,'desc')
                    ->select('pdf_url_'.$lang,'pdf')
                    ->where('rule_id',$r)
                    ->order_by_asc('sortOrder')
                    ->order_by_asc('id')
                    ->find_array();
        
        $ar = array();
        foreach ( $r_ar as $row){
            $ar[$row['id']] = $row;
        }
        
        return $ar;
    }
    
}


