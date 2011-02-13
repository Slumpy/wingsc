<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Layout extends Controller {

	public function after()
	{
		if ($this->request->response instanceof View_Layout)
		{
			if (Request::$is_ajax)
			{
				// Display only the page content for AJAX requests
				$this->request->response->layout = FALSE;
			}

			$this->request->response = $this->request->response->render();
		}

		return parent::after();
	}

} // End Layout
