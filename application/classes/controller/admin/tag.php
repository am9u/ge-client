<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tag extends Controller_Admin_Page
{
    public $page_title = "Tags"; // default page title
    
    /**
     * Renders Events Admin index
     */
    public function action_index()
    {
        $view = View::factory("pages/admin/tag/index");
        $this->_content = $view;
    }

    /**
     * Renders Create Event Admin page
     */
    public function action_create()
    {
        $this->page_title = "Create ".$this->page_title;
        $view = View::factory("pages/admin/tag/create");
        $this->_content = $view;

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');
            $data     = array();

            // @TODO: insert validation here...
            $response = $client->post('tag', $_POST); echo $response->data;

            $data = XML::factory(NULL, NULL, $response->data);

            if($response->status == '200')
            {
                Request::instance()->redirect(Request::instance()->uri(array('action' => 'index')));
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
}
