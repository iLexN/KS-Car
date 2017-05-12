<?php

class Owner
{
    private $id;

    //put your code here
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return array
     */
    public function getOwner()
    {
        $ar = ORM::for_table('rule-owner')
                ->where('rule_id', $this->id)
                ->find_array();
        return $ar;
    }

    public function update($data)
    {
        $this->delete();
        foreach ($data as $v) {
            $this->add($v);
        }
    }

    private function delete()
    {
        ORM::for_table('rule-owner')
                ->where('rule_id', $this->id)
                ->delete_many();
    }

    public function add($v)
    {
        $newOwner = ORM::for_table('rule-owner')->create();
        $newOwner->rule_id = $this->id;
        $newOwner->owner = $v;
        $newOwner->save();
    }
}
