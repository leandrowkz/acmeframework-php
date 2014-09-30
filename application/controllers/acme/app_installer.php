<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Installer
* 
* ACME Framework installer.
*
* @since 	04/08/2014
*
* --------------------------------------------------------------------------------------------------
*/
class App_Installer extends ACME_Core_Controller {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();

		// Sets language setting
		if ( $this->session->userdata('language') == '')
			$this->session->set_userdata('language', LANGUAGE);

		// Sets url_default setting
		if ( $this->session->userdata('url_default') == '')
			$this->session->set_userdata('url_default', 'http://www.acmeframework.org');

	}
	
	/**
	* index()
	* Redirects to step one of installation.
	* @return void
	*/
	public function index()
	{
		// Checks if acme is already installed
		if ( $this->acme_installed )
			redirect('app_access');
		
		// Redirects to step one
		redirect('app_installer/system_requirements');
	}

	/**
	* system_requirements()
	* Step 1 of installation - System requirements page.
	* @return void
	*/
	public function system_requirements()
	{
		// Checks if acme is already installed
		if ( $this->acme_installed )
			redirect('app_access');

		// Database settings
		$db_driver = $this->input->post('db_driver'); 
		$db_host = $this->input->post('db_host'); 
		$db_port = $this->input->post('db_port'); 
		$db_user = $this->input->post('db_user'); 
		$db_pass = $this->input->post('db_pass'); 
		$db_database = $this->input->post('db_database'); 

		// View vars and requirements
		$args['path_permissions'] = $this->_check_path_permissions();
		$args['php_version'] = $this->_check_php_version();
		$args['php_database_extension'] = $this->_check_php_database_extension($db_driver);
		$args['database_server'] = $this->_check_database_server($db_driver, $db_host, $db_port, $db_user, $db_pass, $db_database);

		// Form data for database
		$args['params'] = $this->input->post();

		// Loads view
		$this->template->load_page('_acme/app_installer/system_requirements', $args, false, false);
	}

	/**
	* new_app_info()
	* Step 2 of installation - New application info page.
	* @param boolean process
	* @return void
	*/
	public function new_app_info($process = false)
	{
		// Checks if acme is already installed
		if ( $this->acme_installed )
			redirect('app_access');

		// Database settings
		$db_driver = $this->input->post('db_driver'); 
		$db_host = $this->input->post('db_host'); 
		$db_port = $this->input->post('db_port'); 
		$db_user = $this->input->post('db_user'); 
		$db_pass = $this->input->post('db_pass'); 
		$db_database = $this->input->post('db_database'); 

		// View vars and requirements
		$path_permissions = $this->_check_path_permissions();
		$php_version = $this->_check_php_version();
		$php_database_extension = $this->_check_php_database_extension($db_driver);
		$database_server = $this->_check_database_server($db_driver, $db_host, $db_port, $db_user, $db_pass, $db_database);

		// Form data
		$args['post'] = $this->input->post();

		// Dummy logo var
		$args['app_logo'] = true;

		// procceds only with no errors
		if( ! $path_permissions || ! $php_version || ! $php_database_extension || $database_server !== true)
			redirect('app_installer');

		// Just loads page
		if( ! $process)
			$this->template->load_page('_acme/app_installer/new_app_info', $args, false, false);
		
		// installs acme framework - create new application
		else {

			// Tries to upload logo
			if( isset($_FILES['app_logo']['name']) ) {

				if($_FILES['app_logo']['name'] != '') {
					
					// config array for uploading
					$config['overwrite'] = true;
					$config['file_name'] = 'logo';
					$config['upload_path'] = PATH_IMG;
					$config['allowed_types'] = 'png';
					$config['max_size']	= '2000';
					$config['max_width']  = '500';
					$config['max_height']  = '150';
					$this->load->library('upload', $config);

					// Tries to upload logo
					$args['app_logo'] = $this->upload->do_upload('app_logo') ? true : $this->upload->display_errors('<span>','</span>');
			 	}
			}

			// Checks if there is errors on logo
			if ( $args['app_logo'] !== true )
				$this->template->load_page('_acme/app_installer/new_app_info', $args, false, false);

			// Procceds with installation!
			else {

				// installs acme framework
				$this->_install_acme_framework($this->input->post());

				// Sets session var saying that app was created
				$this->session->set_userdata('installed', true);

				// Redirects to summary page
				redirect('app_installer/summary');
			}
		}
	}

	/**
	* summary()
	* Step 3 of installation - Application review. At this point the 
	* application is already created.
	* @return void
	*/
	public function summary()
	{
		if( $this->session->userdata('installed') === true )
			$this->template->load_page('_acme/app_installer/summary', array(), false, false);
		else
			redirect('app_installer');	
	}

	/**
	* _check_path_permissions()
	* Checks permissions for needed paths:
	* 	-> application/controllers
	* 	-> application/models
	* 	-> application/views
	* Returns true or false in case of doesnt has permissions for write.
	* @return boolean has-permissions
	*/
	private function _check_path_permissions()
	{
		if ( is_writable('application/core/acme/acme_core_controller.php') 
			 && is_readable('application/core/acme/engine_files/installer_app_settings.php')
			 && is_readable('application/core/acme/engine_files/installer_database.php')
			 && is_writable('application/config/development')
			 && is_writable('application/config/production')
			 && is_readable('application/core/acme/engine_files')
		   )
			return true;
		else
			return false;
	}

	/**
	* _check_php_version()
	* Checks minor php version needed.
	* @return boolean
	*/
	private function _check_php_version()
	{
		return is_php('5.3.5');
	}

	/**
	* _check_php_database_extension()
	* Checks if exist PHP connector extension for the given selected database.
	* @param string db_driver
	* @return boolean
	*/
	private function _check_php_database_extension($db_driver = '')
	{
		return extension_loaded( strtolower($db_driver) );
	}

	/**
	* _check_database_server()
	* Checks if exist a database server running on the given db_params. Return
	* true in case of success otherwise return the message of error.
	* @param string db_driver	// mysql, pgsql, oci8
	* @param string db_host
	* @param string db_port
	* @param string db_user
	* @param string db_pass
	* @param string db_database
	* @return boolean|string
	*/
	private function _check_database_server($db_driver = '', $db_host = '', $db_port = '', $db_user = '', $db_pass = '', $db_database = '')
	{
		if ($db_driver == '' || $db_host == '' || $db_port == '' || $db_user == '' || $db_database == '')
			return lang('You must set all database settings');

		// checks dbdriver
		switch (strtolower($db_driver)) {

			// MySQL driver
			case 'mysql':

				// mannually open a link with mysql
				$link = @mysqli_connect($db_host, $db_user, $db_pass, null, $db_port);

				// If there is an error opening the link
				if( ! $link)
					return lang('Error connecting on MySQL server: ') . mysqli_connect_error();

				/*
				// Checks if given user has all neccessary permissions / grants
				@mysqli_select_db($link, 'mysql');
				$result = @mysqli_query($link, "SELECT user, select_priv, insert_priv, create_priv FROM mysql.user WHERE host = '$db_host' AND user = '$db_user'");
				$result = @mysqli_fetch_assoc($result);

				// Checks privilegies
				if ( strtolower(get_value($result, 'select_priv')) != 'y' )
					return lang('User doesn\'t has permissions for query (SELECT)');
				
				if ( strtolower(get_value($result, 'insert_priv')) != 'y' )
					return lang('User doesn\'t has permissions for insertion (INSERT)');
				
				if(strtolower(get_value($result, 'create_priv')) != 'y')
					return lang('User doesn\'t has permissions for create tables or schemas (CREATE)');
				*/

				// Checks if schema already exist
				$result = @mysqli_query($link, "SELECT count(*) AS COUNT_DATABASE FROM information_schema.schemata where schema_name = '$db_database'");
				$result = @mysqli_fetch_assoc($result);
					
				if( get_value($result, 'COUNT_DATABASE') > 0 )
					return lang('Schema already exist:') . ' <u>' . $db_database . '</u> ';

				// closes connection
				@mysqli_close($link);

				// There is no errors, you can procced :)
				return true;

			break;

			// PostgreSQL driver
			case 'pgsql':

				// mannually open a link with pg
				$connection = "host=$db_host port=$db_port user=$db_user password=$db_pass";
				$link = @pg_connect($connection);

				// If there is an error opening the link
				if( ! $link)
					return lang('Error connecting on PostgreSQL server: unable to connect with the given parameters');

				// Checks if schema already exist
				$result = pg_query($link, "SELECT count(*) AS COUNT_DATABASE FROM pg_catalog.pg_database WHERE lower(datname) = lower('$db_database')");
				$result = pg_fetch_assoc($result);
					
				if( get_value($result, 'COUNT_DATABASE') > 0 )
					return lang('Schema already exist:') . ' <u>' . $db_database . '</u> ';

				// closes connection
				@pg_close($link);

				// There is no errors, you can procced :)
				return true;

			break;

		}

	}
	
	/**
	* _install_acme_framework()
	* Receives a POST data and install acme fmk, creating the new application.
	* @param array post
	* @return void
	*/
	private function _install_acme_framework($post = array())
	{
		// Gets app_settings content
		$config = file_get_contents('application/core/acme/engine_files/installer_app_settings.php');
		
		// Replaces app_settings values
		$config = str_replace('$config[\'APP_NAME\'] = \'ACME Framework\';', '$config[\'APP_NAME\'] = \'' . get_value($post, 'app_name') . '\';', $config);
		$config = str_replace('$config[\'LANGUAGE\'] = \'en_US\';', '$config[\'LANGUAGE\'] = \'' . get_value($post, 'app_language') . '\';', $config);

		// Sets new content for valid app_settings file
		file_put_contents('application/config/development/app_settings.php', $config);
		file_put_contents('application/config/production/app_settings.php', $config);
		
		// Gets database settings file content
		$database = file_get_contents('application/core/acme/engine_files/installer_database.php');

		// Values for database
		$db_driver = get_value($post, 'db_driver');
		$db_host = get_value($post, 'db_host');
		$db_port = get_value($post, 'db_port');
		$db_user = get_value($post, 'db_user');
		$db_pass = get_value($post, 'db_pass');
		$db_database = get_value($post, 'db_database');

		// Builds specific string connection for oci8
		if ( strtolower($db_driver) == 'oci8') {

			$db_host = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $db_host)(PORT = $db_port)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = $db_database)))";
			$db_port = '';
			$db_database = '';
		} 

		// Specific driver for postgre
		$db_file_driver = strtolower($db_driver) == 'pgsql' ? 'postgre' : $db_driver;

		// Replaces database settings values
		$database = str_replace('<DB_DRIVER>', $db_file_driver, $database);
		$database = str_replace('<DB_HOST>', $db_host, $database);
		$database = str_replace('<DB_PORT>', $db_port, $database);
		$database = str_replace('<DB_USER>', $db_user, $database);
		$database = str_replace('<DB_PASS>', $db_pass, $database);
		$database = str_replace('<DB_DATABASE>', $db_database, $database);

		// Sets new content for database settings
		file_put_contents('application/config/development/database.php', $database);
		file_put_contents('application/config/production/database.php', $database);

		// Installs database
		$this->_install_database($db_driver, $post);

		// And the last thing...
		// Changes core file, set acme to installed
		$core = file_get_contents('application/core/acme/acme_core_controller.php');
		$core = str_replace('$acme_installed = false;', '$acme_installed = true;', $core);
		file_put_contents('application/core/acme/acme_core_controller.php', $core);

	}

	/**
	* _install_database()
	* Installs database stuffs (create table and stuffs) for the given driver.
	* @param string db_driver
	* @param array post
	* @return void
	*/
	private function _install_database($db_driver = '', $post = array())
	{
		// Script name (for database)
		$script = file_get_contents('application/core/acme/engine_files/installer_dump_' . strtolower( $db_driver ) . '.sql');

		// Separes all statements
		$statements = explode('<<|SEPARATOR|>>', $script);

		// Unloads object db if exist, to create it again
		if ( isset($this->db) )
			unset($this->db);

		switch(strtolower($db_driver))
		{

			// MySQL or PostgreSQL
			case 'mysql':
			case 'pgsql':

				// Values for database
				$db_driver = strtolower(get_value($post, 'db_driver')) == 'pgsql' ? 'postgre' : get_value($post, 'db_driver');
				$db_host = get_value($post, 'db_host');
				$db_port = get_value($post, 'db_port');
				$db_user = get_value($post, 'db_user');
				$db_pass = get_value($post, 'db_pass');
				$db_database = get_value($post, 'db_database');

				// Opens mannually database connection
				$db = array(
					'hostname' => $db_host,
					'port'     => $db_port,
					'username' => $db_user,
					'password' => $db_pass,
					'dbdriver' => $db_driver,
					'database' => ''
				);

				// Loads connection with the given values
				$this->load->database($db);

				// Loads dbforge to construct a new database
				$this->load->dbforge();

				// Sanytizes db name
				$db_database = $this->db->protect_identifiers($db_database);
				
				// Tries to create database
				$this->dbforge->create_database($db_database);

				// Closes to procced with other queries
				unset($this->db);

				// Now connects with database settings file and recently created database
				$this->load->database();

				foreach($statements as $sql) {
					
					// Prepares statement
					$sql = trim($sql, " \t\n\r\0\x0B");

					// Runs query
					$this->db->query($sql);
				}

			break;

		}

		// Auxiliar helper for security on database
		$this->load->helper('security');

		// After create database, sets values for ROOT user
		$user['email'] = xss_clean( get_value($post, 'email') );
		$user['password'] = md5( xss_clean( get_value($post, 'user_pass') ) );
		$user['name'] = xss_clean( get_value($post, 'user_name') );

		// Updates user
		$this->db->update('acm_user', $user, array('id_user' => 1));

		// Updates user language
		$user_config['lang_default'] = xss_clean( get_value ($post, 'app_language') );
		$this->db->update('acm_user_config', $user_config, array('id_user' => 1));
	}

	/**
	* change_language()
	* Changes current language on session.
	* @param string language 	// en_US, pt_BR, es_ES ...
	* @return string json
	*/
	public function change_language($language = '')
	{
		$this->session->set_userdata('language', $language);
		echo json_encode(array('return' => true));
	}
	
}
