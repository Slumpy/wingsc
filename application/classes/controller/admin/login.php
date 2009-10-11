<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Login extends Controller_Admin {

	public function action_index()
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
			// Reload the page
			$this->request->redirect(url::site(Request::instance()->uri));
		}
	}

	public function do_login(Validate $array, $field, array $errors)
	{
		if (empty($errors) AND isset($array['username']) AND isset($array['password']))
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