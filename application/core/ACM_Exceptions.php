<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* ACM_Exceptions (extended from CI_Exceptions)
*
* This core class is responsible for error handling on application. Every time an error is detected
* this class is loaded and treated depending on the type of error.
*
* @since 	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACM_Exceptions extends CI_Exceptions {
	
	public $CI = null;
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* show_error()
	* Map and handle general application errors.
	* @param string header
	* @param string message
	* @param string error_type
	* @param string status_code
	* @return void
	*/
	public function show_error($header = '', $message = '', $error_type = '', $status_code = 500)
	{
		$this->CI =& get_instance();

		// Check if acme is installed so doesnt log on database
		if ( $this->CI->acme_installed && is_object($this->CI->db) ) 
			$log_db = $this->CI->db->database != '' ? true : false;
		else
			$log_db = false;

		// Show error msg
		$this->CI->error->show_error($header, $message, $error_type, $status_code, $log_db);
	}
	
	/**
	* show_php_error()
	* Map and handle application php errors.
	* @param string severity
	* @param string message
	* @param string filepath
	* @param string line
	* @return void
	*/
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0)
	{
		$this->CI =& get_instance();

		// Check if acme is installed so doesnt log on database
		if ( $this->CI->acme_installed && is_object($this->CI->db) ) 
			$log_db = $this->CI->db->database != '' ? true : false;
		else
			$log_db = false;

			// Show error msg
		$this->CI->error->show_php_error($this->levels[$severity], $message, $filepath, $line, $log_db);
		
	}
	
	/**
	* show_404()
	* Map and handle application 404 errors.
	* @return void
	*/
	function show_404($page = '', $log_error = TRUE)
	{
		// Load Router and Core classes.
    	$RTR =& load_class('Router', 'core');

    	// Redirect to not found
    	header("Location: " . $RTR->config->config['base_url'] . 'app_access/not_found');
    	exit;
    }
}