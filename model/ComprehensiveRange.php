<?php
class ComprehensiveRange
{
    //put your code here
    public function __construct()
    {
    }

    public function add($rule_id, $from = 10000 , $to= 100000)
    {
        $add = ORM::for_table('rule-comprehensive-range')->create();
        $add->rule_id = $rule_id;
        $add->from = $from;
        $add->to = $to;
        $add->save();
    }

    /**
     *
     * @param int $rule_id
     * @return array
     */
    public function getList($rule_id)
    {
        $list = ORM::for_table('rule-comprehensive-range')
                ->where('rule_id', $rule_id)
                ->order_by_asc('from')
                ->find_array();
        return $list;
    }

    public function update($ar)
    {
        $update = ORM::for_table('rule-comprehensive-range')
                ->find_one($ar['id']);
        $update->set($ar);
        $update->save();
    }

    public function delete($ar)
    {
        $delete = ORM::for_table('rule-comprehensive-range')
                ->find_one($ar['id']);
        $delete->delete();
    }
}
