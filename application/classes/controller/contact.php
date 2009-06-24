<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Template_Wings {

	public function action_index()
	{
		$this->template->content = View::factory('contact/email')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('work_types', $work)
			->bind('budget_types', $budget);

		$work = array(
			'development' => 'Web Development',
			'database'    => 'Database Design',
			'review'      => 'Code Review',
			'kohana'      => 'KohanaPHP Consulting',
			'other'       => 'Other',
		);

		$budget = array(
			'under_500'  => 'Under $500',
			'under_1000' => '$500 - $1000',
			'under_5000' => '$1000 - $5000',
			'over_5000'  => '$5000 or more'
		);

		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')

			->rule('name', 'not_empty')

			->rule('email', 'not_empty')
			->rule('email', 'email')

			->rule('work', 'not_empty')
			->rule('work', 'in_array', array($work))

			->rule('description', 'not_empty')

			->rule('budget', 'not_empty')
			->rule('budget', 'in_array', array($budget));

		if ($post->check($errors))
		{
			// Send email here
		}
	}

} // End Contact