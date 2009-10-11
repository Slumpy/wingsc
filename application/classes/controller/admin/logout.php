<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Logout extends Controller {

	public function __construct(Request $request)
	{
		// Delete the authorization
		cookie::delete('authorized');

		// Redirect to the login page
		$request->redirect(url::site($request->uri(array('controller' => NULL))));

		// Do not call anything here, redirect has already halted execution.
	}

} // End Admin_Logout