<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Event 
{
    public $id = NULL;
    public $name = NULL;
    public $date = NULL;
    public $time = NULL;
    public $description = NULL;

    public function __construct($event)
    {
        $this->id          = $event->attributes('id'); 
        $this->name        = $event->name->value();
        $this->date        = Date::formatted_time($event->datetime->value(), 'm/d/y', 'America/New_York'); // @TODO: account for timezone of group! ie: NY.com vs LA.com
        $this->time        = Date::formatted_time($event->datetime->value(), 'g:i A', 'America/New_York'); 
        $this->description = $event->description->value();
    }
}
