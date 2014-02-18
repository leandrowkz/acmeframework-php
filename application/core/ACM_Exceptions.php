<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe ACM_Exceptions
* 
* Classe "core" do Codeigniter extendida, para manipulação de erros e exceções em geral. Toda vez
* que um erro (php, database) é disparado, passam por aqui. Erros 404 não são mapeados por esta
* classe (veja classe controllers/acme/acme_access).
*
* @since		13/08/2012
* @location		Codeignter.core.ACM_Exceptions
*
*/
class ACM_Exceptions extends CI_Exceptions {
	// Definição de atributos
	var $CI = null;
	
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
	* @param string template
	* @param string status_code
	* @return void
	*/
    public function show_error($header = '', $message = '', $template = '', $status_code = 500)
    {
		print_r( $header ) . '<br /><br />';
		print_r( $message ) . '<br /><br />';
		// $this->CI =& get_instance();
		// $this->CI->error->show_error($header, $message, $template, $status_code);
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
		print_r( $message ) . '<br /><br />';
		print_r( $filepath ) . '<br /><br />';
		print_r( $line ) . '<br /><br />';
	}
	
	/**
	* show_404()
	* Página de erro 404. Redireciona manualmente para o controlador acme_access/page_not_found
	* @return void
	*/
	function show_404($page = '', $log_error = TRUE)
	{
		// Calcula a URL raiz do projeto
		$htdocs = str_replace('/', '\\', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
		$app_folder = str_replace($htdocs, '', dirname(__FILE__));
		$app_folder = rtrim(str_replace('\\', '/', str_replace(basename($app_folder), '', $app_folder)), '/');
		$URL_ROOT = 'http://' . $_SERVER['SERVER_ADDR'] . str_replace('application', '', $app_folder);
		
		header('location: ' . $URL_ROOT . 'acme_access/page_not_found/?page=' . $page);
		exit;
	}
}