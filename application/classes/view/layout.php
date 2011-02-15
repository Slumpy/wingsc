<?php defined('SYSPATH') or die('No direct script access.');

class View_Layout extends Walrus_Layout {

	public function base()
	{
		return Route::url('default', array(
			'controller' => FALSE,
			'action'     => FALSE,
		));
	}

} // End Layout
