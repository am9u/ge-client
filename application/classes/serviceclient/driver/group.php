<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Group 
{
    public $id   = NULL;
    public $name = NULL;
    public $description = NULL;

    public function __construct($group_data)
    {
        $this->id   = $group_data->attributes('id');
        $this->name = $group_data->name->value();
        $this->description = $group_data->description->value();
    }
}
