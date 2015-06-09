<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller Products_3
 *
 * 
 *
 *
 * AUTOMATICALLY GENERATED WITH MODULE MAKER (APP_MODULE_MAKER)
 *
 * @author 	leandrowkz@gmail.com
 * @since 	31/05/2015
 * --------------------------------------------------------------------------------------------------
 */
class Products_3 extends ACME_Controller {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default method. Shows a HTML table list with results contained in
	 * $this->sql_list.
	 *
	 * @return void
	 */
	public function index()
	{
		parent::index();
	}

	/**
	 * Example method of this controller. When an URL like Products_3/example
	 * is called then this method is triggered.
	 *
	 * @return void
	 */
	public function example()
	{
		// An example of how to validate a permission
		$this->validate_permission('EXAMPLE');

		// An example of how to load a view
		$this->template->load_view( $this->controller . '/view_page', $array_of_arguments );
	}
}
