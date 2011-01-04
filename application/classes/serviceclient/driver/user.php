<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Driver_User 
{
    public $id = NULL;
    public $token = NULL;
    public $username = NULL;
    public $roles = NULL;
    public $groups = NULL;

    public function __construct($user_data)
    {
        $this->id       = $user_data->attributes('id');
        $this->token    = $user_data->attributes('token');
        $this->username = $user_data->username->value();
        $this->roles    = array();
        
        foreach($user_data->get('role') as $role)
        {
            array_push($this->roles, $role->attributes('name'));
        }

        $this->groups = array();
        foreach($user_data->groups->get('group') as $group)
        {
            $group_roles = array();
            foreach($group->roles->get('role') as $group_role)
            {
                array_push($group_roles, $group_role->attributes('name'));
            }

            array_push($this->groups, array(
                'id' => $group->attributes('id'), 
                'name' => $group->name->value(),
                'roles' => $group_roles,
            ));

        }
    }
}
