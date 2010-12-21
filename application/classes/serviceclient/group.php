<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Group extends ServiceClient
{
    protected $_client_type = 'api_writer';

    public function get($id=NULL)
    {
        $this->_client_type = 'default';

        $resource_uri = ($id !== NULL) ? 'group/'.$id : 'group';

        $data = $this->_request(self::HTTP_GET, $resource_uri);
        $data = $data->groups->get('group');

        // no events in response
        if(count($data) === 0)
        {
            $this->data = NULL;
        }

        // single event
        elseif(count($data) === 1 AND $id !== NULL)
        {
            $this->data = new ServiceClient_Driver_Group($data[0]);
        }

        // list of events 
        else
        {
            $this->data = array();
            foreach($data as $data)
            {
                array_push($this->data, new ServiceClient_Driver_Group($data));
            }
        }
    }

    public function get_by_name($name)
    {
        $this->_client_type = 'default';

        $resource_uri = 'group/get_by_name/'.$name;

        $data = $this->_request(self::HTTP_GET, $resource_uri);
        $data = $data->groups->get('group');

        // no events in response
        if(count($data) === 0)
        {
            $this->data = NULL;
        }

        // single event
        elseif(count($data) === 1 AND $name !== NULL)
        {
            $this->data = new ServiceClient_Driver_Group($data[0]);
        }

        // list of events 
        else
        {
            $this->data = array();
            foreach($data as $data)
            {
                array_push($this->data, new ServiceClient_Driver_Group($data));
            }
        }
    }
}
