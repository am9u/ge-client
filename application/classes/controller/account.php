<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_AuthPage
{
    public $secure_actions = array(
            'index' => 'login',
        );

    public function action_index()
    {
        $this->page_title = 'My Account';
        $this->_content = 'Logged In!';
    }

    public function action_login()
    {
        $this->page_title = 'Login';
        $view = View::factory('pages/account/login');

        if ( ! $_POST)
        {
            $this->_content = $view;
        }
        else
        {
            // @TODO: validation here!

            $client = ServiceClient::factory('user');

            $client->identify($_POST);

            if($client->status['type'] === 'success')
            {
                // set cookie
                Cookie::set('auth_token', $client->data->token);

                // redirect
                $redirect_url = (empty($_POST['redirect_url'])) ? Request::instance()->uri(array('action' => 'index')) : $_POST['redirect_url'];
                Request::instance()->redirect($redirect_url);
            }
            else
            {
                $message = $client->status['message']; // this might be cleaner: $client->response->status->message
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }

    public function action_register()
    {

        if(self::logged_in() === TRUE)
        {
            $redirect_url = (empty($_POST['redirect_url'])) ? Request::instance()->uri(array('action' => 'index')) : $_POST['redirect_url'];
            Request::instance()->redirect($redirect_url);
        }

        $this->page_title = 'Register';
        $view = View::factory('pages/account/register');

        if ( ! $_POST)
        {
            $this->_content = $view;
        }
        else
        {
            // @TODO: validation here!

            $client = ServiceClient::factory('user');

            // create user
            $client->create($_POST);

            if($client->status['type'] === 'success')
            {
                // log user in
                $client->identify($_POST);

                if($client->status['type'] === 'success')
                {
                    // set cookie
                    Cookie::set('auth_token', $client->data->token);

                    // redirect
                    $redirect_url = (empty($_POST['redirect_url'])) ? Request::instance()->uri(array('action' => 'index')) : $_POST['redirect_url'];
                    Request::instance()->redirect($redirect_url);
                }
            }
            else
            {
                $message = $client->status['message']; // this might be cleaner: $client->response->status->message
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }

    public function action_logout()
    {
        $this->page_title = 'Logout';
        $view = View::factory('pages/account/logout');

        Cookie::delete('auth_token');

        $this->_content = $view;
    }

}
