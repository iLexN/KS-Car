<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calTotalPrice
 *
 * @author user
 */
class CalTotalPrice
{
    //put your code here

    private $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * cal Comprehensive Premium value
     * and replace the org premium value
     *
     * @param float $sum_insured
     * @return float
     */
    public function calPremium($sum_insured)
    {
        $a2 = $this->data['a2'] ;
        $a3 = $this->data['a3'] ;
        $this->data['premium'] = ($sum_insured *
                                    ($a2 / 100)) +
                                $a3;
        return (int) (100 * ceil($this->data['premium'] / 100));
    }

    /**
     * @param int $ncd
     * @param float $price_add
     * @return array<string,float>
     */
    public function calPrice($ncd, $price_add, $type)
    {
        $i = $this->calI($ncd);

        $gross = $this->calGross($i);
        $mibValue = $this->calMibValue($gross, $i);

        $price = $this->calNetPrice($i, $mibValue);

        $total_price = $this->calOffer($price, $price_add);
        if ($type == 'Comprehensive') {
            $total_price = round($total_price, -1);
        }

        return array(
            'gross'=>$gross,
            'mibValue'=>$mibValue,
            'price'=>$price,
            'total_price'=>$total_price
        );
    }

    /**
     * @param float $i
     * @return float
     */
    private function calGross($i)
    {
        return $i *
                (1 + ($this->data['mib'] / 100));
    }

    /**
     *
     * @param float $k
     * @param float $i
     * @return float
     */
    private function calMibValue($k, $i)
    {
        return $k-$i;
    }

    /**
     * @param float $i
     * @param float $mibValue
     * @return float
     */
    private function calNetPrice($i, $mibValue)
    {
        return $mibValue +
                ($i *
                    (1-($this->data['commission']/100))
                );
    }

    /**
     * @param float $net
     * @param float $price_add
     * @return float
     */
    private function calOffer($net, $price_add)
    {
        return $net + $price_add;
    }

    /**
     *
     * @param int $ncd
     * @return float
     */
    private function calI($ncd)
    {
        $premium = $this->data['premium'];
        $loading = $this->data['loading'] / 100;
        $otherDiscount = $this->data['otherDiscount'] / 100;
        $clientDiscount = $this->data['clientDiscount'] / 100;


        $i = $premium *
                (1 + $loading) *
                (1 - $otherDiscount) *
                (1 - ($ncd / 100)) *
                (1- $clientDiscount)
                ;
        return $i;
    }

    public function calExcesses($ar)
    {
        foreach ($ar as $k => $v_ar) {
            if ($v_ar['deatils_id'] == 5) {
                $ar[$k]['value'] = $this->calExcessesGeneral();
                break;
            }
        }
        return $ar;
    }

    private function calExcessesGeneral()
    {
        $newValue = (int)$this->data['premium'] * (int)$this->data['comprehensive_general'] / 100;

        if ($newValue < $this->data['comprehensive_general_min']) {
            $newValue = $this->data['comprehensive_general_min'];
        }

        return (int) (100 * ceil($newValue / 100));
    }
}
