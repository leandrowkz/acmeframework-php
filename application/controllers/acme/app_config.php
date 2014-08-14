<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Config
* 
* Application settings module viewer. Lists all kind of app settings.
*
* @since 	28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
class App_Config extends ACME_Module_Controller {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	* index()
	* Show settings.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		// Load view
		$this->template->load_page('_acme/app_config/index');
	}
}
