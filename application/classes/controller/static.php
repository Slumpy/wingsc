<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static extends Controller_Template_Wings {

	public function action_load($page)
	{
		// Load the requested static page
		$this->template->content = View::factory("pages/$page");
	}

} // End Controller_Static
