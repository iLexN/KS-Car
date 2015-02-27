<?php

class DetailsInfo{
	/**
		$r = rule id
		$o = df id
	**/
	function __construct($r=null,$o=null) {
		$this->r = $r;
		$this->o = $o;
	}

	public function getAll(){
		$details_info = ORM::for_table('details_info')
                        ->where('active',1)
                        ->order_by_asc('sortOrder')
                        ->order_by_asc('id')
                        ->find_array();
		return $this->transform($details_info);
	}
	
	public function getByRule($rid,$transform=''){
            $details_info = ORM::for_table('rule-details-info')
                    ->table_alias('p1')
                    ->select('p1.id')
                    ->select('p1.value')
                    ->select('p1.details_info','deatils_id')
                    ->select('p2.en','details_info')
                    ->join('details_info', array('p1.details_info', '=', 'p2.id'), 'p2')
                    ->where('p1.rule',$rid)
                    ->order_by_asc('p2.sortOrder')
                    ->find_array();
		return $this->transform($details_info,$transform);
	}
	
        /**
         * 
         * @return boolean
         */
	public function checkNotExist(){
		$count = ORM::for_table('rule-details-info')
			->where('rule',$this->r)
			->where('details_info',$this->o)
			->count();
		return $count > 0 ? false : true;
	}
	
	public function getDetailsInfoByID($id,$field = 'en'){
		$m = ORM::for_table('details_info') -> find_one($id);
		if ( $m ){
                    if ( $field == 'en') {
			return $m->en;
                    } else if ( $field == 'all' ) {
                        return $m->as_array();
                    }
		} else {
			throw new Exception('not match :: details_info');
		}
	}
        
        /**
         * 
         * @param array $input
         */
        public function updateDetailsInfoByID($input){
            $a = ORM::for_table('details_info') -> find_one($input['id']);
            $a->zh = $input['zhText'];
            $a->en = $input['enText'];
            $a->en_desc = $input['enTextDesc'];
            $a->zh_desc = $input['zhTextDesc'];
            $a->sortOrder = $input['sortOrder'];
            $a->save();
        }
	
	public function removeDetailsInfoRule($orid){
		if ( !empty($orid) ){
			$d = ORM::for_table('rule-details-info')->find_one($orid);
			$d->delete();
		}
	}
    
    public function updateDetailsInfoRule($orid, $v){
        if ( !empty($orid) ){
			$d = ORM::for_table('rule-details-info')->find_one($orid);
			$d->value = $v;
            $d->save();
        }
    }
	
	public function addDetailsInfoRule($v){
		$a = ORM::for_table('rule-details-info')->create();
		$a->details_info = $this->o;
		$a->rule = $this->r;
		$a->value = $v;
		$a->save();
	}
	
	public function newDetailsInfo($en,$zh,$enDesc,$zhDesc,$sortOrder){
		$a = ORM::for_table('details_info')->create();
		$a->zh = $zh;
		$a->en = $en;
                $a->en_desc = $enDesc;
                $a->zh_desc = $zhDesc;
                $a->sortOrder = $sortOrder;
		$a->active = 1;
		$a->save();
	}
	
	
	private function transform($details_info,$field=''){
		$details_info_ar = array();
		foreach ($details_info as $row) {
			if (!empty($field)){
				$details_info_ar[$row['id']] = $row[$field];
			} else {
				$details_info_ar[$row['id']] = $row;
				unset($details_info_ar[$row['id']]['active']);
			}
		}
		return $details_info_ar;
	}

}


