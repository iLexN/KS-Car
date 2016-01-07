<?php


class Driver
{
    private $data = array();
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function getDriverInfo()
    {
        return $this->data;
    }
    
}
