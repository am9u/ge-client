<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Group extends ServiceClient
{
    protected $_client_type = 'api_writer';

    public function get_base_groups($id=NULL)
    {
        $this->_client_type = 'default';
        $resource_uri = 'group/base';
        $data = $this->_request(self::HTTP_GET, $resource_uri);
        $groups = $data->groups->get('group');

        if(count($groups) === 0)
        {
            $this->data = NULL;
        }
        else
        {
            $this->data = array();
            foreach($groups as $group)
            {
                array_push($this->data, new ServiceClient_Driver_Group($group));
            }
        }
    }

    public function get($id=NULL)
    {
        $this->_client_type = 'default';
        if($id === NULL)
        {
            $resource_uri = 'group';
        }
        else
        {
            $resource_uri = 'group/'.$id;
        }

        $data = $this->_request(self::HTTP_GET, $resource_uri);

        $groups = $data->groups->get('group');

        if(count($groups) === 0)
        {
            $this->data = NULL;
        }
        elseif(count($groups) === 1)
        {
            if($id === NULL)
            {
                $this->data = array(new ServiceClient_Driver_Group($groups[0]));
            }
            else
            {
                $this->data = new ServiceClient_Driver_Group($groups[0]);
            }
        }
        else
        {
            $this->data = array();
            foreach($groups as $group)
            {
                array_push($this->data, new ServiceClient_Driver_Group($group));
            }
        }
    }

    public function create($group_data=NULL)
    {
        $resource_uri = 'group/create';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $group_data);
    }

}
