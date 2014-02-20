<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Log
* 
* Módulo de logs do sistema. Gerencia logs e logs de erros.
*
* @since 	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Log extends ACME_Module_Controller {
	
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
	* Entrada do módulo.
	* @return void
	*/
	public function index()
	{
		parent::index($actual_page);
	}
}
