<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template_Wings {

	// Currently logged in user
	protected $_current_user;

	public function before()
	{
		parent::before();

		// Set the current user
		$this->_current_user = cookie::get('authorized', FALSE);

		if ($this->request->action !== 'login' AND ! $this->_current_user)
		{
			// Redirect to the login page
			$this->request->redirect(url::site(Route::get('admin')->uri(array('action' => 'login'))));
		}
	}

	public function action_login()
	{
		// Set the login page
		$this->template->content = View::factory('admin/login')
			->bind('post', $post)
			->bind('errors', $errors);

		// Validate POST for login details
		$post = Validate::factory($_POST)
			// Filters
			->filter(TRUE, 'trim')
			// Username rules
			->rule('username', 'not_empty')
			->rule('username', 'regex', array('/^[\pL]{4,24}$/iu'))
			->callback('username', array($this, 'do_login'))
			// Password rules
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array('5'));

		if ($post->check($errors))
		{
			// Redirect to the home page when validation succeeds
			$this->request->redirect(url::site(Route::get('admin')->uri()));
		}
	}

	public function action_index()
	{
		$this->template->content = View::factory('admin/projects/create')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('associates', $assoc);

		$assoc = DB::query(Database::SELECT, 'SELECT id, name FROM associates ORDER BY name')
			->execute()
			->as_array('id', 'name');

		// Add an option for "no associate"
		arr::unshift($assoc, 0, '- none -');

		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')

			->rule('title', 'not_empty')
			->rule('title', 'regex', array('/^[\pL\pP\s]{4,255}$/iu'))

			->rule('associate_id', 'not_empty')

			->rule('completed', 'not_empty')
			->rule('completed', 'date')

			->rule('website', 'regex', array('#^https?://.+$#'));

		if ($post->check($errors))
		{
			if (empty($post['associate_id']))
			{
				// Make the associate NULL
				$post['associate_id'] = NULL;

				// Use only the title for the slug
				$post['slug'] = url::title($post['title']);
			}
			else
			{
				// Use the title with associate for the slug
				$post['slug'] = url::title($post['title']).'/with/'.url::title($assoc[$post['associate_id']]);
			}

			if (empty($post['website']))
			{
				// Make the website value NULL
				$post['website'] = NULL;
			}

			// Get the values of the array
			$values = $post->as_array();

			// Convert the completed date into a timestamp
			$values['completed'] = strtotime($values['completed']);

			$query = DB::query(Database::INSERT, 'INSERT INTO projects (title, associate_id, completed, website, slug) VALUES (:values)')
				->bind(':values', $values)
				->execute();

			// Set a cookie message
			cookie::set('message', 'Created new project with an ID of '.$query);

			// Redirect back to the same page
			$this->request->redirect(url::site($this->request->uri));
		}
	}

	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->template->content = View::factory('template/admin')
				->set('content', $this->template->content)
				->bind('menu', $menu);

			foreach (array('projects', 'users') as $type)
			{
				// Create the menu items
				$menu[$this->request->uri(array('controller' => $type))] = ucfirst($type);
			}
		}

		parent::after();

		// Delete any existing message cookie
		cookie::delete('message');
	}

	public function do_login(Validate $array, $field, array $errors)
	{
		if ( ! isset($errors['username']) AND ! isset($errors['password']))
		{
			$query = DB::query(Database::SELECT, 'SELECT password FROM users WHERE username = :username')
				->bind(':username', $array['username'])
				->execute();

			if (sha1($array['password']) === $query->get('password'))
			{
				// User is authorized
				cookie::set('authorized', $array['username']);
			}
			else
			{
				// Invalid login
				$errors['username'] = 'Invalid username or password';
			}
		}

		return $errors;
	}

} // End Admin