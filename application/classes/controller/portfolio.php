<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Portfolio extends Controller_Template_Wings {

	public function action_index($slug = NULL)
	{
		$this->template->content = View::factory('projects/portfolio')
			->bind('list', $projects)
			->bind('details', $details)
			->bind('active', $slug);

		$projects = DB::query(Database::SELECT, 'SELECT slug, title FROM projects ORDER BY completed DESC')
			->execute()
			->as_array('slug', 'title');

		if ($slug === NULL)
		{
			// Get the first project in the list
			$slug = key($projects);
		}

		// Get the project details via a sub-request
		$details = View::factory('projects/details')
			->bind('project', $project);

		$project = DB::query(Database::SELECT, 'SELECT projects.*, associates.name AS asc_name, associates.website AS asc_website FROM projects LEFT JOIN associates ON projects.associate_id = associates.id WHERE slug = :slug LIMIT 1')
			->bind(':slug', $slug)
			->execute()
			->current();
	}

} // End Portfolio