<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Website extends Controller_Template 
{

	public $template		= '';
	public $page_title		= '';
	public $site_name		= '';
	public $template_name	= NULL;
	public $styles			= array();
	public $scripts			= array();

	public function before()
	{
		$this->auto_render = false;
		parent::before();
		$this->auto_render = true;

        if( ! isset($this->template_name))
        {
            $this->template_name = 'default';
        }

		$this->site_title = Kohana::config('website.site_name');

		$this->styles = array(
			'template/' . $this->template_name . '/css/reset.css' => 'screen',
			'template/' . $this->template_name . '/css/global.css' => 'screen',
		);
        
		$this->scripts = array(
			'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js',
		);

		$this->template = View::factory('template/' . $this->template_name . '/default');
		if ($this->auto_render)
		{
			$this->template->bind('page_title', $this->page_title)
				->bind('site_title', $this->site_title)
				->bind('styles', $this->styles)
				->bind('scripts', $this->scripts);
		}
	}

	public function action_index()
	{
		//$this->request->response = 'hello, world!';
		$this->template->content= '<!--Default website controller, you don\'t want to access this one-->';
	}

	public function after()
	{
		$this->template
            ->bind('styles', $this->styles)
			->bind('scripts', $this->scripts) ;
		parent::after();
	}

} 

