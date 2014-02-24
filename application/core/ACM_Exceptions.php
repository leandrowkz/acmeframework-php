<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* ACM_Exceptions (extended from CI_Exceptions)
*
* Responsável pela manipulação de erros da aplicação. Toda vez que um erro (php, database, 404) é 
* disparado, passam por aqui.
*
* @since 	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACM_Exceptions extends CI_Exceptions {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	* show_error()
	* Mapeia e manipula erros gerais da aplicação. Recebe automaticamente um conjunto de parametros
	* que definem o nivel do erro.
	* @param string header
	* @param string message
	* @param string error_type
	* @param string status_code
	* @return void
	*/
	public function show_error($header = '', $message = '', $error_type = '', $status_code = 500)
	{
		$this->CI =& get_instance();

		// verifica situação da instalação do ACME
		$log_db = ($this->CI->acme_installed && is_object($this->CI->db)) ? true : false;

		// Exibe msg de erro
		$this->CI->error->show_error($header, $message, $error_type, $status_code, $log_db);
	}
	
	/**
	* show_php_error()
	* Mapeia e manipula erros de php da aplicação. Recebe automaticamente um conjunto de parametros
	* que definem o nivel do erro.
	* @param string severity
	* @param string message
	* @param string filepath
	* @param string line
	* @return void
	*/
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0)
	{
		$this->CI =& get_instance();

		// verifica situação da instalação do ACME
		$log_db = ($this->CI->acme_installed && is_object($this->CI->db)) ? true : false;

		// Exibe msg de erro
		$this->CI->error->show_php_error($this->levels[$severity], $message, $filepath, $line, $log_db);
		
	}
	
	/**
	* show_404()
	* Página de erro 404. Redireciona manualmente para o controlador acme_access/page_not_found
	* @return void
	*/
	function show_404($page = '', $log_error = TRUE)
	{
		// Load Router and Core classes.
    	$RTR =& load_class('Router', 'core');

    	// Redirect to not found
    	header("Location: " . $RTR->config->config['base_url'] . 'app_access/not_found');
    	exit;
    }
}