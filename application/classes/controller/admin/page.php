<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Page extends Controller_AuthPage 
{
	public $template_name = 'admin';
    public $auth_required = array('login', 'admin'); // user must be logged in and admin!

    public function before()
    {
        parent::before();
        array_push($this->scripts, 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js');
        array_push($this->scripts, 'template/shared/jquery.ui.spinner/ui.spinner.min.js');

        $this->styles['http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/cupertino/jquery-ui.css'] = 'screen';
        $this->styles['template/shared/jquery.ui.spinner/ui.spinner.css'] = 'screen';
    }
} 


