<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_Event 
{
    public $id = NULL;
    public $name = NULL;
    public $datetime = NULL;
    public $date = NULL;
    public $time = NULL;
    public $description = NULL;
    public $privacy_settings = NULL;

    public $is_public = FALSE;

    public function __construct($event)
    {
        $this->id          = $event->attributes('id'); 
        $this->name        = $event->name->value();
        $this->datetime    = $event->datetime->value();
        $this->date        = Date::formatted_time($this->datetime, 'm/d/y', 'America/New_York'); // @TODO: account for timezone of group! ie: NY.com vs LA.com
        $this->time        = Date::formatted_time($this->datetime, 'g:i A', 'America/New_York'); 
        $this->description = $event->description->value();

        $this->venue_id = $event->venue->attributes('id');

        $this->privacy_settings = array();
        foreach($event->privacy_settings->get('group') as $group)
        {
            $group_id = $group->attributes('id');

            if ($group_id == 0)
            {
                $this->is_public = TRUE;
            }
            else
            {
                $group_roles = array();

                array_push($group_roles, $group->attributes('role'));

                $this->privacy_settings[$group_id] = $group_roles;
            }
        }
    }
}
