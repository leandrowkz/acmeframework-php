<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller ACME_Core_Controller
* 
* Framework core. It is responsible for loading basic resources and configs for the entire application.
*
* @since	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACME_Core_Controller extends CI_Controller {
	
	public $acme_installed = false; // defines if acme is installed
	protected $acme_version = '2.2.12'; // current version of acme
	protected $app_config_file = 'app_settings'; // application config file
	
	/**
	* __construct()
	* Class constructor. Loads general resources for all application controllers
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();

		// acme version
		if( ! defined('ACME_VERSION'))
			define('ACME_VERSION', $this->acme_version);

		// Loads helpers
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
		
		// Loads application file settings
		$this->_load_app_settings();
		
		// Loads some libraries
		$this->load->library('session');
		$this->load->library('acme/template');
		$this->load->library('acme/error');
		$this->load->library('acme/log');
		$this->load->library('acme/access');
		$this->load->library('acme/form');
		$this->load->library('acme/tag');
		$this->load->library('acme/array_table');
		$this->load->library('acme/validation');
		
		// Sets default language for application
		$language = ($this->session->userdata('language') != '') ? $this->session->userdata('language') : LANGUAGE;
		
		// Loads default language file (located at /application/lang)
		$this->lang->load('app', $language);
		
		// Loads an instance of database connection only if acme is installed
		if($this->acme_installed) 
		{
			$this->load->database();
			
			// If the type connection is ORACLE so disable the escape identifiers
			if(strtolower($this->db->dbdriver) == 'oci8') {
				$this->db->_protect_identifiers = false;
				$this->db->_escape_char = '';
			}
		}
	}

	/**
	* _load_app_settings()
	* Loads the app settings file. For each array $config index a constant by same 
	* name is defined.
	* @return void
	*/
	private function _load_app_settings()
	{

		// Loads properly file if ACME is installed
		if($this->acme_installed) {

			// loads app_settings file
			$this->config->load( $this->app_config_file, true );

			// Loads db driver info
			include_once ('application/config/' . ENVIRONMENT . '/database.php');
			
			// creates a constant
			if(isset($db[$active_group]['dbdriver']) && !defined('DB_DRIVER')) 
				define('DB_DRIVER', $db[$active_group]['dbdriver']);

			// Sets properly config
			$config = $this->config->config['app_settings'];
		} else {

			// Loads the installer_app_settings file
			include_once ('application/core/acme/engine_files/installer_app_settings.php');
		}
		
		foreach($config as $key => $val)
		{
			if(!is_array($val))
			{
				if(!defined($key))
					define($key, $val);
			}	
			$this->{$key} = $val;
		}

	}
}
