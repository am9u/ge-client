<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Event 
{
    public $id = NULL;
    public $name = NULL;
    public $datetime = NULL;
    public $date = NULL;
    public $time = NULL;
    public $description = NULL;

    public function __construct($event)
    {
        $this->id          = $event->attributes('id'); 
        $this->name        = $event->name->value();
        $this->datetime    = $event->datetime->value();
        $this->date        = Date::formatted_time($this->datetime, 'm/d/y', 'America/New_York'); // @TODO: account for timezone of group! ie: NY.com vs LA.com
        $this->time        = Date::formatted_time($this->datetime, 'g:i A', 'America/New_York'); 
        $this->description = $event->description->value();

        $this->venue_id = $event->venue->attributes('id');
    }
}
