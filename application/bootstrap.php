<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/features/localization#time
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/features/autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Set the production status by the domain.
 */
define('IN_PRODUCTION', $_SERVER['SERVER_ADDR'] !== '127.0.0.1');


//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'profiling'  => ! IN_PRODUCTION,
	'caching'    => IN_PRODUCTION
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'database'   => MODPATH.'database',   // Database access
	'sprig'      => MODPATH.'sprig',      // Sprig modeling
	'gcheckout'  => MODPATH.'gcheckout',  // Google Checkout payments
	'paypal'     => MODPATH.'paypal',     // PayPal payments
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

if ( ! Route::cache())
{
	Route::set('work', 'did(/<project>(/<action>))', array(
			'project' => '.+?(?:/with/.+?)?',
		))
		->defaults(array(
			'controller' => 'portfolio',
		));

	Route::set('calendar', 'will(/<action>)')
		->defaults(array(
			'controller' => 'calendar',
		));

	Route::set('contact', 'for(/<action>)')
		->defaults(array(
			'controller' => 'contact',
		));

	Route::set('pay', 'pay')
		->defaults(array(
			'controller' => 'payment',
		));

	Route::set('admin', 'admin(/<controller>)((/<id>)/<action>)')
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'login',
		));

	Route::set('default', '(<page>)', array('page' => '.+'))
		->defaults(array(
			'controller' => 'static',
			'action'     => 'load',
			'page'       => 'is',
		));

	// Cache the routes
	Route::cache(TRUE);
}

/**
 * Execute the main request using PATH_INFO. If no URI source is specified,
 * the URI will be automatically detected.
 */
$request = Request::instance($_SERVER['PATH_INFO']);

try
{
	// Attempt to execute the response
	$request->execute();
}
catch (Exception $e)
{
	if ( ! IN_PRODUCTION)
	{
		// Just re-throw the exception
		throw $e;
	}

	// Log the error
	Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

	// Create a 404 response
	$request->status   = 404;
	$request->response = View::factory('template')
		->set('title', '404')
		->set('content', View::factory('errors/404'));
}

if ($request->response)
{
	// Get the total memory and execution time
	$total = array(
		'{memory_usage}'   => number_format((memory_get_peak_usage() - KOHANA_START_MEMORY) / 1024, 2).'KB',
		'{execution_time}' => number_format(microtime(TRUE) - KOHANA_START_TIME, 5).' seconds');

	// Insert the totals into the response
	$request->response = strtr((string) $request->response, $total);
}


/**
 * Display the request response.
 */
echo $request->send_headers()->response;
