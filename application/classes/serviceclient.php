<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @requires XML module
 * @requires REST_Client module
 */
abstract class ServiceClient
{
    protected $_client_type = 'default'; // client type
    protected $_client; // instance of REST_Client

    protected $response; // response from REST_Client request

    protected $_filter = NULL; // filter parameter to prepend to service endpoint

	/**
	 * Constants for supported HTTP methods
	 */
	const HTTP_GET    = 'GET';
	const HTTP_PUT    = 'PUT';
	const HTTP_POST   = 'POST';
	const HTTP_DELETE = 'DELETE';

	/**
	 * Creates and returns a new ServiceClient.
	 *
	 * @chainable
	 * @param   string  client name
	 * @return  ServiceClient
	 */
	public static function factory($client, $config = NULL)
	{
		// Set class name
		$client = 'ServiceClient_'.ucfirst($client);

		return new $client($config);
	}

    public function __construct($config = NULL) 
    {
        $this->_client = REST_Client::instance($this->_client_type);

        Kohana::$log->add('debug', get_class($this).'__construct() -- $config='.$config);

        if(isset($config['group']))
        {
            Kohana::$log->add('debug', get_class($this).'__construct() -- $config[group]='.$config['group']);
            $this->_filter = array('group' => str_replace(' ', '-', $config['group']));
        }
    }

    protected function _request($method=self::HTTP_GET, $url, $data=NULL)
    {
        Kohana::$log->add('debug', 'ServiceClient::_request() -- $url='.$url);

        if($method == self::HTTP_GET)
        {
            $this->response = $this->_client->get($url);
        }
        elseif ($method == self::HTTP_POST)
        {
            $this->response = $this->_client->post($url, $data);
        }
        elseif ($method == self::HTTP_PUT)
        {
            $this->response = $this->_client->put($url, $data);
        }
        elseif ($method == self::HTTP_DELETE)
        {
            $this->response = $this->_client->delete($url, $data);
        }
        
        $data = XML::factory(NULL, NULL, $this->response->data);

        $this->status = array(
            'type'    => $data->status->attributes('type'),
            'code'    => $data->status->attributes('code'),
            'message' => $data->status->value(),
        ); 

        return $data;
    }
}
