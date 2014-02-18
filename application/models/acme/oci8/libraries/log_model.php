<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Log_Model
*
* Abstração da camada modelo (banco de dados) para logs do sistema.
* 
* @since		30/10/2012
* @location		acme.models.log_model
*
*/
class Log_Model extends CI_Model {
	// Definição de Atributos
	
	/**
	* __construct()
	* Construtor de classe. Chama o construtor pai, que abre uma conexão com
	* o banco de dados, automaticamente.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	* insert_log()
	* Insere um registro de log na tabela acm_log.
	* @param integer id_user
	* @param string text_log
	* @param string action
	* @param string table
	* @param string ip_address
	* @param string user_agent
	* @return void
	*/
	public function insert_log($id_user = 0, $text_log = '', $action = '', $table = '', $array_data = array(), $ip_address = '', $user_agent = '', $browser_name = '', $browser_version = '', $login = '')
	{
		// Cria array inserção
		$arr = array();
		$arr['id_user'] = $id_user;
		$arr['log_description'] = $text_log;
		$arr['action'] = $action;
		$arr['table_name'] = $table;
		$arr['array_data'] = var_export($array_data, true);
		$arr['ip_address'] = $ip_address;
		$arr['user_agent'] = $user_agent;
		$arr['browser_name'] = $browser_name;
		$arr['browser_version'] = $browser_version;
		
		// Insere registro
		return $this->db->insert('acm_log', $arr);
	}
	
	/**
	* insert_log_error()
	* Insere um registro de log de erro na tabela acm_log_error.
	* @param string template
	* @param string header
	* @param string message
	* @param string status_code
	* @return void
	*/
	public function insert_log_error($template = '', $header = '', $message = '', $status_code = '')
	{
		// Cria array inserção
		$arr = array();
		$arr['error_type'] = $template;
		$arr['header'] = $header;
		$arr['message'] = $message;
		$arr['status_code'] = $status_code;
		
		// Insere registro
		$this->db->insert('acm_log_error', $arr);
	}
}
