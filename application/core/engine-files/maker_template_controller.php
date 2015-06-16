<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller <CLASS_NAME>
 *
 * <DESCRIPTION>
 *
 *
 * AUTOMATICALLY GENERATED WITH MODULE MAKER (APP_MODULE_MAKER)
 *
 * @author 	<AUTHOR>
 * @since 	<CREATION_DATE>
 * --------------------------------------------------------------------------------------------------
 */
class <CLASS_NAME> extends ACME_Controller {

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
	 * Example method of this controller. When an URL like <CLASS_NAME>/example
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
