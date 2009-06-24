<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Portfolio extends Controller_Template_Wings {

	public function action_index($project = NULL)
	{
		$this->template->content = View::factory('projects/portfolio')
			->bind('list', $projects)
			->bind('details', $details)
			->bind('active', $project);

		$projects = DB::query(Database::SELECT, 'SELECT slug, title FROM projects ORDER BY completed DESC')
			->execute()
			->as_array('slug', 'title');

		if ($project === NULL)
		{
			// Get the first project in the list
			$project = key($projects);
		}

		// Get the project details via a sub-request
		$details = Request::factory(Route::get('work')->uri(array('project' => $project, 'action' => 'get')))->execute();
	}

	public function action_get($project)
	{
		// Used for AJAX calls only
		$this->auto_render = FALSE;

		$this->request->response = View::factory('projects/details')
			->bind('project', $project);

		$project = DB::query(Database::SELECT, 'SELECT projects.*, associates.name AS asc_name, associates.website AS asc_website FROM projects LEFT JOIN associates ON projects.associate_id = associates.id WHERE slug = :slug LIMIT 1')
			->bind(':slug', $project)
			->execute()
			->current();
	}

} // End Portfolio