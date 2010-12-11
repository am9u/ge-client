<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Page
{
    public function action_index()
    {
        $token = Cookie::get('auth_token');
        if($token === NULL )
        {
            echo('<p>no token, so not logged in.</p>');
            echo('<p>fake cookie: '.Cookie::salt('auth_token', '12345').'~12345</p>');
        }
        else
        {
            echo($token);

            $client   = REST_client::instance('api_writer');
            $response = $client->post('user/identify', array('token' => $token));
            $data     = XML::factory(NULL, NULL, $response->data);

            if($response->status == '200')
            {
                echo('<p>logged in</p>');
            }
            else
            {
                Cookie::delete('auth_token');
                echo('<p>invalid token, so not logged in.</p>');
            }
        }
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

            $client   = REST_client::instance('api_writer');
            $response = $client->post('user/identify', $_POST);
            $data     = XML::factory(NULL, NULL, $response->data);

            if($response->status == '200')
            {
                // set cookie
                $token = $data->user->attributes('token');
                Cookie::set('auth_token', $token);

                // redirect
                $redirect_url = (empty($_POST['redirect_url'])) ? Request::instance()->uri(array('action' => 'index')) : $_POST['redirect_url'];
                Request::instance()->redirect($redirect_url);
            }
            else
            {
                $message = $data->status->value();
                $view->bind('message', $message);
                $this->_content = $view;
            }
        }
    }

}