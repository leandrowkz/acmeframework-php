<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Error
*
* Biblioteca de funções relacionadas a manipulação de erros no sistema.
* 
* @since 	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Error {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* show_error()
	* Exibe uma página de erro conforme parametros encaminhados.
	* @param string header
	* @param string message
	* @param string template
	* @param string status_code
	* @return void
	*/
    public function show_error($header = '', $message = '', $template = 'error_general', $status_code = 500, $log_error = true)
    {
		$this->CI =& get_instance();

		// Processa message (muda conforme o tipo de erro)
		switch($template)
		{
			case 'error_db':
				$message = get_value($message, 1) . '<BR /><BR /><strong>SQL: </strong>' . get_value($message, 2);
			break;
			
			default:
				$message = $message;
			break;
		}
		
		// Loga erro no banco de dados
		if($log_error)
			$this->CI->log->log_error($template, $header, $message, $status_code);
		
		// Carrega view
		echo $this->CI->template->load_page('_errors/' . $template, array('header' => $header, 'message' => $message), true, false);
		exit;
    }

    /**
	* show_php_error()
	* Box de erro ou warning do PHP. O processamento não é interrompido.
	* @param string severity
	* @param string message
	* @param string filepath
	* @param string line
	* @return void
	*/
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0)
	{
		$this->CI =& get_instance();
		
		// Processa gravidade
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
		
		// Por razões de segurança, o path completo não é exibido
		$filepath = str_replace("\\", "/", $filepath);
		if (FALSE !== strpos($filepath, '/'))
		{
			$x = explode('/', $filepath);
			$filepath = $x[count($x)-2].'/'.end($x);
		}
		
		// Loga erro no banco de dados
		$this->CI->log->log_error('error_php', lang('PHP Error'), $message . " (filepath: " . $filepath . ", line: " . $line . ")", 500);
		
		// Carrega view do erro (box, processamento não é interrompido)
		echo $this->CI->template->load_page('_errors/error_php', array('severity' => $severity, 'message' => $message, 'filepath' => $filepath, 'line' => $line), true, false);
	}
	
	/**
	* show_exception_page()
	* Desvia o processamento e exibe página de exceção genérica. Recebe como parâmetro o html da mensagem de exceção.
	* @param string html_message
	* @return void
	*/
    public function show_exception_page($html_message = '')
    {
		$this->CI =& get_instance();
		echo $this->CI->template->load_page('_errors/exception_page', array('html_message' => $html_message), true, false);
		exit;
    }

	/**
	* show_404()
	* Página de erro 404.
	* @return void
	*/
	public function show_404()
	{
		$this->CI =& get_instance();
		$args['url_default'] = ($this->CI->session->userdata('url_default') == '') ? URL_ROOT : $this->CI->session->userdata('url_default');
		echo $this->CI->template->load_page('_errors/error_404', $args, true, false);
	}
}