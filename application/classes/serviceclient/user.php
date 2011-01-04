<?php defined('SYSPATH') or die('No direct script access.');

class ServiceClient_User extends ServiceClient
{
    protected $_client_type = 'api_writer';

    const TOKEN_NAME   = 'token';
    const USERNAME_KEY = 'username';
    const PASSWORD_KEY = 'password';

    public function identify($credentials=NULL)
    {
        Kohana::$log->add('ServiceClient_User->identify()', 'called!');

        $resource_uri = 'user/identify';

        // identify by auth token
        if( ! empty($credentials[self::TOKEN_NAME]))
        {
            Kohana::$log->add('debug', 'ServiceClient_User::identify() -- identify by auth token');
             
            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::TOKEN_NAME
                )));
        }

        // identify by username/password combination
        elseif( ! empty($credentials[self::USERNAME_KEY]) AND ! empty($credentials[self::PASSWORD_KEY]))
        {
            Kohana::$log->add('debug', 'ServiceClient_User::identify() -- identify by username/password combo');

            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::USERNAME_KEY, 
                    self::PASSWORD_KEY,
                )));

            Kohana::$log->add('debug', 'ServiceClient_User::identify() -- response recieved: '.$data);
        }

        if($this->status['type'] !== 'error')
        {
            $this->data = new ServiceClient_Driver_User($data->user);
        }
    }

    public function create($user_data=NULL)
    {
        $resource_uri = 'user/create';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $user_data);
    }

    public function get($id = NULL)
    {
        if($id === NULL)
        {
            $resource_uri = 'user';
        }            
        else
        {
            $resource_uri = 'user/'.$id;
        }
        $data = $this->_request(self::HTTP_GET, $resource_uri);

        $users = $data->get('user');
        
        if(count($users) === 0)
        {
            $this->data = NULL;
        }
        elseif(count($users) === 1)
        {
            $this->data = new ServiceClient_Driver_User($users[0]);
        }
        else
        {
            $this->data = array();
            foreach($users as $user)
            {
                array_push($this->data, new ServiceClient_Driver_User($user));
            }
        }
    }

    public function add_to_group($post_data)
    {
        $resource_uri = 'user/add_to_group';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $post_data);

        if($this->status['type'] !== 'error')
        {
            $this->data = new ServiceClient_Driver_User($data->user);
        }
    }
    
    public function add_admin_to_group($post_data)
    {
        $resource_uri = 'user/add_admin_to_group';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $post_data);

        if($this->status['type'] !== 'error')
        {
            $this->data = new ServiceClient_Driver_User($data->user);
        }
    }

    public function add_role($post_data)
    {
        $resource_uri = 'user/role';
        $data = $this->_request(self::HTTP_POST, $resource_uri, $post_data);

        if($this->status['type'] !== 'error')
        {
            $this->data = new ServiceClient_Driver_User($data->user);
        }
    }
}
