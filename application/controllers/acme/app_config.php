<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Config
* 
* Controller de gerenciamento de variáveis e constantes do sistema.
*
* @since		28/06/2013
* @location		acme.controllers.acme_config
*
*/
class Acme_Config extends Acme_Base_Module {
	// Definição de atributos
	
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
	* @override
	* index()
	* Entrada do módulo. Exibe listagem de variáveis de sessão em um box de visualização.
	* @return void
	*/
	public function index()
	{
		// Valida permissão de entrada do módulo
		$this->validate_permission('ENTER');
		
		// Coleta variáveis de sessão
		$args['configs'] = get_object_vars($this->app_config);
		
		// Carrega view
		$this->template->load_page('_acme/acme_config/index', $args);
	}
}
