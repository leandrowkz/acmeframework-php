<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Log
* 
* Application logs module. Manage logs and error logs.
*
* @since 	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Log extends ACME_Module_Controller {
	
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
	* Show logs - logs list page.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');

		// get all logs
		$args['logs'] = $this->app_log_model->get_all_logs();

		// load views
		$this->template->load_page('_acme/app_log/index', $args);
	}

	/**
	* save()
	* Insert, update and delete for logs. Fowarded by logs module by ajax. Log type 
	* and operation must be sent as parameter and data by $_POST. Print json as result 
	* operation status.
	* @param string type 		// activity, error
	* @param string operation	// insert, update, delete, delete-all
	* @return void
	*/
	public function save($type = 'activity', $operation = '')
	{
		$permission = strtolower($operation) == 'delete-all' ? 'delete' : $operation;

		if( ! $this->check_permission(strtoupper($permission))) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {

			case 'delete';
			case 'delete-all';

				// adjust table and id
				if(strtolower($type) == 'activity') {
					$table = 'acm_log';
					$column = 'id_log';
				} else {
					$table = 'acm_log_error';
					$column = 'id_log_error';
				}

				if(strtolower($operation) == 'delete')
					$this->db->delete($table, array($column => $this->input->post('id_log')));
				elseif(strtolower($operation) == 'delete-all')
					$this->db->delete($table, array('1' => '1'));

			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}
}
