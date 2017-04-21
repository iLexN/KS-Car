<?php

interface PartnerInterface
{
    public function __construct($data, \Car $car, \Occ $occ);
    public function getData($k = '');
    public function getDriver1Data();
    public function formatRules($rules);
    public function validationInput();
    public function getOwner();

    public function formatResultMatchRule($result);

    public function formatResultSaveUser($result);
}
