<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PartnerFactory
 *
 * @author user
 */
class PartnerFactory
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param type $p
     * @return \PartnerInterface
     */
    public function createPartner($p)
    {
        switch ($p) {
            case 'gobear':
                return new \GoBear($this->data, new \Car, new \Occ);

            case 'ksApi':
                return new \MotorQuote($this->data, new \Car, new \Occ);

            default:
                break;
        }
    }
}
