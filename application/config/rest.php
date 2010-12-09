<?php defined('SYSPATH') or die('No direct script access.');

return array(
    // default client for GET methods
	'default' => array(
		/**
		 * uri: the location and protocol of the rest server
		 * content_type: What to send up as a default Content-Type header
		 */
        'uri' => 'http://api.kohanaferrinho.com/v1.0',
		'content_type' => 'application/xml'
	),

    // plain text form writer
	'api_writer' => array(
		'uri' => 'http://api.kohanaferrinho.com/v1.0',
		'content_type' => 'application/x-www-form-urlencoded'
	),

    // binary file writer
    'file_upload' => array(
		'uri' => 'http://api.kohanaferrinho.com/v1.0',
		'content_type' => 'multipart/form-data'
    ),

    // sample last.fm client config
    'lastfm' => array(
        'uri' => 'http://ws.audioscrobbler.com/2.0/',
        'content_type' => 'application/xml'
    )

);
