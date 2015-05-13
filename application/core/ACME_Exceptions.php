<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * ACME_Exceptions (extended from CI_Exceptions)
 *
 * This core class is responsible for error handling on application. Every time an error is detected
 * this class is loaded and treated depending on the type of error.
 *
 * @since 	13/08/2012
 * --------------------------------------------------------------------------------------------------
 */
class ACME_Exceptions extends CI_Exceptions {

	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Map and handle general application errors.
	 *
	 * @param string header
	 * @param string message
	 * @param string error_type
	 * @param string status_code
	 * @return void
	 */
	public function show_error($header = '', $message = '', $error_type = '', $status_code = 500)
	{
		$this->CI =& get_instance();

		// Check if ACME is installed so doesnt log on database
		$log_db = ( $this->CI->acme_installed && is_object($this->CI->db) );

		// Show error msg
		$this->CI->error->show_error($header, $message, $error_type, $status_code, $log_db);
	}

	/**
	 * Map and handle general exceptions.
	 *
	 * @param Exception $exception
	 * @return void
	 */
	public function show_exception(Exception $exception)
	{
		$this->CI =& get_instance();

		// Check if ACME is installed so doesnt log on database
		$log_db = ( $this->CI->acme_installed && is_object($this->CI->db) );

		// Show exception page
		$this->CI->error->show_exception( $exception );
	}

	/**
	 * Map and handle application php errors.
	 *
	 * @param string severity
	 * @param string message
	 * @param string filepath
	 * @param string line
	 * @return void
	 */
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0)
	{
		$this->CI =& get_instance();

		// Check if ACME is installed so doesnt log on database
		$log_db = ( $this->CI->acme_installed && is_object($this->CI->db) );

		// Show error msg
		$this->CI->error->show_php_error($this->levels[$severity], $message, $filepath, $line, $log_db);
	}

	/**
	 * Map and handle application 404 errors.
	 *
	 * @return void
	 */
	function show_404($page = '', $log_error = TRUE)
	{
		// Gets an ACME Core instance
		$core = new ACME_Core();

		// Shows a 404 page
		$core->error->show_404();
    }
}
