<?php
/**
*
* Classe Error
*
* Esta biblioteca gerencia a manipulação de erros no sistema.
* 
* @since		01/10/2012
* @location		acme.libraries.error
*
*/
class Error  {
	// Definição de Atributos
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
		{
			$this->CI->log->log_error($template, $header, $message, $status_code);
		}
		
		// Pagina de erro
		echo $this->CI->template->load_page('_errors/' . $template, array('header' => $header, 'message' => $message), true, false);
		exit;
    }
	
	/**
	* show_exception_page()
	* Exibe uma página com uma mensagem de exceção, apenas. Quando informado o segundo parametro, 
	* a página exibirá um botão inferior o qual conterá um link de volta.
	* @param string message
	* @return void
	*/
    public function show_exception_page($message = '', $link_to_back = '')
    {
		$this->CI =& get_instance();
		
		// Pagina com mensagem
		echo $this->CI->template->load_page('_errors/exception_page', array('message' => $message, 'link_to_back' => $link_to_back), true, false);
		exit;
    }
	
	/**
	* show_exception_message()
	* Exibe uma mensagem de exceção, sem página master ou algo do tipo. Ideal para modais. Quando 
	* informado o segundo parametro, a página exibirá conteúdo html adicional, após a mensagem.
	* @param string message
	* @param string additional_html
	* @return void
	*/
    public function show_exception_message($message = '', $additional_html = '')
    {
		$this->CI =& get_instance();
		
		// Pagina com mensagem
		echo $this->CI->template->load_page('_errors/exception_message', array('message' => $message, 'additional_html' => $additional_html), true, false);
		exit;
    }
	
	/**
	* show_php_error()
	* Box de erro ou warning do PHP.
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
		
		// Por razões de segurança, não exibimos o path completo
		$filepath = str_replace("\\", "/", $filepath);
		if (FALSE !== strpos($filepath, '/'))
		{
			$x = explode('/', $filepath);
			$filepath = $x[count($x)-2].'/'.end($x);
		}
		
		// Loga erro no banco de dados
		$this->CI->log->log_error('error_php', lang('PHP Error'), $message . " (filepath: " . $filepath . ", line: " . $line . ")", 500);
		
		// Carrega metodo de erro genérico
		echo $this->CI->template->load_page('_errors/error_php', array('severity' => $severity, 'message' => $message, 'filepath' => $filepath, 'line' => $line), true, false);
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
	
	/**
	* count_distinct_errors()
	* Retorna quantidade de erros distintos cadastrados no banco de dados.
	* @return integer total
	*/
	public function count_distinct_errors()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('libraries/error_model');
		return $this->CI->error_model->count_distinct_errors();
	}
	
	/**
	* get_log_errors()
	* Retorna os erros cadastrados no banco de dados, ordenados por horário de acontecimento.
	* @param string error_type
	* @return array errors
	*/
	public function get_log_errors($error_type = '', $limit = 0)
	{
		$this->CI =& get_instance();
		$this->CI->load->model('libraries/error_model');
		return $this->CI->error_model->get_log_errors($error_type, $limit);
	}
	
	/**
	* get_distinct_types()
	* Retorna array de tipos de erros distintos cadastrados na aplicação.
	* @return array errors_type
	*/
	public function get_distinct_types()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('libraries/error_model');
		return $this->CI->error_model->distinct_types();
	}
	
	/**
	* get_count_errors_by_type()
	* Retorna array de quantidade de erros por tipo.
	* @return array errors
	*/
	public function get_count_errors_by_type()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('libraries/error_model');
		return $this->CI->error_model->get_count_errors_by_type();
	}
}