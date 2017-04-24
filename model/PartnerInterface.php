<?php

interface PartnerInterface
{
    /**
     *
     * @param array $data
     * @param \Car $car
     * @param \Occ $occ
     */
    public function __construct($data, \Car $car, \Occ $occ);

    /**
     *
     * @param string $k
     * @return mixed
     */
    public function getData($k = '');

    /**
     * @return array
     */
    public function getDriver1Data();
    /**
     * @return array
     */
    public function getDriver2Data();
    /**
     *
     * @param array $rules
     * @return array
     */
    public function formatRules($rules);
    /**
     * @return void
     */
    public function validationInput();
    /**
     * @return string
     */
    public function getOwner();

    /**
     *
     * @param array $result
     * @return array
     */
    public function formatResultMatchRule($result);

    /**
     *
     * @param array $result
     * @return array
     */
    public function formatResultSaveUser($result);
}
