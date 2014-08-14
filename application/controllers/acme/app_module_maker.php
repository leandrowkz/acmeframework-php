<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Module_Maker
* 
* Application module maker. Build other modules with this module.
*
* @since 	15/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Module_Maker extends ACME_Module_Controller {
	
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
	* Module index. Redirect for new module page.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');

		// redirect to new module
		redirect('app_module_maker/new_module');
	}


	/**
	* new_module()
	* Module index. Show page for creating a new module.
	* @param boolean process
	* @return void
	*/
	public function new_module($process = false)
	{
		$this->validate_permission('CREATE_MODULE');

		$path_permissions = $this->_check_path_permissions();

		$timezone = $this->_check_timezone();

		if( ! $process)
		{
			// load all groups
			$groups = $this->db->select('id_user_group AS id, name')->from('acm_user_group')->order_by('name')->get()->result_array();

			// build group options
			$args['groups'] = json_encode(array('results' => array_change_key_case_recursive($groups, CASE_LOWER)));

			// check permissions for all paths
			$args['path_permissions'] = $path_permissions;

			// timezone
			$args['timezone'] = $timezone;

			// Load view
			$this->template->load_page('_acme/app_module_maker/new_module', $args);
		} else {

			// set time process to zero
			set_time_limit(0);			

			// controller used as a key
			$controller = strtolower($this->input->post('controller'));

			// Check if module already exist
			if( count($this->db->get_where('acm_module', array('controller' => $controller))->row_array(0)) > 0 )
				redirect('app_module_maker/new_module');

			// get table name
			$table = $this->input->post('table_name');

			// Start building a new module!
			$module['def_file'] = json_encode($this->input->post());
			$module['table_name'] = $table;
			$module['controller'] = $controller;
			$module['label'] = $this->input->post('label');
			$module['description'] = $this->input->post('description');
			$module['sql_list'] = $this->input->post('sql_list');
			$module['url_img'] = $this->input->post('url_img');

			$this->db->trans_start();

			// Insert a module
			$this->db->insert('acm_module', $module);

			// get the module from db now
			$module = $this->db->from('acm_module')->where(array('controller' => $controller))->get()->row_array(0);

			// catch id_module now
			$id_module = get_value($module, 'id_module');

			// check if table exists
			$table_exist = false;
			foreach ($this->db->list_tables() as $idx => $db_table)
				if ( strtolower($table) == strtolower($db_table) ) 
				{
					$table_exist = true;
					break;
				}

			// create forms, menus, actions and permissions
			// only if table name was set
			$forms = $this->input->post('forms') == '' ? array() : $this->input->post('forms'); 
			if( $table_exist )
				foreach ($forms as $operation)
				{
					$form = array();
					$form['id_module'] = $id_module;
					$form['operation'] = $operation;

					// Create form
					$this->db->insert('acm_module_form', $form);

					// Get form from db
					$form = $this->db->from('acm_module_form')->where(array('id_module' => $id_module, 'operation' => $operation))
									 ->get()
									 ->row_array(0);

					// now form id
					$id_form = get_value($form, 'id_module_form');

					// table fields meta-data
					$fields = $this->db->field_data($table);
				
					// loop fields until find correct column
					foreach ($fields as $field)
					{
						// build field to insert on acm_module_form_field
						$field_data = $this->form->build_field($field, $table);
						$field_data['id_module_form'] = $id_form;

						// Loop fields to insert
						foreach($field_data as $index => $value)
						{
							$escape = ($value != 'NULL') ? true : false;
							$this->db->set($index, $value, $escape);
						}
						
						// Insert it!
						$this->db->insert('acm_module_form_field');
					}

					// and also for each form we have to create menus, permissions and actions
					$data['id_module'] = $id_module;
					$data['label'] = lang(ucwords($operation));
					$data['link'] = $operation == 'insert' ? '{URL_ROOT}/' . $controller . '/form/' . $operation : '{URL_ROOT}/' . $controller . '/form/' . $operation . '/{0}';

					// now permission
					$permission['id_module'] = $id_module;
					$permission['label'] = lang(ucwords($operation) . ' form');
					$permission['permission'] = strtoupper($operation);
					
					// adjust table name
					$table_ins = $operation == 'insert' ? 'acm_module_menu' : 'acm_module_action';

					// do it!
					$this->db->insert($table_ins, $data);
					$this->db->insert('acm_module_permission', $permission);

				}

			// insert one more permission for entering
			$permission['id_module'] = $id_module;
			$permission['permission'] = 'ENTER';
			$permission['label'] = lang('Module entrance');

			$this->db->insert('acm_module_permission', $permission);

			// automatically gives all permissions for the user creator
			$permissions = $this->db->get_where('acm_module_permission', array('id_module' => $id_module))->result_array(0);

			foreach($permissions as $module_permission)
			{
				$usr_permission['id_user'] = $this->session->userdata('id_user');
				$usr_permission['id_module_permission'] = get_value($module_permission, 'id_module_permission');
				$this->db->insert('acm_user_permission', $usr_permission);
			}

			// now create menus for application for all groups matched
			$groups = $this->input->post('menu_groups') == '' ? array() : $this->input->post('menu_groups'); 
			$menu['link'] = '{URL_ROOT}/' . $controller;
			foreach ($groups as $group)
			{
				$menu['id_user_group'] = $group;
				$menu['label'] = ucwords( $this->input->post('label') );

				$this->db->insert('acm_menu', $menu);
			}

			// and finally, create all files needed
			// controller
			$file_controller = file_get_contents('application/core/acme/engine_files/maker_template_controller.php');
			$file_controller = str_replace('<CLASS_NAME>', $controller, $file_controller);
			$file_controller = str_replace('<DESCRIPTION>', $this->input->post('description'), $file_controller);
			$file_controller = str_replace('<CREATION_DATE>', date('d/m/Y'), $file_controller);
			$file_controller = str_replace('<AUTHOR>', $this->session->userdata('email'), $file_controller);
			file_put_contents('application/controllers/' . $controller . '.php', $file_controller);
			
			// Model
			$file_model = file_get_contents('application/core/acme/engine_files/maker_template_model.php');
			$file_model = str_replace('<CLASS_NAME>', $controller, $file_model);
			$file_model = str_replace('<DESCRIPTION>', $this->input->post('description'), $file_model);
			$file_model = str_replace('<CREATION_DATE>', date('d/m/Y'), $file_model);
			$file_model = str_replace('<AUTHOR>', $this->session->userdata('email'), $file_model);
			file_put_contents('application/models/' . $controller . '_model.php', $file_model);
			
			// View
			@mkdir('application/views/' . TEMPLATE . '/' . $controller);

			// complete all transaction
			$this->db->trans_complete();

			// build args for view
			$args['module'] = $module;
			$args['link'] = $menu['link'];

			// Load view
			$this->template->load_page('_acme/app_module_maker/new_module_success', $args);
		}
	}

	/**
	* check_controller()
	* Check if a module with the given controller already exist. The controller
	* name must be forwarded by POST. Print a json as return.
	* @return void
	*/
	public function check_controller()
	{
		$controller = strtolower($this->input->post('controller'));

		if( $this->db->get_where('acm_module', array('controller' => $controller))->num_rows() > 0)
			echo json_encode(array('return' => true));
		else
			echo json_encode(array('return' => false));
	}

	/**
	* _check_path_permissions()
	* Check permissions for needed paths:
	* 	-> application/controllers
	* 	-> application/models
	* 	-> application/views
	* Returns true or false in case of doesnt has permissions for write.
	* @return boolean has-permissions
	*/
	private function _check_path_permissions()
	{
		if ( is_writable('application/controllers') 
			 && is_writable('application/models')
			 && is_writable('application/views') 
			 && is_readable('application/core/acme/engine_files/maker_template_model.php')
			 && is_readable('application/core/acme/engine_files/maker_template_controller.php')
		   )
			return true;
		else
			return false;
	}

	/**
	* _check_timezone()
	* Check value for php.ini setting date.timezone.
	* @return boolean is_set
	*/
	private function _check_timezone()
	{
		if ( ini_get('date.timezone') != false )
			return true;
		else
			return false;
	}
}
