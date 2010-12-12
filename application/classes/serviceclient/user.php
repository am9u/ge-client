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

        // idenfity by auth token
        if( ! empty($credentials[self::TOKEN_NAME]))
        {
            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::TOKEN_NAME
                )));
        }

        // identify by username/password combination
        elseif( ! empty($credentials[self::USERNAME_KEY]) AND ! empty($credentials[self::PASSWORD_KEY]))
        {
            $data = $this->_request(self::HTTP_POST, $resource_uri, Arr::extract($credentials, array(
                    self::USERNAME_KEY, 
                    self::PASSWORD_KEY,
                )));
        }

        $this->data = self::translate_response_data($data);
    }

    private static function translate_response_data($data=NULL)
    {
        $user = array(
            self::TOKEN_NAME   => $data->user->attributes(self::TOKEN_NAME),
            self::USERNAME_KEY => $data->user->username->value(),
        );

        return $user;
    }
}
