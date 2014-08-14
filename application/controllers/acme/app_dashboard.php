<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Dashboard
* 
* Application default dashboard.
*
* @since	15/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Dashboard extends ACME_Module_Controller {

	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	* index()
	* Dashboard page.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('VIEW_DASHBOARD');
		
		// App modules
		$args['modules'] = $this->db->from('acm_module')->order_by('label')->get()->result_array();

		// Devices
		$args['devices'] = $this->db->select('device_name, device_version, count(*) as count_access')
									->from('acm_log')
									->where(array('action' => 'login'))
									->group_by('device_name, device_version')
									->order_by('count(*) DESC, device_name')
									->get()
									->result_array();

		// browser ranking
		$args['browsers'] = $this->db->select('browser_name, browser_version, count(*) as count_access')
									 ->from('acm_log')
									 ->where(array('action' => 'login'))
									 ->group_by('browser_name, browser_version')
									 ->order_by('count(*) DESC, browser_name')
									 ->get()
									 ->result_array();

		// error tracker - general errors
		$args['general_errors'] = $this->db->from('acm_log_error')
										   ->where(array('error_type' => 'error_general'))
								   	  	   ->order_by('log_dtt_ins desc')
								   		   ->get()
								   		   ->result_array();

		// error tracker - php errors
		$args['php_errors'] = $this->db->from('acm_log_error')
									   ->where(array('error_type' => 'error_php'))
								   	   ->order_by('log_dtt_ins desc')
									   ->get()
							   		   ->result_array();

		// error tracker - db errors
		$args['db_errors'] = $this->db->from('acm_log_error')
									   ->where(array('error_type' => 'error_db'))
								   	   ->order_by('log_dtt_ins desc')
									   ->get()
							   		   ->result_array();

		// Load view
		$this->template->load_page('_acme/app_dashboard/index', $args);
	}
}
