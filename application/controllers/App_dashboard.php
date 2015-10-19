<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller App_dashboard
 *
 * Application default dashboard.
 *
 * @since	15/10/2012
 * --------------------------------------------------------------------------------------------------
 */
class App_dashboard extends ACME_Controller {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Dashboard page.
	 *
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

		// Browser ranking
		$args['browsers'] = $this->db->select('browser_name, browser_version, count(*) as count_access')
									 ->from('acm_log')
									 ->where(array('action' => 'login'))
									 ->group_by('browser_name, browser_version')
									 ->order_by('count(*) DESC, browser_name')
									 ->get()
									 ->result_array();

		// Error tracker - general errors
		$args['general_errors'] = $this->db->from('acm_log_error')
										   ->where(array('error_type' => 'error-general'))
								   	  	   ->order_by('log_dtt_ins desc')
								   		   ->get()
								   		   ->result_array();

		// Error tracker - php errors
		$args['php_errors'] = $this->db->from('acm_log_error')
									   ->where(array('error_type' => 'error-php'))
								   	   ->order_by('log_dtt_ins desc')
									   ->get()
							   		   ->result_array();

		// Error tracker - db errors
		$args['db_errors'] = $this->db->from('acm_log_error')
									   ->where(array('error_type' => 'error-db'))
								   	   ->order_by('log_dtt_ins desc')
									   ->get()
							   		   ->result_array();

		// Load view
		$this->template->load_view( $this->controller . '/index', $args );
	}
}
