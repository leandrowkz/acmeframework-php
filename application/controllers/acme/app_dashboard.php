<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* App_Dashboard
* 
* Dashboard padrão da aplicação. Por padrão, tela de entrada dos usuários
* do grupo ROOT.
*
* @since	15/10/2012
*
*/
class App_Dashboard extends ACME_Module_Controller {

	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	* index()
	* Tela de dashboard.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('VIEW_DASHBOARD');
		
		$this->load->library('user_agent');
		
		// Carrega VIEW
		$this->template->load_page('_acme/app_dashboard/index');
	}
}
