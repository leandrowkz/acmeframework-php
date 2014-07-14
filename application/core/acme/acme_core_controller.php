<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller ACME_Core_Controller
* 
* Framework core. Responsible for loading basic resources and configs for the application.
*
* @since	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACME_Core_Controller extends CI_Controller {
	
	public $acme_installed = true;	// define if acmeengine is installed
	protected $acme_version = '2.0.0';	// current version of acmeengine
	protected $app_config_file = 'app_settings';	// application config file
	
	/**
	* __construct()
	* Loading generic resources for all application's controllers
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();

		// acmeengine version
		if( ! defined('ACME_VERSION'))
			define('ACME_VERSION', $this->acme_version);

		// Load helpers
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
		
		// Load application file settings
		$this->_load_app_settings();
		
		// Load some libraries
		$this->load->library('session');
		$this->load->library('acme/template');
		$this->load->library('acme/error');
		$this->load->library('acme/log');
		$this->load->library('acme/access');
		$this->load->library('acme/form');
		$this->load->library('acme/tag');
		$this->load->library('acme/array_table');
		$this->load->library('acme/validation');
		
		// Set default language for application
		$language = ($this->session->userdata('language') != '') ? $this->session->userdata('language') : LANGUAGE;
		
		// Load default language file (located at /application/lang)
		$this->lang->load('app', $language);
		
		// Load an instance of database connection only if acmeengine is installed
		if($this->acme_installed) 
		{
			$this->load->database();
			
			// If the type connection is ORACLE so disable the escape identifiers
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
