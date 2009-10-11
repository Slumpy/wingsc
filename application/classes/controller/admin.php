<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin extends Controller_Template_Wings {

	// Currently logged in user
	protected $_current_user;

	public function before()
	{
		parent::before();

		if (($this->_current_user = cookie::get('authorized')) === NULL)
		{
			if ($this->request->controller !== 'login')
			{
				// Skip the current action
				$this->request->action = 'skip';

				// Load the login page via a sub-query
				$this->template->content = Request::factory($this->request->uri(array('controller' => 'login')))->execute();
			}
		}
	}

	final public function action_skip()
	{
		// Do nothing
	}

	public function after()
	{
		if ($this->auto_render === TRUE AND ! $this->_ajax)
		{
			$this->template->content = View::factory('template/admin')
				->set('content', $this->template->content)
				->bind('menu', $menu);

			if ($this->_current_user)
			{
				// Display these menu items as controller
				$menu = array('projects', 'users', 'logout');
			}
		}

		parent::after();

		// Delete any existing message cookie
		cookie::delete('message');
	}

} // End Admin