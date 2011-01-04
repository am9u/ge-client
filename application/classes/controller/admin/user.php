<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_Page
{
    public $page_title = "Users";

    public function action_index()
    {
        $user_service_client = ServiceClient::factory('user');    
        $user_service_client->get();

        $view = View::factory('pages/admin/user/index')
                    ->bind('users', $user_service_client->data);

        $this->_content = $view;
    }

    public function action_edit($id)
    {
        $user_service_client = ServiceClient::factory('user');    
        $user_service_client->get($id);

        $group_service_client = ServiceClient::factory('group');    
        $group_service_client->get();

        $view = View::factory('pages/admin/user/edit')
                    ->bind('user', $user_service_client->data)
                    ->bind('groups', $group_service_client->data);

        if( ! $_POST)
        {
            $this->_content = $view;
        }
        else
        {
            switch ($_POST['action'])
            {
                case 'add_to_group':
                    $user_service_client->add_to_group($_POST);
                    break;
                case 'make_group_admin':
                    $user_service_client->add_admin_to_group($_POST);
                    break;
            }

            $message = $user_service_client->status['message'];
            $view->bind('message', $message);
        }
    }
}
