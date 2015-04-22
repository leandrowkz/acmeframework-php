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
	
	public $acme_installed; // defines if acme is installed
	protected $acme_version = '2.3.12'; // current version of acme
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
		if ( ! defined('ACME_VERSION') )
			define('ACME_VERSION', $this->acme_version);

		// Define if acme is installed or not
		$this->acme_installed = $this->_is_acme_installed();

		// Load helpers - needed on load app settings
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

		// Load an instance of database connection only if acme is installed
		$this->_load_database_connection();

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
		if( $this->acme_installed ) {

			// loads app_settings file
			$this->config->load( $this->app_config_file, true );

			// Sets configs will be readed
			$config = $this->config->config [ $this->app_config_file ];
		} 

		// Loads the installer_app_settings file
		else
			include_once ('application/core/acme/engine_files/installer_app_settings.php');
		
		// DB_DRIVER constant - used for loading ACME models
		if ( ! defined('DB_DRIVER') ) {

			$db_driver = $this->acme_installed ? $this->db->dbdriver : '';

			// Creates a PHP constant
			define('DB_DRIVER', $db_driver);
		}

		// Now for each config it creates a PHP constant of same name
		// and creates an attribute that is going to be accessible on
		// every controller
		foreach($config as $key => $val)
		{
			if ( ! is_array($val) )
				if ( ! defined($key) )
					define($key, $val);

			$this->{$key} = $val;
		}

	}

	/**
	* _load_database_connection()
	* Loads a database connection checking if acme is properly installed.
	* @return void
	*/
	private function _load_database_connection()
	{
		if ( $this->acme_installed ) {
			
			$this->load->database();
			
			// If the type connection is ORACLE so disable the escape identifiers
			if ( strtolower($this->db->dbdriver) == 'oci8' ) {
				$this->db->_protect_identifiers = false;
				$this->db->_escape_char = '';
			}
		}
	}

	/**
	* _is_acme_installed()
	* Checks if acme framework is already installed or not. Returns true or false.
	* @return boolean
	*/
	private function _is_acme_installed()
	{
		// To determine if acme is installed or not, we have to verify if
		// app_settings.php and database.php files exist on config directory
		if ( file_exists('application/config/' . ENVIRONMENT . '/' . $this->app_config_file . '.php') 
			 && file_exists('application/config/' . ENVIRONMENT . '/database.php') )
			return true;
		else 
			return false;
	}
}
