<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Event extends Controller_AuthPage
{
    /**
     *
     */
    public function action_index()
    {
        $client = ServiceClient::factory('event');
        $client->get();

        if($client->status['type'] == 'success')
        {
            $view = View::factory('pages/event/index')
                        ->bind('events', $client->data);

            $this->page_title = 'Events';
            $this->_content = $view;
        }
    }

    /**
     *
     */
    public function action_view($id=NULL)
    {
        if($id !== NULL)
        {
            $client = ServiceClient::factory('event');
            $client->get($id);

            if($client->status['type'] == 'success' AND $client->data !== NULL)
            {
                
                $event = $client->data; 

                if ($event->is_public OR self::is_group_required($event->privacy_settings)) 
                {
                    $view = View::factory('pages/event/view')
                                ->bind('event', $event);

                    $this->page_title = $client->data->name;
                    $this->_content = $view;
                }
                else
                {
                    throw new Kohana_Request_Exception('Page Not Found', NULL, 404);
                }
            }
            else
            {
                throw new Kohana_Request_Exception('Page Not Found', NULL, 404);
            }
        }
        else
        {
            throw new Kohana_Request_Exception('Page Not Found', NULL, 404);
        }
    }
}
