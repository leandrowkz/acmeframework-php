<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller ACME_Core
 *
 * Framework core. It is responsible for loading basic resources and configs for the entire application.
 *
 * @since	13/08/2012
 * --------------------------------------------------------------------------------------------------
 */
class ACME_Core extends CI_Controller {

	/**
	 * Define if ACME Framework is installed or not.
	 * @var boolean
	 */
	public $acme_installed;

	/**
	 * Define current ACME Framework version.
	 * @var String
	 */
	protected $acme_version = '3.0.0';

	/**
	 * Define app config file name.
	 * @var String
	 */
	protected $app_config_file = 'app_settings';

	/**
	 * Class constructor. Loads general resources for all application controllers
	 *
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

		// Load CI native helper
		$this->load->helper('Url');

		// Load application file settings
		$this->_load_app_settings();

		// Load ACME libraries
		$this->load->library('Template', '', 'template');
		$this->load->library('Logger', '', 'logger');
		$this->load->library('Error', '', 'error');
		$this->load->library('Access', '', 'access');
		$this->load->library('Array_Table', '', 'array_table');
		$this->load->library('Form', '', 'form');
		$this->load->library('Tag', '', 'tag');
		$this->load->library('Validation', '', 'validation');

		// Load ACME helpers
		$this->load->helper('Access');
		$this->load->helper('Array');
		$this->load->helper('Error');
		$this->load->helper('Form');
		$this->load->helper('Logger');
		$this->load->helper('Tag');
		$this->load->helper('Template');
		$this->load->helper('Validation');
		$this->load->helper('Language');

		// Load native libraries
		$this->load->library('Session', '', 'session');

		// Set default language for application
		$language = ($this->session->userdata('language') != '') ? $this->session->userdata('language') : LANGUAGE;

		// Set language on session
		$this->session->set_userdata('language', $language);

		// Load default language file (located at /application/lang)
		$this->lang->load('app', $language);
	}

	/**
	 * Loads the app settings file. For each array $config index a constant by same
	 * name is defined.
	 *
	 * @return void
	 */
	private function _load_app_settings()
	{
		// Load properly file if ACME is installed
		if( $this->acme_installed ) {

			// Load app_settings file
			$this->config->load( $this->app_config_file, true );

			// Set configs will be readed
			$config = $this->config->config [ $this->app_config_file ];
		}

		// Load the installer_app_settings file
		else
			include_once ('application/core/engine-files/installer_' . $this->app_config_file . '.php');

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
	 * Checks if acme framework is already installed or not. Returns true or false.
	 *
	 * @return boolean
	 */
	private function _is_acme_installed()
	{
		// To determine if acme is installed or not, we have to verify if
		// app_settings.php and database.php files exist on config directory
		return ( file_exists('application/config/' . ENVIRONMENT . '/' . $this->app_config_file . '.php')
			 && file_exists('application/config/' . ENVIRONMENT . '/database.php') );
	}
}
