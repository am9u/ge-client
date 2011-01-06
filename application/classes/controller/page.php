<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Website 
{
    protected $_content = '<!-- MAIN VIEW CONTENT -->';

    public function before()
    {
        parent::before();
        array_push($this->scripts, 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js');
        $this->styles['http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/cupertino/jquery-ui.css'] = 'screen';
    }

	public function action_index()
	{
		//$this->request->response = 'hello, world!';
		$this->template->content= '<!--Default website controller, you don\'t want to access this one-->';
	}

    public function action_load()
    {
        $page = $this->request->param('page', 'home');
     
        if (isset($this->page_titles[$page]))
        {
            // Use the defined page title
            $title = $this->page_titles[$page];
        }
        else
        {
            // Use the page name as the title
            $title = ucwords(str_replace('_', ' ', $page));
        }
     
        $this->template->title   = $title;
        $this->template->content = View::factory("pages/$page")
            ->render();
    }

    public function after()
    {
        $this->template->content = $this->_content;
        parent::after();
    }

} 



