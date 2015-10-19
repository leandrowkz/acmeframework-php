<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller App_config
 *
 * Application settings module viewer. Lists all kind of app settings.
 *
 * @since 	28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
class App_config extends ACME_Controller {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Show settings.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->validate_permission('ENTER');

		// Load view
		$this->template->load_view( $this->controller . '/index');
	}
}
