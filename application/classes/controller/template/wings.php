<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template_Wings extends Controller_Template {

	protected $_ajax = FALSE;

	public function before()
	{
		// Open remote URLs in a new window
		html::$windowed_urls = TRUE;

		parent::before();

		$this->template->title =
		$this->template->content = '';

		if (Request::$is_ajax OR $this->request !== Request::instance())
		{
			// This is an AJAX-like request
			$this->_ajax = TRUE;
		}
	}

	public function after()
	{
		if ($this->_ajax === TRUE)
		{
			// Use the template content as the response
			$this->request->response = $this->template->content;
		}
		else
		{
			parent::after();
		}
	}

} // End Controller_Template_Wings