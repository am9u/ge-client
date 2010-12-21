<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Group extends Controller_Admin_Page
{
    public $page_title = "Groups"; // default page title
    
    /**
     * Renders Groups Admin index
     */
    public function action_index()
    {
        $client = ServiceClient::factory('group');
        $client->get_base_groups();

        $view = View::factory("pages/admin/group/index")
                    ->bind('groups', $client->data);

        $this->_content = $view;
    }

    /**
     * Renders Create Group Admin page
     */
    public function action_create()
    {
        $client = ServiceClient::factory('group');
        $client->get();

        $this->page_title = "Create ".$this->page_title;
        $view = View::factory("pages/admin/group/create")
                    ->bind('groups', $client->data);

        $this->_content = $view;

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else 
        {

            // @TODO: insert validation here...
            if(isset($_POST['parent_id']) AND $_POST['parent_id'] == '')
            {
                unset($_POST['parent_id']);
            }

            $client->create($_POST);

            if($client->status['type'] === 'success')
            {
                Request::instance()->redirect(Request::instance()->uri(array('action' => 'index')));
            }
            else
            {
                //$out = 'Error creating Group<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
                $message = $client->status['message'];
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }
}
