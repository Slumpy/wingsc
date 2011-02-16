<?php defined('SYSPATH') or die('No direct script access.');

class View_Layout extends Walrus_Layout {

	public function base()
	{
		return Route::url('default', array(
			'controller' => FALSE,
			'action'     => FALSE,
		));
	}

	public function woody_at_wingsc()
	{
		return HTML::mailto('woody@wingsc.com');
	}

	public function hello_at_wingsc()
	{
		return HTML::email('hello@wingsc.com');
	}

	public function render($template = NULL, $view = NULL, $partials = NULL)
	{
		// Add call widget to all pages
		$this->_partials['call_me'] = 'layout/call';

		return parent::render($template, $view, $partials);
	}

} // End Layout
