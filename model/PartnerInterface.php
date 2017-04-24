<?php

interface PartnerInterface
{
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

    /**
    * save quote
    * @param array $ruleInfo rule array planName,totalPrice,price,details
    * @return array  id , refno
    * @throws Exception    error : cannot save
    */
    public function saveQuote($ruleInfo);
}
