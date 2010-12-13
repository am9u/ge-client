<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Page extends Controller_AuthPage 
{
	public $template_name = 'admin';
    public $auth_required = array('login', 'admin'); // user must be logged in and admin!
} 


