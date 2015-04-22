<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Logger
 *
 * Gathers methods related with application logs and error logs.
 *
 * @since 	01/10/2012
 * --------------------------------------------------------------------------------------------------
 */
class Logger {

	/**
	 * CI controller instance.
	 * @var object
	 */
	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Saves a log on database (table acm_log).
	 *
	 * @param string text_log
	 * @param string action
	 * @param string table
	 * @param array additional_data
	 * @return void
	 */
	public function db_log($text_log = '', $action = '', $table = '', $additional_data = array())
	{
		$this->CI =& get_instance();
		$this->CI->load->library('user_agent');

		// Maybe user dont exist
		if( $this->CI->session->userdata('id_user') != '' )
			$log['id_user'] = $this->CI->session->userdata('id_user');

		// Log data
		$log['table_name'] = $table;
		$log['action'] = $action;
		$log['log_description'] = $text_log;
		$log['additional_data'] = json_encode($additional_data);
		$log['user_agent'] = $this->CI->agent->agent_string();
		$log['browser_name'] = $this->CI->agent->browser();
		$log['browser_version'] = $this->CI->agent->version();
		$log['device_name'] = $this->CI->agent->is_mobile()	? $this->CI->agent->mobile() : 'PC';
		$log['platform'] = $this->CI->agent->platform();
		$log['ip_address'] = $this->CI->input->ip_address();

		// Insert record
		$this->CI->db->insert('acm_log', $log);
	}

	/**
	 * Saves an error log on database (table acm_log_error).
	 *
	 * @param string error_type
	 * @param string header
	 * @param string message
	 * @param string status_code
	 * @return void
	 */
	public function log_error($error_type = '', $header = '', $message = '', $status_code = '')
	{
		$this->CI =& get_instance();
		$this->CI->load->library('user_agent');

		// Log data
		$log['error_type'] = $error_type;
		$log['header'] = $header;
		$log['status_code'] = $status_code;
		$log['user_agent'] = $this->CI->agent->agent_string();
		$log['browser_name'] = $this->CI->agent->browser();
		$log['browser_version'] = $this->CI->agent->version();
		$log['device_name'] = $this->CI->agent->is_mobile()	? $this->CI->agent->mobile() : 'PC';
		$log['platform'] = $this->CI->agent->platform();
		$log['ip_address'] = $this->CI->input->ip_address();
		$log['message'] = $message;

		// Adjusts column
		if($this->CI->session->userdata('id_user') != '' && $this->CI->session->userdata('id_user') != 0)
			$log['id_user'] = $this->CI->session->userdata('id_user');

		if(is_array($message)) {
			$vars = json_encode($message, true);
			$log['message'] = $vars;
			$log['additional_data'] = $vars;
		}

		// Insert record
		$this->CI->db->insert('acm_log_error', $log);
	}
}