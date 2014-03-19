<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Config
* 
* Módulo de configurações da aplicação. Lista constantes e variáveis de sessão.
*
* @since 	28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
class App_Config extends ACME_Module_Controller {
	
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
	* Entrada do módulo. Exibe listagem de variáveis de sessão em um box de visualização.
	* @return void
	*/
	public function index()
	{
		// Valida permissão de entrada do módulo
		$this->validate_permission('ENTER');
		
		// Carrega view
		$this->template->load_page('_acme/app_config/index');
	}
}
