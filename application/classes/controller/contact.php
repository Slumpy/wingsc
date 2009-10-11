<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Template_Wings {

	public function action_index()
	{
		$this->template->content = View::factory('contact/email')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('work_types', $work)
			->bind('budget_types', $budget);

		// Project type
		$work = array(
			'development' => 'Web Development',
			'database'    => 'Database Design',
			'review'      => 'Code Review',
			'kohana'      => 'KohanaPHP Consulting',
			'other'       => 'Other',
		);

		// Project budget
		$budget = array(
			'under_500'  => 'Under $500',
			'under_1000' => '$500 - $1000',
			'under_5000' => '$1000 - $5000',
			'over_5000'  => '$5000 or more'
		);

		$post = Validate::factory($_POST)
			// Trim all fields
			->filter(TRUE, 'trim')
			// Rules for name
			->rule('name', 'not_empty')
			// Rules for email address
			->rule('email', 'not_empty')
			->rule('email', 'email')
			// Rules for type of work
			->rule('work', 'not_empty')
			->rule('work', 'in_array', array(array_keys($work)))
			// Rules for project description
			->rule('description', 'not_empty')
			// Rules for project budget
			->rule('budget', 'not_empty')
			->rule('budget', 'in_array', array(array_keys($budget)));

		if ($post->check())
		{
			// Create the email body
			$body = View::factory('template/lead')
				->set('name', $post['name'])
				->set('work', $work[$post['work']])
				->set('budget', $budget[$post['budget']])
				->set('description', $post['description'])
				->render();

			// Get the email configuration
			$config = Kohana::config('email');

			// Load Swift Mailer support
			require Kohana::find_file('vendor', 'swift/lib/swift_required');

			// Create an email message
			$message = Swift_Message::newInstance()
				->setSubject('w.ings consulting: New Lead from '.$post['name'])
				->setFrom(array($post['email'] => $post['name']))
				->setTo(array('woody@wingsc.com' => 'Woody Gilk'))
				->setBody(strip_tags($body))
				->addPart($body, 'text/html');

			// Connect to the server
			$transport = Swift_SmtpTransport::newInstance($config->server, 25)
				->setUsername($config->username)
				->setPassword($config->password);

			// Send the message
			Swift_Mailer::newInstance($transport)
				->send($message);

			// Redirect to the thanks page
			$this->request->redirect(url::site($this->request->uri(array('action' => 'hire'))));
		}
		else
		{
			$errors = $post->errors('forms/contact');
		}
	}

	public function action_hire()
	{
		$this->template->content = View::factory('contact/thanks');
	}

	public function after()
	{
		// Wrap the content in the contact sub-template
		$this->template->content = View::factory('contact/index')
			->set('content', $this->template->content);

		parent::after();
	}

} // End Contact