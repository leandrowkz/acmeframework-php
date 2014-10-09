<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
* 
* Controller App_Module_Manager
* 
* Application module manager. Manage all modules with this one.
*
* @since 	12/02/2013
*
* --------------------------------------------------------------------------------------------------
*/
class App_Module_Manager  extends ACME_Module_Controller {

	// This attribute prevents these permissions to be deleted
	private $protected_permissions = array(
		
		'app_user' => array('ENTER', 'PERMISSION_MANAGER'),
		
		'app_module_manager' => array('ENTER', 'CONFIG')
									 
	);
	
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
	* Module index. Show all application modules.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		// app modules
		$args['modules'] = $this->db->from('acm_module')->order_by('label')->get()->result_array();
		
		// Load view
		$this->template->load_page('_acme/app_module_manager/index', $args);
	}

	/**
	* config()
	* Module config page.
	* @param int id_module
	* @return void
	*/
	public function config($id_module = 0)
	{
		$this->validate_permission('CONFIG');
		
		// module info
		$module = $this->db->from('acm_module')->where(array('id_module' => $id_module))->get()->row_array(0);
		
		// Basic check if module exist
		if( count($module) <= 0 )
			redirect('app_module_manager');
		
		// Load view
		$this->template->load_page('_acme/app_module_manager/config', array('module' => $module));
	}

	/**
	* edit()
	* Edit module form page.
	* @param int id_module
	* @return void
	*/
	public function edit($id_module = 0, $process = false)
	{
		$this->validate_permission('CONFIG');
		
		// Edit page
		if( ! $process) {
			
			// module info
			$module = $this->db->from('acm_module')->where(array('id_module' => $id_module))->get()->row_array(0);

			// basic check if module exist
			if( count($module) <= 0 )
				redirect('app_module_manager');

			// Load view
			$this->template->load_page('_acme/app_module_manager/edit', array('module' => $module));
		} else {

			// Proccess update form
			$data['label'] = $this->input->post('label');
			$data['description'] = $this->input->post('description');
			$data['table_name'] = $this->input->post('table_name');
			$data['url_img'] = $this->input->post('url_img');
			$data['sql_list'] = $this->input->post('sql_list');

			// Update it!
			$this->db->update('acm_module', $data, array('id_module' => $id_module ));

			// redirect to config page
			redirect('app_module_manager/config/' . $id_module);
		}
	}

	/**
	* load_area()
	* Load specific area as permissions, menus, forms, etc.
	* @param string area 	// permissions, menus, actions, form-view, form-insert, form-update
	* @param int id_module
	* @return void
	*/
	public function load_area($area = '', $id_module = 0)
	{
		$this->validate_permission('CONFIG');

		switch(strtolower($area)) {

			default:
			case 'permissions':
				$args['permissions'] = $this->db->from('acm_module_permission')
												->where(array('id_module' => $id_module))
												->order_by('id_module_permission desc')
												->get()
												->result_array();
			break;

			case 'menus':
				$args['menus'] = $this->db->from('acm_module_menu')
										  ->where(array('id_module' => $id_module))
										  ->order_by('id_module_menu desc')
										  ->get()
										  ->result_array();
			break;

			case 'actions':
				$args['actions'] = $this->db->from('acm_module_action')
										 	->where(array('id_module' => $id_module))
											->order_by('id_module_action desc')
											->get()
											->result_array();
			break;

			case 'form-view':
			case 'form-insert':
			case 'form-update':
			case 'form-delete':
				// get correct operation
				$operation = str_replace('form-', '', $area);

				// module data
				$module = $this->db->get_where('acm_module', array('id_module' => $id_module))->row_array(0);

				// verify if form exist
				$form = $this->db->get_where('acm_module_form', array('id_module' => $id_module, 'operation' => $operation))->row_array(0);

				// attempt to create it if does not exist
				if( count($form) <= 0 ) {
					$this->db->set('id_module', $id_module);
					$this->db->set('operation', $operation);
					$this->db->set('dtt_inative', 'CURRENT_TIMESTAMP', false);
					$this->db->insert('acm_module_form');
					$form = $this->db->get_where('acm_module_form', array('id_module' => $id_module, 'operation' => $operation))->row_array(0);
				}

				// get fields
				$id_form = get_value($form, 'id_module_form');
				$table = get_value($module, 'table_name');
				$fields = $this->app_module_manager_model->get_form_fields($id_form, $table);

				// menu/action that points to form
				if ($operation == 'insert')
					$args['menu'] = $this->db->get_where('acm_module_menu', "link LIKE '%/form/insert%' AND id_module = $id_module")->row_array(0);
				else
					$args['action'] = $this->db->get_where('acm_module_action', "link LIKE '%/form/$operation%' AND id_module = $id_module")->row_array(0);

				// vars to view (only for forms)
				$args['form'] = $form;
				$args['fields'] = $fields;
				$args['module'] = $module;

			break;
		}

		// vars to view (to all areas)
		$args['id_module'] = $id_module;

		// Load view layer
		$this->template->load_page('_acme/app_module_manager/area_' . strtolower($area), $args, false, false);
	}

	/**
	* save_permission()
	* Insert, update and delete for permissions. Fowarded by config page, through ajax. Operation must
	* be sent as parameter and data by $_POST. Print json as result operation status.
	* @param string operation		// insert, update, delete
	* @return void
	*/
	public function save_permission($operation = '')
	{
		if( ! $this->check_permission('CONFIG')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {
			
			case 'insert':
			case 'update':
			
				$data['id_module'] = $this->input->post('id_module');
				$data['label'] = $this->input->post('label');
				$data['permission'] = $this->input->post('permission');
				$data['description'] = $this->input->post('description');

				if( strtolower($operation) == 'insert' )
					$this->db->insert('acm_module_permission', $data);
				else 
					$this->db->update('acm_module_permission', $data, array('id_module_permission' => $this->input->post('id_module_permission')));

			break;

			case 'delete':

				$id_module_permission = $this->input->post('id_module_permission');

				// Prevents user from delete some important permissions
				// ENTER users, manage PERMISSIONS
				// Gets permission data
				$permission = $this->db->from('acm_module_permission mp')
									   ->join('acm_module m', 'm.id_module = mp.id_module')
									   ->where( array('id_module_permission' => $id_module_permission) )
									   ->get()
									   ->row_array(0);

				$module = get_value($permission, 'controller');
				$permission_name = get_value($permission, 'permission');
				$protected_permissions = $this->protected_permissions;

				// Tests if module has protected permissions
				if ( array_key_exists( $module, $protected_permissions) ) {

					if ( in_array( $permission_name, $protected_permissions[$module] ) ) {
						
						echo json_encode( array('return' => false, 'error' => lang('Ops! You cannot delete this permission. For security reasons this permission must be always enabled.')) );
						return;
					}
				}

				$this->db->delete('acm_user_permission', array('id_module_permission' => $id_module_permission) );
				$this->db->delete('acm_module_permission', array('id_module_permission' => $id_module_permission) );

			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	* save_menu()
	* Insert, update and delete for module menus. Fowarded by config page, through ajax. Operation must
	* be sent as parameter and data by $_POST. Print json as result operation status.
	* @param string operation		// insert, update, delete
	* @return void
	*/
	public function save_menu($operation = '')
	{
		if( ! $this->check_permission('CONFIG')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {
			
			// create an insert menu
			case 'enable-menu-form-insert':

				// post data and module data
				$id_module = $this->input->post('id_module');
				$module = $this->db->get_where('acm_module', array('id_module' => $id_module))->row_array(0);
				
				$data['id_module'] = $id_module;
				$data['link'] = '{URL_ROOT}/' . get_value($module, 'controller') . '/form/insert';
				$data['label'] = lang('Insert');
				$data['order_'] = 10;
				$this->db->insert('acm_module_menu', $data);
				
			break;
			
			// drop any menu insert
			case 'disable-menu-form-insert':
				$this->db->delete('acm_module_menu', "link LIKE '%/form/insert%' AND id_module = " . $this->input->post('id_module'));
			break;

			case 'insert':
			case 'update':
				
				$data['id_module'] = $this->input->post('id_module');
				$data['label'] = $this->input->post('label');
				$data['link'] = $this->input->post('link');
				$data['target'] = $this->input->post('target');
				$data['url_img'] = $this->input->post('url_img');
				$data['order_'] = $this->input->post('order_') == '' ? 10 : $this->input->post('order_');

				// update, remove or insert
				if( strtolower($operation) == 'insert' )
					$this->db->insert('acm_module_menu', $data);
				else
					$this->db->update('acm_module_menu', $data, array('id_module_menu' => $this->input->post('id_module_menu')));

			break;

			case 'delete':
				$this->db->delete('acm_module_menu', array('id_module_menu' => $this->input->post('id_module_menu')));
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	* save_action()
	* Insert, update and delete for module actions. Fowarded by config page, through ajax. Operation must
	* be sent as parameter and data by $_POST. Print json as result operation status.
	* @param string operation		// insert, update, delete
	* @return void
	*/
	public function save_action($operation = '')
	{
		if( ! $this->check_permission('CONFIG')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {
			
			// enable form action maybe action doesnt exist
			case 'enable-action-form-view':
			case 'enable-action-form-update':
			case 'enable-action-form-delete':

				$action = str_replace('enable-action-form-', '', strtolower($operation));	// gets edit, view, delete

				// post data and module data
				$id_module = $this->input->post('id_module');
				$module = $this->db->get_where('acm_module', array('id_module' => $id_module))->row_array(0);
				
				$data['id_module'] = $id_module;
				$data['link'] = '{URL_ROOT}/' . get_value($module, 'controller') . '/form/' . $action . '/{0}';
				$data['label'] = lang(ucwords($action));
				$data['order_'] = 10;
				$this->db->insert('acm_module_action', $data);
				
			break;
			
			// drop any menu insert
			case 'disable-action-form-view':
			case 'disable-action-form-update':
			case 'disable-action-form-delete':
				$action = str_replace('disable-action-form-', '', strtolower($operation));	// gets edit, view, delete
				$this->db->delete('acm_module_action', "link LIKE '%/form/" . $action . "%' AND id_module = " . $this->input->post('id_module'));
			break;

			case 'insert':
			case 'update':
				
				// values from post
				$data['id_module'] = $this->input->post('id_module');
				$data['label'] = $this->input->post('label');
				$data['link'] = $this->input->post('link');
				$data['target'] = $this->input->post('target');
				$data['url_img'] = $this->input->post('url_img');
				$data['order_'] = $this->input->post('order_') == '' ? 10 : $this->input->post('order_');

				// update, remove or insert
				if(strtolower($operation) == 'insert') {
					$this->db->insert('acm_module_action', $data);
				} else
					$this->db->update('acm_module_action', $data, array('id_module_action' => $this->input->post('id_module_action')));

			break;

			case 'delete':
				$this->db->delete('acm_module_action', array('id_module_action' => $this->input->post('id_module_action')));
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	

	/**
	* save_form()
	* Enable and save form data. Triggered on form area.
	* @param string operation 	// update, enable, disable
	* @return void
	*/
	public function save_form($operation = '')
	{
		if( ! $this->check_permission('CONFIG')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {
			
			case 'enable':
			case 'disable':

				// Check if a permission with same operation already exists
				if(strtolower($operation) == 'enable') {

					$where = array('id_module_form' => $this->input->post('id_module_form'));

					$module = $this->db->get_where('acm_module_form', $where)->row_array(0);

					$data['id_module'] = get_value($module, 'id_module');
					$data['permission'] = strtoupper(get_value($module, 'operation'));

					$permission = $this->db->get_where('acm_module_permission', $data)->row_array(0);

					// if there is no permission for the given form then create it
					if(count($permission) <= 0) {

						$data['label'] = ucwords(get_value($module, 'operation')) . ' form';
						
						$this->db->insert('acm_module_permission', $data);
					}

				}

				// check if is disable
				$dtt_inative = ( strtolower($operation) == 'disable' ) ? 'CURRENT_TIMESTAMP' : 'NULL';

				// update field
				$this->db->set('dtt_inative', $dtt_inative, false);
				$this->db->where(array('id_module_form' => $this->input->post('id_module_form')));
				$this->db->update('acm_module_form');

			break;

			case 'update':
				// data from post
				$upd['action'] = $this->input->post('action');
				$upd['method'] = $this->input->post('method');
				$upd['enctype'] = $this->input->post('enctype');

				// update it
				$this->db->update('acm_module_form', $upd, array('id_module_form' => $this->input->post('id_module_form')));
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	* save_form_field()
	* Habilita um campo de formulario. Disparado da tela de config de form.
	* @param string operation 	// update, enable, disable
	* @return void
	*/
	public function save_form_field($operation = '')
	{
		if( ! $this->check_permission('CONFIG')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {
			
			case 'enable':
			case 'disable':

				// values from post!
				$id_form = $this->input->post('id_module_form');
				$column_name = $this->input->post('column_name');

				// now verify if field already exist
				$field = $this->db->get_where('acm_module_form_field', array('id_module_form' => $id_form, 'table_column' => $column_name))->row_array(0);

				// attempt to create field
				if( count($field) <= 0 ) {

					// get form data, to get module data, to get table name :)
					$form = $this->db->get_where('acm_module_form', array('id_module_form' => $id_form))->row_array(0);
					$module = $this->db->get_where('acm_module', array('id_module' => get_value($form, 'id_module')))->row_array(0);
					$table = get_value($module, 'table_name');
				
					// table fields meta-data
					$fields = $this->db->field_data($table);
				
					// loop fields until find correct column
					foreach ($fields as $field)
					{
						if( strtolower($field->name) == strtolower($column_name) )
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
							break;
						}
					}

					// get value again
					$field = $this->db->get_where('acm_module_form_field', array('id_module_form' => $id_form, 'table_column' => $column_name))->row_array(0);
				}
				
				// check if is disable
				$dtt_inative = ( strtolower($operation) == 'disable' ) ? 'CURRENT_TIMESTAMP' : 'NULL';

				// update field
				$this->db->set('dtt_inative', $dtt_inative, false);
				$this->db->where(array('id_module_form_field' => get_value($field, 'id_module_form_field')));
				$this->db->update('acm_module_form_field');
			break;

			case 'update':
				$upd['label'] = $this->input->post('label');
				$upd['table_column'] = $this->input->post('table_column');
				$upd['type'] = $this->input->post('type');
				$upd['order_'] = $this->input->post('order_') == '' ? 10 : $this->input->post('order_');
				$upd['description'] = $this->input->post('description');
				$upd['id_html'] = $this->input->post('id_html');
				$upd['class_html'] = $this->input->post('class_html');
				$upd['style'] = $this->input->post('style');
				$upd['maxlength'] = $this->input->post('maxlength');
				$upd['options_json'] = $this->input->post('options_json');
				$upd['options_sql'] = $this->input->post('options_sql');
				$upd['javascript'] = $this->input->post('javascript');
				$upd['masks'] = $this->input->post('masks');
				$upd['validations'] = $this->input->post('validations');

				// update it
				$this->db->update('acm_module_form_field', $upd, array('id_module_form_field' => $this->input->post('id_module_form_field')));
			break;

		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}
	
}
