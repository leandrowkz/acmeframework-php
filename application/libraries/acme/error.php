<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Error
*
* Gathers methods related with the application error handling.
* 
* @since 	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Error {
	
	public $CI = null;
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	* show_error()
	* Shows a generic error page according with the forwarded parameters.
	* @param string header
	* @param string message
	* @param string template
	* @param string status_code
	* @param boolean log_error
	* @return void
	*/
    public function show_error($header = '', $message = '', $template = 'error_general', $status_code = 500, $log_error = true)
    {
		

		// Loga erro no banco de dados
		if($log_error)
			$this->CI->log->log_error($template, $header, $message, $status_code);
		
		// Carrega view
		echo $this->CI->template->load_page('_errors/' . $template, array('header' => $header, 'message' => $message), true, false);
		exit;
    }

    /**
	* show_php_error()
	* Shows a HTML box containing a PHP error. The page proccess is not interrupted.
	* @param string severity
	* @param string message
	* @param string filepath
	* @param string line
	* @param boolean log_error
	* @return void
	*/
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0, $log_error = true)
	{
		$this->CI =& get_instance();
		
		// Processa gravidade
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
		
		// Loga erro no banco de dados
		if($log_error && is_object($this->CI->db))
			$this->CI->log->log_error('error_php', lang('PHP Error'), $message . " (filepath: " . $filepath . ", line: " . $line . ")", 500);
		
		// Carrega view do erro (box, processamento não é interrompido)
		echo $this->CI->template->load_page('_errors/error_php', array('severity' => $severity, 'message' => $message, 'filepath' => $filepath, 'line' => $line), true, false);
	}
	
	/**
	* show_exception_page()
	* Shows an exception page containing the forwarded message.
	* @param string message
	* @return void
	*/
    public function show_exception_page($message = '')
    {
		$this->CI =& get_instance();
		echo $this->CI->template->load_page('_errors/exception_page', array('message' => $message), true, false);
		exit;
    }

	/**
	* show_404()
	* Shows a 404 error page.
	* @return void
	*/
	public function show_404()
	{
		$this->CI =& get_instance();
		echo $this->CI->template->load_page('_errors/error_404', array(), true, false);
		exit;
	}
}