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
	* save_error()
	* Atualiza ou remove log de erro via ajax.
	* @param string id_error
	* @return void
	*/
	public function save_error($id_error = 0, $remove = false)
	{
		if( ! $this->check_permission('DELETE')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso')));
			return;
		}
		
		// update or remove
		if ($remove)
			$this->db->delete('acm_log_error', array('id_log_error' => $id_error));

		// Adorable return!
		echo json_encode(array('return' => true));
	}
}
