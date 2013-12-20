<?php
/**
 * AgilePHP Generated Index Page
 * ddns
 *
 * @package ddns
 */

 ini_set('display_errors', '1');
 error_reporting(E_ALL);

/**
 * This is the default index page that handles all requests for the web application.
 * Here, we load the core AgilePHP framework and call upon the Model-View-Control
 * component to parse and handle the current request. All calls are wrapped in a
 * try/catch which redirects the website visitor to the view/error.phtml page on error.
 *
 * @author AgilePHP Generator
 * @version 0.1
 */
 require_once 'AgilePHP/AgilePHP.php';

 try {
        AgilePHP::init();
        AgilePHP::setDebugMode(true);
		AgilePHP::setDefaultTimezone('America/New_York');
		AgilePHP::setFrameworkRoot(realpath(dirname(__FILE__) . '/AgilePHP'));
		MVC::dispatch();
 }
 catch( Exception $e ) {

  	     Log::error($e->getMessage());

		 $renderer = new PHTMLRenderer();
		 $renderer->set('title', 'ddns :: Error Page');
		 $renderer->set('error', $e->getMessage() . (AgilePHP::isInDebugMode() ? '<pre>' . $e->getTraceAsString() . '</pre>' : ''));
		 $renderer->render('error');
 }
?>