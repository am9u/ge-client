<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_User 
{
    public $token = NULL;
    public $username = NULL;
    public $roles = NULL;

    public function __construct($user_data)
    {
        $this->token    = $user_data->attributes('token');
        $this->username = $user_data->username->value();
        $this->roles    = array();
        
        foreach($user_data->get('role') as $role)
        {
            array_push($this->roles, $role->value());
        }
    }
}
