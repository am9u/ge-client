<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends Controller_Admin_Page
{
    protected $_content = '<!-- ADMIN DASHBOARD CONTENT -->';

    public function action_index()
    {
        $this->page_title = "Dashboard";
        $this->_content   = View::factory("pages/admin/dashboard/index");
    }	
    
}

