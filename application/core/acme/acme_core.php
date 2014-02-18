<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* ACME_Core
* 
* Núcleo da aplicação. Responsável por carregar recursos básicos e configurações 
* para a aplicação.
*
* @since	13/08/2012
*
*/
class ACME_Core extends CI_Controller {
	
	private $_installed = true;	// define se ACME está instalado
	private $version = '2.0.0';	// versão atual do ACME Engine
	private $app_config_file = 'app_settings';	// arquivo de configurações da app
	
	/**
	* __construct()
	* Carrega recursos para genéricos para a aplicação.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();

		// define versão do ACME
		if( ! defined('ACME_VERSION'))
			define('ACME_VERSION', $this->version);

		// Carrega helpers
		$this->load->helper('url_helper');
		$this->load->helper('acme/access_helper');
		$this->load->helper('acme/array_helper');
		$this->load->helper('acme/error_helper');
		$this->load->helper('acme/form_helper');
		$this->load->helper('acme/log_helper');
		$this->load->helper('acme/tag_helper');
		$this->load->helper('acme/template_helper');
		$this->load->helper('acme/validation_helper');
		$this->load->helper('acme/language');
		
		// Carrega configurações da app
		$this->_load_app_settings();
		
		// Carrega bibliotecas
		$this->load->library('session');
		$this->load->library('acme/template');
		$this->load->library('acme/error');
		$this->load->library('acme/log');
		$this->load->library('acme/access');
		$this->load->library('acme/form');
		$this->load->library('acme/tag');
		
		// Define a linguagem padrão da aplicacão
		$language = ($this->session->userdata('language') != '') ? $this->session->userdata('language') : LANGUAGE;
		
		// Carrega arquivo de linguagem padrao
		$this->lang->load('app', $language);
		
		// Carrega uma instancia com banco de dados caso ACME esteja instalado
		if($this->_installed) 
		{
			$this->load->database();
			
			// Desmarca escape de identificadores para uso no oracle
			$this->db->_protect_identifiers = false;
			$this->db->_escape_char = '';
		}
	}

	/**
	* _load_app_settings()
	* Carrega arquivo de configurações da aplicação. Para cada índice do array um atributo e
	* constante de mesmo nome são definidos.
	* @return void
	*/
	private function _load_app_settings()
	{
		$this->config->load( $this->app_config_file, true );
		
		foreach($this->config->config['app_settings'] as $key => $val)
		{
			if(!is_array($val))
			{
				if(!defined($key))
					define($key, $val);
			}	
			$this->{$key} = $val;
		}

		// Carrega informação DB_DRIVER
		include_once ('application/config/' . ENVIRONMENT . '/database.php');
		
		if(isset($db[$active_group]['dbdriver']) && !defined('DB_DRIVER')) 
			define('DB_DRIVER', $db[$active_group]['dbdriver']);
	}
}
