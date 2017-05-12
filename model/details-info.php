<?php
/**
 * Details info class
 *
 */


/**
 * Details info class
 *
 */
class DetailsInfo
{
    public $r;
    public $o;

    /**
     * $r = rule id,$o = df id
     *
     * @param int|null $r
     * @param int|null $o
     */
    public function __construct($r=null, $o=null)
    {
        $this->r = $r;
        $this->o = $o;
    }

    /**
     * DEPRECATED , use getAlls
     * get all details info (old)
     *
     * @return array
     */
    public function getAll()
    {
        $details_info = $this->getAlls();
        return $this->transform($details_info);
    }

    /**
     * get all details info (new)
     *
     * @return array
     */
    public function getAlls()
    {
        $details_info = ORM::for_table('details_info')
                        ->where('active', 1)
                        ->order_by_asc('sortOrder')
                        ->order_by_asc('id')
                        ->find_array();
        return $details_info;
    }


    /**
     * get by rule id
     * @param int $rid
     * @param string $transform field
     * @return array
     */
    public function getByRule($rid, $transform='')
    {
        $details_info = ORM::for_table('rule-details-info')
                    ->table_alias('p1')
                    ->select('p1.*')
                    ->select('p1.details_info', 'deatils_id')
                    ->select('p2.en', 'details_info')
                    ->join('details_info', array('p1.details_info', '=', 'p2.id'), 'p2')
                    ->where('p1.rule', $rid)
                    ->order_by_asc('p2.sortOrder')
                    ->order_by_asc('p2.id')
                    ->find_array();
        return $this->transform($details_info, $transform);
    }

    /**
     *check exist ?
     *
     * @return boolean
    */
    public function checkNotExist()
    {
        $count = ORM::for_table('rule-details-info')
            ->where('rule', $this->r)
            ->where('details_info', $this->o)
            ->count();
        return $count > 0 ? false : true;
    }

    /**
     * Get Details info by id
     *
     * @param int $id
     * @param string $field
     * @return array
     * @throws Exception not match details_info
     */
    public function getDetailsInfoByID($id, $field = 'en')
    {
        $m = ORM::for_table('details_info') -> find_one($id);
        if ($m) {
            if ($field == 'en') {
                return $m->en;
            } elseif ($field == 'all') {
                return $m->as_array();
            }
        } else {
            throw new Exception('not match :: details_info');
        }
    }

    /**
    * DEPRECATED, use updateDetailInfoByID
    * update details info (old )
    * @param array $input
    */
    public function updateDetailsInfoByID($input)
    {
        $a = ORM::for_table('details_info') -> find_one($input['id']);
        $a->zh = $input['zhText'];
        $a->en = $input['enText'];
        $a->en_desc = $input['enTextDesc'];
        $a->zh_desc = $input['zhTextDesc'];
        $a->sortOrder = $input['sortOrder'];
        $a->save();
    }

    /**
    * update details info (new )
    * @param array $input
    */
    public function updateDetailInfoByID($input)
    {
        $a = ORM::for_table('details_info') -> find_one($input['id']);
        $a->set($input);
        $a->save();
    }

    /**
     * remove details info rule
     * @param int $orid
     */
    public function removeDetailsInfoRule($orid)
    {
        if (!empty($orid)) {
            $d = ORM::for_table('rule-details-info')->find_one($orid);
            $d->delete();
        }
    }

    /**
     * update detials info rule
     * @param int $orid
     * @param array $ar
     */
    public function updateDetailsInfoRule($orid, $ar)
    {
        if (!empty($orid)) {
            $d = ORM::for_table('rule-details-info')->find_one($orid);
            $d->value = $ar['value'];
            $d->text_en = $ar['text_en'];
            $d->text_zh = $ar['text_zh'];
            $d->save();
        }
    }
    /**
     * add detaislinfo rule
     * @param string $v
     */
    public function addDetailsInfoRule($v)
    {
        $a = ORM::for_table('rule-details-info')->create();
        $a->details_info = $this->o;
        $a->rule = $this->r;
        $a->value = $v;
        $a->save();
    }

    /**
     * newDetails info
     * @param string $en
     * @param string $zh
     * @param string $enDesc
     * @param string $zhDesc
     * @param string $sortOrder
     */
    public function newDetailsInfo($en, $zh, $enDesc, $zhDesc, $sortOrder)
    {
        $a = ORM::for_table('details_info')->create();
        $a->zh = $zh;
        $a->en = $en;
        $a->en_desc = $enDesc;
        $a->zh_desc = $zhDesc;
        $a->sortOrder = $sortOrder;
        $a->active = 1;
        $a->save();
    }

    /**
     * transform the array
     * @param array $details_info
     * @param string $field
     * @return array
     */
    private function transform($details_info, $field='')
    {
        $details_info_ar = array();
        foreach ($details_info as $row) {
            if (!empty($field)) {
                $details_info_ar[$row['id']] = $row[$field];
            } else {
                $details_info_ar[$row['id']] = $row;
                unset($details_info_ar[$row['id']]['active']);
            }
        }
        return $details_info_ar;
    }

    /**
     *
     * @param array $ids
     * @return array
     */
    public function getOrderByID($ids)
    {
        $orderArray = ORM::for_table('details_info')
                    ->select('id')
                    ->where_in('id', $ids)
                    ->order_by_asc('sortOrder')
                    ->order_by_asc('id')
                    ->find_array();

        return $orderArray;
    }
}
