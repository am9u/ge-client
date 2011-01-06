<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page
{
    public function action_index()
    {
        $this->_content = '<p>Welcome to the Gastronauts Development site.</p>'; 
    }
}

