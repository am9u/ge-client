<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Address
{
    public $line_1 = NULL;
    public $line_2 = NULL;
    public $city = NULL;
    public $state_province = NULL;
    public $zip = NULL;

    public function __construct($address)
    {
        $this->line_1 = $address->line_1->value();
        $this->line_2 = $address->line_2->value();
        $this->city = $address->city->value();
        $this->state_province = $address->state_province->value();
        $this->zip = $address->zip->value();
    }
}
