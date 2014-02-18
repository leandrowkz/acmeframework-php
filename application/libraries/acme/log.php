<?php
/**
*
* Classe Log
*
* Esta biblioteca gerencia funções relacionadas ao registro de logs no sistema.
* 
* @since		01/10/2012
* @location		acme.libraries.log
*
*/
class Log {
	
	var $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* db_log()
	* Salva um registro de log no banco de dados (tabela acm_log). 
	* @param string text_log
	* @param string action
	* @param string table
	* @param array additional_data
	* @return void
	*/
	public function db_log($text_log = '', $action = '', $table = '', $additional_data = array())
	{
		$this->CI =& get_instance();
		$this->CI->load->library('user_agent');

		// dados do log
		$log['id_user'] = $this->CI->session->userdata('id_user');
		$log['table_name'] = $table;
		$log['action'] = $action;
		$log['log_description'] = $text_log;
		$log['additional_data'] = var_export($additional_data, true);
		$log['user_agent'] = $this->CI->agent->agent_string();
		$log['browser_name'] = $this->CI->agent->browser();
		$log['browser_version'] = $this->CI->agent->version();
		$log['device_name'] = $this->CI->agent->is_mobile()	? $this->CI->agent->mobile() : 'PC';
		$log['platform'] = $this->CI->agent->platform();
		$log['ip_address'] = $this->CI->input->ip_address();
		
		// Insere registro
		$this->CI->db->insert('acm_log', $log);
	}
	
	/**
	* log_error()
	* Salva um registro de log de erro no banco de dados (tabela acm_log_error). 
	* @param string error_type
	* @param string header
	* @param string message
	* @param string status_code
	* @return void
	*/
	public function log_error($error_type = '', $header = '', $message = '', $status_code = '')
	{
		$this->CI =& get_instance();
		
		// dados do log de erro
		$log['id_user'] = $this->CI->session->userdata('id_user');
		$log['error_type'] = $error_type;
		$log['header'] = $header;
		$log['message'] = $message;
		$log['status_code'] = $status_code;
		$log['additional_data'] = is_array($message) ? var_export($message, true) : array();
		$log['user_agent'] = $this->CI->agent->agent_string();
		$log['browser_name'] = $this->CI->agent->browser();
		$log['browser_version'] = $this->CI->agent->version();
		$log['device_name'] = $this->CI->agent->is_mobile()	? $this->CI->agent->mobile() : 'PC';
		$log['platform'] = $this->CI->agent->platform();
		$log['ip_address'] = $this->CI->input->ip_address();

		// Insere registro
		$this->CI->db->insert('acm_log_error', $log);
	}
}