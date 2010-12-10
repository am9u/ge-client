<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Venue extends Controller_Admin_Page
{
    public $page_title = "Venues"; // default page title

    /**
     * Renders Venues Admin index
     */
    public function action_index()
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

        $view = View::factory("pages/admin/venue/index");
        $this->_content = $view->bind('venues', $venues);
    }

    /**
     * Renders Create Venue Admin page
     */
    public function action_create() 
    {
        $this->page_title = "Create Venue";

        $view = View::factory("pages/admin/venue/create");

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');
            $data     = array();

            // @TODO: insert validation here...

            $response = $client->post('venue', $_POST);

            $data = XML::factory(NULL, NULL, $response->data);

            if($response->status == '200')
            {
                Request::instance()->redirect(Request::instance()->uri(array('action' => 'edit', 'id' => $data->venue->attributes('id'))));
            }
            else
            {
                $message = $data->status->value();
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }

    /**
     * Renders Edit Venue Admin page
     */
    public function action_edit($id=NULL)
    {
        $this->page_title = "Edit Venue";

        $view = View::factory("pages/admin/venue/edit");

        // get data from REST endpoint
        $client   = REST_client::instance(); 
        $response = $client->get('venue/'.$id);

        $data = XML::factory(NULL, NULL, $response->data);

        $venue = array(
            'id'             => $data->venues->venue->attributes('id'),
            'name'           => $data->venues->venue->name->value(),
            'line_1'         => $data->venues->venue->line_1->value(),
            'line_2'         => $data->venues->venue->line_2->value(),
            'city'           => $data->venues->venue->city->value(),
            'state_province' => $data->venues->venue->state_province->value(),
            'zip'            => $data->venues->venue->zip->value()
        );

        $view->bind('venue', $venue);

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');

            // @TODO: insert validation here...

            $response = $client->put('venue/update/'.$_POST['id'], $_POST);
            $data = XML::factory(NULL, NULL, $response->data);
            $message = $data->status->value();

            if($response->status == '200')
            {
                $venue = array(
                    'id'             => $data->venues->venue->attributes('id'),
                    'name'           => $data->venues->venue->name->value(),
                    'line_1'         => $data->venues->venue->line_1->value(),
                    'line_2'         => $data->venues->venue->line_2->value(),
                    'city'           => $data->venues->venue->city->value(),
                    'state_province' => $data->venues->venue->state_province->value(),
                    'zip'            => $data->venues->venue->zip->value()
                );
            }

            $this->_content = $view->bind('message', $message);

        }
    }
}
