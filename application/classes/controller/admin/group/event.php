<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Group_Event extends Controller_Admin_Event
{
    public $auth_required = FALSE;
    public $group_required = 'group_admin';

    /**
     * Returns Array of Venue hashes
     * @TODO: move this to a Helper or Model_Venue(extends from Model_XMLRPC?)
     */
    private function _get_venues()
    {
        // get data from REST endpoint
        $client   = REST_client::instance(); 
        $response = $client->get('venue');

        // working with the XML response
        $data   = XML::factory(NULL, NULL, $response->data);
        $venues = array();

        foreach($data->get('venue') as $venue)
        {
            $venues[] = array(
                'id'             => $venue->attributes('id'),
                'name'           => $venue->name->value(),
                'line_1'         => $venue->line_1->value(),
                'line_2'         => $venue->line_2->value(),
                'city'           => $venue->city->value(),
                'state_province' => $venue->state_province->value(),
                'zip'            => $venue->zip->value()
            );
        }

        return $venues;
    }

    /**
     * Renders Events Admin index
     */
    public function action_index()
    {

        $this->page_title = "Events";
        $view = View::factory("pages/admin/event/index");

        $client = ServiceClient::factory('event', array(
                        'group' => $this->_group_id,
                    ));

        $client->get();

        if($client->status['type'] !== 'error')
        {
            $view->bind('events', $client->data);    
        }

        $this->_content = $view;
    }


    /**
     * Renders Create Event Admin page
     */
    public function action_create() 
    {
        $group_id = NULL;
        $group_name = Request::instance()->param('group', NULL);
        if($group_name !== NULL)
        {
            $group_client = ServiceClient::factory('group');
            $group_client->get_by_name($group_name);
            if($group_client->status['type'] !== 'error')
            {
                $group_id = $group_client->data->id;
                Kohana::$log->add('debug', 'Controller_Admin_Event::action_create() -- $group_id='.$this->_group_id);
            }
        }

        $this->page_title = "Create Event";

        $view = View::factory("pages/admin/event/create");

        $venues = $this->_get_venues();
        $view->bind('venues', $venues);

        if($group_id !== NULL)
        {
            $view->bind('group_id', $this->_group_id);
        }

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');
            $data     = array();

            // @TODO: insert validation here...

            $response = $client->post('event', $_POST);

            $data = XML::factory(NULL, NULL, $response->data);

            if($response->status == '201')
            {
                Request::instance()->redirect(Request::instance()->uri(array('action' => 'edit', 'id' => $data->event->attributes('id'))));
            }
            else
            {
                //$out = 'Error creating Event<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
                $message = $data->status->value();
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }

    /**
     * Renders Edit Event Admin page
     */
    public function action_edit($id=NULL)
    {
        $this->page_title = "Edit Event";

        $view = View::factory("pages/admin/event/edit");

        $client = ServiceClient::factory('event');
        $client->get(Request::instance()->param('id', NULL));

        if($client->status['type'] !== 'error')
        {
            $view->bind('event', $client->data);    
        }

        $venues = $this->_get_venues();
        $view->bind('venues', $venues);

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');

            // @TODO: insert validation here...

            $response = $client->put('event/update/'.$_POST['id'], $_POST);
            $data = XML::factory(NULL, NULL, $response->data);
            $message = $data->status->value();

            if($response->status == '200')
            {
                $event = array(
                        'id'          => $data->events->event->attributes('id'),
                        'name'        => $data->events->event->name->value(),
                        'datetime'    => $data->events->event->datetime->value(),
                        'description' => $data->events->event->description->value(),
                        'venue_id'    => $data->events->event->venue->attributes('id'),
                    );
            }

            $this->_content = $view->bind('message', $message);

        }
    }

    //public function action_create_photo()
    //{
    //    if( ! isset($_POST['submit']))
    //    {
    //        $view = View::factory('upload');
    //        $this->request->response = $view;
    //    }
    //    else 
    //    {
    //        $client   = REST_client::instance('file_upload');

    //        Upload::save($_FILES['photo'], $_FILES['photo']['name']);
    //        $photo_path = '@upload/'.$_FILES['photo']['name'].';type='.$_FILES['photo']['type'];
    //        $data = array('photo' => $photo_path);

    //        // $response = $client->post('photo', $data);
    //        $response = $client->post('photo', $data);

    //        if($response->status == '200')
    //        {
    //            $out = 'Successfully created photo<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
    //        }
    //        else
    //        {
    //            $out = 'Error creating photo<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
    //        }

    //        $this->request->response = $out;
    //    }
    //}

}
