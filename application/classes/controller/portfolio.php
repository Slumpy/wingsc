<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Portfolio extends Controller_Template_Wings {

	public function action_index($slug = NULL)
	{
		$this->template->content = View::factory('projects/portfolio')
			->bind('list', $projects)
			->bind('details', $details)
			->bind('active', $slug);

		$projects = Sprig::factory('project')->select_list('slug', 'title');

		if ($slug === NULL)
		{
			// Get the first project in the list
			$slug = key($projects);
		}

		// Get the project details via a sub-request
		$details = View::factory('projects/details')
			->bind('project', $project);

		$project = Sprig::factory('project', array('slug' => $slug))->load();
	}

} // End Portfolio