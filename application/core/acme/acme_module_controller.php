<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* ACME_Module_Controller
* 
* Application base controller. All other controllers must be extended by this one.
*
* Application module load flow from an URL:
* 
* 1) Check if session is valid
* 2) Try to locate the module on database through the class name in lower case
* 3) Load the module data from database to current object
* 4) Load module model
* 5) If is to call index() method, then the index method will be generate a HTML table with
*    SQL query list result
*
* @since	25/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACME_Module_Controller extends ACME_Core_Controller {
	
	public $id_module;
	public $controller; 		// module controller
	public $table_name;			// table name (only if the module has a table)
	public $label;				// module label
	public $url_img;			// module URL img 
	public $description;		// module description
	public $sql_list;			// SQL query list - when the default index() will be called 
								// then this query will be executed
	public $menus = array();	// module menus
	public $actions = array();	// module actions (each SQL query row will be receive an action)

	/**
	* __construct()
	* Class constructor. Receives the class name from module to be loaded.
	* @param string controller
	* @return object
	*/
	public function __construct($controller = '')
	{
		parent::__construct();
		
		// Check session
		$this->access->validate_session();
		
		// lower case on module name
		$this->controller = strtolower($controller);
		
		// Try to load module
		$this->_load_module();
	}
	
	/**
	* load_module()
	* Loads module data from database to current object.
	* @return void
	*/
	private function _load_module()
	{
		// Try to locate the module on database
		$module = $this->db->from('acm_module')
						   ->where(array('controller' => $this->controller))
						   ->get()
						   ->row_array(0);

		if(count($module) <= 0) {
			// There is no modules on database with this name
			$this->error->show_error(lang('Module not found'), lang('It was not possible to load the specified module. Make sure that the class name is the same registered on database.') . ' Classe: ' . $this->controller);			
			exit;
		}

		// Set current object attributes values
		$this->id_module = get_value($module, 'id_module');
		$this->label = lang(get_value($module, 'label'));
		$this->sql_list = get_value($module, 'sql_list');
		$this->url_img = tag_replace(get_value($module, 'url_img'));
		$this->description = get_value($module, 'description');
		$this->table_name = get_value($module, 'table_name');
		$this->menus = $this->db->get_where('acm_module_menu', array('id_module' => $this->id_module))->result_array();
		$this->actions = $this->db->get_where('acm_module_action', array('id_module' => $this->id_module))->result_array();
		
		// Load the module model
		$this->load->model($this->controller . '_model');

		// Load base model
		$this->load->model('core/acme_module_controller_model');
	}
	
	/**
	* validate_permission()
	* Validates a module permission for the given id user. Returns true in case
	* of having permission or show error permission page if user does not has this permission.
	* @param string permission
	* @param integer id_user
	* @return mixed has_permission
	*/
	public function validate_permission($permission = '', $id_user = 0)
	{
		return $this->access->validate_permission($this->controller, $permission, $id_user);
	}

	/**
	* check_permission()
	* Validates a permission for the given user id. Returns true or false.
	* @param string permission
	* @param integer id_user
	* @return boolean
	*/
	public function check_permission($permission = '', $id_user = 0)
	{
		return $this->access->check_permission($this->controller, $permission, $id_user);
	}
	
	/**
	* index()
	* Module index. Shows HTML table list with the result of SQL query ($this->sql_list)
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		if($this->sql_list != '') {
			
			// Run module query and turn into array
			$resultset = $this->db->query($this->sql_list)->result_array();
		
			// Build html table
			$table = $this->array_table->get_instance();
			$table->set_id( uniqid() );
			$table->set_data($resultset);
			
			// Add to each row of this table all actions of this module
			foreach($this->actions as $action)
				$table->add_column($this->template->load_html_component('module_action', array('action' => $action)));

			// Html table
			$args['module_table'] = $table->get_html();
		} else {
			$args['module_table'] = message('info', '', lang('This module has no SQL query.'));
		}
		
		// Load view
		$this->template->load_page('_acme/acme_module_controller/index', $args);
	}
	
	/**
	* form()
	* Builds form a single form of the given operation. The fields are got from database.
	* @param string operation		// insert, update, delete, view
	* @param integer pk_value
	* @return void
	*/
	public function form($operation = '', $pk_value = '')
	{
		// Test permission as form operation
		$this->validate_permission(strtoupper($operation));
		
		// adjust form operation
		$operation = strtolower($operation);

		// get pk name
		$pk = $this->acme_module_controller_model->get_pk_name($this->table_name);
		
		// Form data
		$form = $this->db->get_where('acm_module_form', array('id_module' => $this->id_module, 'operation' => $operation))->row_array(0);

		// Fields
		$fields = $this->db->from('acm_module_form_field f')
						   ->where('id_module_form = ' . get_value($form, 'id_module_form') . ' AND dtt_inative IS NULL')
						   ->order_by('order_')
						   ->get()
						   ->result_array();

		// Values
		if($pk == '' || $pk_value == '')
			$values = array();
		else
			$values = $this->db->get_where($this->table_name, array($pk => $pk_value))->row_array(0);

		// Case form operation is not insert, must validate pk given value
		if( ( $operation != 'insert' && count($values) <= 0 ) || get_value($form, 'dtt_inative') != '' || count($fields) <= 0)
			redirect($this->controller);

		// Adjust fields and put table name on each row
	   	$count = count($fields);
		for ($i = 0; $i < $count; $i++)
			$fields[$i]['table_name'] = $this->table_name;
		
		// Transform array values into html inputs
		$html_fields = $this->form->build_form_fields($fields, $values);
			
		// view args
		$args['form'] = $form;
		$args['html_fields'] = $html_fields;
		$args['fields'] = $fields;
		$args['values'] = $values;
		$args['operation'] = $operation;
		$args['pk_value'] = $pk_value;
			
		// Load view
		$this->template->load_page('_acme/acme_module_controller/form_' . $operation, $args);
	}
	
	/**
	* form_process()
	* Process html form module. Contemplates all 4 basic operations (insert, update, delete, view)
	* @return void
	*/
	public function form_process()
	{
		$operation = strtolower($this->input->post('operation'));
		
		$this->validate_permission(strtoupper($operation));
		
		// Call internal function that corresponds to _insert, _update, _view, _delete
		$this->{'_' . $operation}($this->input->post());
	}
	
	/**
	* _insert()
	* Process insert form. Receive POST data as parameter.
	* @param array post
	* @return void
	*/
	private function _insert($post = array())
	{
		if(count($post) > 0) {		
			
			// fields names in form must be table_name[field]
			$data = get_value($post, $this->table_name);

			// Insert data by the auxiliar model
			$this->acme_module_controller_model->insert($this->table_name, $data);

			// Log insert record
			$this->log->db_log(lang('Record insert'), 'insert', $this->table_name, $data);
		}
		
		redirect($this->controller);
	}
	
	/**
	* _update()
	* Process update form. Receive POST data as parameter.
	* @param array post
	* @return void
	*/
	private function _update($post = array())
	{
		if(count($post) > 0) {

			// fields names in form must be table_name[field]
			$data = get_value($post, $this->table_name);

			// get pk name and value
			$pk = $this->acme_module_controller_model->get_pk_name($this->table_name);
			$pk_value = $this->input->post('pk_value');

			// old data to log it
			$old_data = $this->db->get_where($this->table_name, array($pk => $pk_value))->row_array(0);

			// build array for update
			$where[$pk] = $pk_value;

			// Update data by the auxiliar model
			$this->acme_module_controller_model->update($this->table_name, $data, $where);
			
			// Log update record
			$this->log->db_log(lang('Record update'), 'update', $this->table_name, array_merge(array('new_data' => $data), array('old_data' => $old_data)));
		}
		
		redirect($this->controller);
	}
	
	/**
	* _delete()
	* Process delete form. Receive POST data as parameter.
	* @param array post
	* @return void
	*/
	private function _delete($post = array())
	{
		if(count($post) > 0) {			
			
			// load correct model
			$this->load->model('core/acme_module_controller_model');

			// get pk name and value
			$pk = $this->acme_module_controller_model->get_pk_name($this->table_name);
			$pk_value = $this->input->post('pk_value');

			// old data to log
			$old_data = $this->db->get_where($this->table_name, array($pk => $pk_value))->row_array(0);
			
			// log delete
			$this->log->db_log(lang('Record delete'), 'delete', $this->table_name, $old_data);

			// Removes
			$this->db->delete($this->table_name, array($pk => $pk_value));
		}
		
		redirect($this->controller);
	}
	
	/**
	* _view()
	* Process view form. Receive POST data as parameter.
	* @param array post
	* @return void
	*/
	private function _view($post = array())
	{
		redirect($this->controller);
	}
}
