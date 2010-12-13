<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Event extends Controller_Page
{
    public function action_view($id=NULL)
    {
        if($id !== NULL)
        {
            $client = ServiceClient::factory('event');
            $client->get($id);

            if($client->status['type'] == 'success' AND $client->data !== NULL)
            {
                $view = View::factory('pages/event/view')
                            ->bind('event', $client->data);

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
}
