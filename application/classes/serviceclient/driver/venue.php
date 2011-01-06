<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Venue 
{
    public $id = NULL;
    public $name = NULL;

    public function __construct($venue)
    {
        $this->id          = $venue->attributes('id'); 
        $this->name        = $venue->name->value();

        $this->address = new ServiceClient_Driver_Address($venue->address);
    }
}
