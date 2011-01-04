<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_Event extends ServiceClient
{
    protected $_client_type = 'api_writer';

    public function get($id=NULL)
    {
        $this->_client_type = 'default';

        $resource_uri = ($id !== NULL) ? 'event/'.$id : 'event';

        if(isset($this->_filter['group']))
        {
            $resource_uri = 'event/by_group/'.$this->_filter['group'];
        }

        Kohana::$log->add('debug', 'ServiceClient_Event::get() -- resource_uri='.$resource_uri);

        $data = $this->_request(self::HTTP_GET, $resource_uri);
        $events = $data->events->get('event');

        // no events in response
        if(count($events) === 0)
        {
            $this->data = NULL;
        }

        // single event
        elseif(count($events) === 1 AND $id !== NULL)
        {
            $this->data = new ServiceClient_Driver_Event($events[0]);
        }

        // list of events 
        else
        {
            $this->data = array();
            foreach($events as $event)
            {
                array_push($this->data, new ServiceClient_Driver_Event($event));
            }
        }
    }

    public function add_to_group($event_id, $group_id, $group_role_id = NULL)
    {
        $resource_uri = 'event/add_to_group'; 

        $post_data = array(
                'event_id' => $event_id,
                'group_id' => $group_id,
            );

        if ($member_role_id !== NULL)
        {
           $post_data['group_role_id'] = $group_role_id;
        }

        $data = $this->_request(self::HTTP_POST, $resource_uri, $post_data);
        $events = $data->events->get('event');

        // no events in response
        if(count($events) === 0)
        {
            $this->data = NULL;
        }

        // single event
        else
        {
            $this->data = array();
            foreach($events as $event)
            {
                array_push($this->data, new ServiceClient_Driver_Event($event));
            }
        }
    }

    public function make_public($event_id)
    {
        $resource_uri = 'event/make_public'; 

        $post_data = array(
                'event_id' => $event_id,
            );

        $data = $this->_request(self::HTTP_POST, $resource_uri, $post_data);
        $events = $data->events->get('event');

        // no events in response
        if(count($events) === 0)
        {
            $this->data = NULL;
        }

        // single event
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
