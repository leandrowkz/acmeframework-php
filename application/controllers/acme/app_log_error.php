<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Log_Error
* 
* Módulo de listagem de log de erros do sistema.
*
* @since		05/04/2013
* @location		acme.controllers.acme_log_error
*
*/
class Acme_Log_Error extends Acme_Base_Module {
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
	* index()
	* Método 'padrão' do controlador. É invocado automaticamente quando 
	* o action deste controlador não é informado na URL. Por padrão seu efeito
	* é exibir a tela de listagem de entrada do módulo.
	* @param int actual_page
	* @return void
	*/
	public function index($actual_page = 0)
	{
		parent::index($actual_page);
	}
	
	/**
	* ajax_remove_log_error()
	* Remove um registro de log de erro de id encaminhado.
	* @param int id_log_error
	* @return void
	*/
	public function ajax_remove_log_error($id_log_error = 0)
	{
		if($this->validate_permission('DELETE', false))
		{
			$this->db->where(array('id_log_error' => $id_log_error));
			$this->db->delete('acm_log_error');
		} else {
			// Quando encaminhado um erro no cabeçalho http, o ajax dispara o callback 
			// error exibindo a mensagem de que o usuário atual não possui esta permissão
			header("HTTP/1.0 500 Internal Server Error");
		}
	}
	
	/**
	* ajax_remove_all_log_errors()
	* Remove todos os registros de logs de erros com base em sua categoria encaminhada.
	* @param string error_type
	* @return void
	*/
	public function ajax_remove_all_log_errors($error_type = '')
	{
		if($this->validate_permission('DELETE', false))
		{
			$this->db->where(array('error_type' => $error_type));
			$this->db->delete('acm_log_error');
		} else {
			// Quando encaminhado um erro no cabeçalho http, o ajax dispara o callback 
			// error exibindo a mensagem de que o usuário atual não possui esta permissão
			header("HTTP/1.0 500 Internal Server Error");
		}
	}
}
