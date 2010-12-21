<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Group 
{
    public $id = NULL;
    public $name = NULL;
    public $description = NULL;

    public function __construct($group)
    {
        $this->id          = $group->attributes('id'); 
        $this->name        = $group->name->value();
        $this->description = $group->description->value();
    }
}
