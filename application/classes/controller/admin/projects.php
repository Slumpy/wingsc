<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Projects extends Controller_Admin {

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
			->rule('associate_id', 'in_array', array(array_keys($assoc)))

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

} // End Admin_Projects