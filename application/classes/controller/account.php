<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Page
{
    public function action_index()
    {
        $token = Cookie::get('auth_token');

        if($token === NULL )
        {
            $this->_content = '<p>no token, so not logged in.</p>';
            $this->_content .= '<p>fake cookie: '.Cookie::salt('auth_token', '12345').'~12345</p>';
        }
        else
        {
           $this->_content = $token;

            //$client   = ServiceClient::factory('user');
            
            $client = REST_client::instance('api_writer');
            $response = $client->post('user/identify', array('token' => $token));
            $data     = XML::factory(NULL, NULL, $response->data);

            if($response->status == '200')
            {
                $this->_content .= '<p>logged in</p>';
            }
            else
            {
                Cookie::delete('auth_token');
                $this->_content .= '<p>invalid token, so not logged in.</p>';
            }
        }
    }


    public function action_login()
    {
        Kohana::$log->add('Controller_Account->login()', 'CALLED!');
        $this->page_title = 'Login';
        $view = View::factory('pages/account/login');

        if ( ! $_POST)
        {
            $this->_content = $view;
        }
        else
        {
            // @TODO: validation here!

            Kohana::$log->add('Controller_Account->login()', 'calling ServiceClient::factory(user)');
            $client = ServiceClient::factory('user');

            $client->identify($_POST);

            if($client->status['type'] === 'success')
            {
                // set cookie
                //$token = $data->user->attributes('token');
                $token = $client->data['token'];
                Cookie::set('auth_token', $token);

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

    public function action_logout()
    {
        $this->page_title = 'Logout';
        $view = View::factory('pages/account/logout');

        Cookie::delete('auth_token');

        $this->_content = $view;
    }

}
