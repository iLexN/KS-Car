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
        return $this->data['premium'];
    }
    
    public function calPrice($ncd, $price_add)
    {
        $i = $this->calI($ncd);
        
        $gross = $this->calGross($i);
        $mibValue = $this->calMibValue($gross, $i);
        
        $price = $this->calNetPrice($i, $mibValue);
        
        $total_price = $this->calOffer($price, $price_add);
     
        return array(
            'gross'=>$gross,
            'mibValue'=>$mibValue,
            'price'=>$price,
            'total_price'=>$total_price
        );
    }
    
    private function calGross($i)
    {
        return $i *
                (1 + ($this->data['mib'] / 100));
    }
    
    private function calMibValue($k, $i)
    {
        return $k-$i;
    }
    
    private function calNetPrice($i, $mibValue)
    {
        return $mibValue +
                ($i *
                    (1-($this->data['commission']/100))
                );
    }
    
    private function calOffer($net, $price_add)
    {
        return $net + $price_add;
    }
    
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
}
