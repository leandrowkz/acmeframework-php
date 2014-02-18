<?php
/**
* -------------------------------------------------------------------------------------------------
* Log Helper
*
* Centraliza funções relativas ao uso de logs na aplicação. Utiliza os métodos da biblioteca
* Log, do ACME Engine.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Log). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->log->example_function();
* 
* @since		15/07/2013
* @location		acme.helpers.log
*
* -------------------------------------------------------------------------------------------------
*/

/**
* db_log()
* Salva um registro de log no banco de dados (tabela acm_log). 
* @param integer id_user
* @param string text_log
* @param string action
* @param string table
* @param string ip_address
* @param string user_agent
* @return void
*/
function db_log($text_log = '', $action = '', $table = '', $array_data = array(), $ip_address = '', $user_agent = '', $browser_name = '', $browser_version = '')
{
	$CI =& get_instance();
	$CI->log->db_log($text_log, $action, $table, $array_data, $ip_address, $user_agent, $browser_name, $browser_version);
}

/**
* log_error()
* Salva um registro de log de erro no banco de dados (tabela acm_log_error). 
* @param string template
* @param string header
* @param string message
* @param string status_code
* @return void
*/
function log_error($template = '', $header = '', $message = '', $status_code = '')
{
	$CI =& get_instance();
	$CI->log->log_error($template, $header, $message, $status_code);
}