<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Event extends ServiceClient
{
    protected $_client_type = 'api_writer';

    public function get($id=NULL)
    {
        $this->_client_type = 'default';
        if($id === NULL)
        {
            $resource_uri = 'event';
        }
        else
        {
            $resource_uri = 'event/'.$id;
        }

        $data = $this->_request(self::HTTP_GET, $resource_uri);

        $events = $data->events->get('event');

        if(count($events) === 0)
        {
            $this->data = NULL;
        }
        elseif(count($events) === 1)
        {
            $this->data = new ServiceClient_Driver_Event($events[0]);
        }
        else
        {
            $this->data = array();
            foreach($events as $event)
            {
                array_push($this->data, new ServiceClient_Driver_Event($event));
            }
        }
    }

}
