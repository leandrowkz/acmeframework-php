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
		parent::index();
	}

	/**
	* ajax_remove_log_error()
	* Remove registro de log de erro via ajax.
	* @param string id_log_error
	* @return void
	*/
	public function ajax_remove_log_error($id_log_error = 0)
	{
		if($this->check_permission('DELETE')) {
			$this->db->delete('acm_log_error', array('id_log_error' => $id_log_error));
			$return = array('return' => true);
		} else {
			$return = array('return' => false);
		}

		// Adorable return!
		echo json_encode($return);
	}
}
