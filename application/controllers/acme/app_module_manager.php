<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
* 
* Controller App_Module_Manager
* 
* Gerenciador dos módulos da aplicação.
*
* @since 	12/02/2013
*
* --------------------------------------------------------------------------------------------------
*/
class App_Module_Manager  extends ACME_Module_Controller {
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	* index()
	* Entrada do módulo.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		// Módulos da app
		$args['modules'] = $this->db->from('acm_module')->order_by('label')->get()->result_array();
		
		// Carrega camada de visualização
		$this->template->load_page('_acme/app_module_manager/index', $args);
	}

	/**
	* config()
	* Configurações de módulo.
	* @param int id_module
	* @return void
	*/
	public function config($id_module = 0)
	{
		$this->validate_permission('CONFIG');
		
		// Dados do modulo
		$module = $this->db->from('acm_module')->where(array('id_module' => $id_module))->get()->result_array();
		$args['module'] = isset($module[0]) ? $module[0] : array();
		
		// Carrega camada de visualização
		$this->template->load_page('_acme/app_module_manager/config', $args);
	}

	/**
	* edit()
	* Tela de edição de dados de módulo. Processa tela de edição também.
	* @param int id_module
	* @return void
	*/
	public function edit($id_module = 0, $process = false)
	{
		$this->validate_permission('CONFIG');
		
		// Tela de edição
		if( ! $process) {
			
			// Dados do modulo
			$module = $this->db->from('acm_module')->where(array('id_module' => $id_module))->get()->result_array();
			$args['module'] = isset($module[0]) ? $module[0] : array();

			// Carrega camada de visualização
			$this->template->load_page('_acme/app_module_manager/edit', $args);
		} else {

			// Proccess update form
			$data['label'] = $this->input->post('label');
			$data['description'] = $this->input->post('description');
			$data['table_name'] = $this->input->post('table_name');
			$data['sql_list'] = $this->input->post('sql_list');

			// Update it!
			$this->db->update('acm_module', $data, array('id_module' => $id_module ));

			// redirect to config page
			redirect('app_module_manager/config/' . $id_module);
		}
	}

	/**
	* load_area()
	* Carrega especifica na tela de configuração de modulo.
	* @param string area
	* @param int id_module
	* @return void
	*/
	public function load_area($area = '', $id_module = 0)
	{
		$this->validate_permission('CONFIG');

		// Carrega tabela conforme parametro
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

			case 'form-insert':
			case 'form-edit':
			case 'form-delete':
			case 'form-view':
				$args['forms'] = $this->db->from('acm_module_form')
										  ->where(array('id_module' => $id_module))
										  ->order_by('id_module_form desc')
										  ->get()
										  ->result_array();
			break;
		}

		$args['id_module'] = $id_module;

		// Carrega camada de visualização
		$this->template->load_page('_acme/app_module_manager/area_' . strtolower($area), $args, false, false);
	}

	/**
	* save_permission()
	* Salva permissão encaminhada pelo form de permissoes na tela de config de modulo, via ajax.
	* @param int id_permission
	* @param boolean remove
	* @return void
	*/
	public function save_permission($id_permission = 0, $remove = false)
	{
		if($this->check_permission('CONFIG')) {
			
			// values
			$data['label'] = $this->input->post('label');
			$data['permission'] = $this->input->post('permission');

			// insert values
			if($this->input->post('id_module') != '')
				$data['id_module'] = $this->input->post('id_module');

			if($this->input->post('description') != '')
				$data['description'] = $this->input->post('description');

			// update, remove or insert
			if($id_permission == '' || $id_permission == 0)
				$this->db->insert('acm_module_permission', $data);
			elseif ($remove)
				$this->db->delete('acm_module_permission', array('id_module_permission' => $id_permission));
			else
				$this->db->update('acm_module_permission', $data, array('id_module_permission' => $id_permission));
			
			// Return
			$return = array('return' => true);
		} else {
			$return = array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso'));
		}

		// Adorable return!
		echo json_encode($return);
	}

	/**
	* save_action()
	* Salva ação encaminhada pelo form de ações na tela de config de modulo, via ajax.
	* @param int id_action
	* @param boolean remove
	* @return void
	*/
	public function save_action($id_action = 0, $remove = false)
	{
		if($this->check_permission('CONFIG')) {
			
			// values
			$data['label'] = $this->input->post('label');
			$data['link'] = $this->input->post('link');
			$data['target'] = $this->input->post('target');
			$data['url_img'] = $this->input->post('url_img');
			$data['order_'] = $this->input->post('order_');

			// insert values
			if($this->input->post('id_module') != '')
				$data['id_module'] = $this->input->post('id_module');

			// update, remove or insert
			if($id_action == '' || $id_action == 0)
				$this->db->insert('acm_module_action', $data);
			elseif ($remove)
				$this->db->delete('acm_module_action', array('id_module_action' => $id_action));
			else
				$this->db->update('acm_module_action', $data, array('id_module_action' => $id_action));
			
			// Return
			$return = array('return' => true);
		} else {
			$return = array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso'));
		}

		// Adorable return!
		echo json_encode($return);
	}

	/**
	* save_menu()
	* Salva menu encaminhado pelo form de menus na tela de config de modulo, via ajax.
	* @param int id_menu
	* @param boolean remove
	* @return void
	*/
	public function save_menu($id_menu = 0, $remove = false)
	{
		if($this->check_permission('CONFIG')) {
			
			// values
			$data['label'] = $this->input->post('label');
			$data['link'] = $this->input->post('link');
			$data['target'] = $this->input->post('target');
			$data['url_img'] = $this->input->post('url_img');
			$data['order_'] = $this->input->post('order_');

			// insert values
			if($this->input->post('id_module') != '')
				$data['id_module'] = $this->input->post('id_module');

			// update, remove or insert
			if($id_menu == '' || $id_menu == 0)
				$this->db->insert('acm_module_menu', $data);
			elseif ($remove)
				$this->db->delete('acm_module_menu', array('id_module_menu' => $id_menu));
			else
				$this->db->update('acm_module_menu', $data, array('id_module_menu' => $id_menu));
			
			// Return
			$return = array('return' => true);
		} else {
			$return = array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso'));
		}

		// Adorable return!
		echo json_encode($return);
	}
	
	/**
	* config_forms()
	* Página de configurações de formulários de módulos. Nesta página o usuário desenvolvedor
	* define quais formulários-padrão o módulo poderá ou não utilizar.
	* @param integer id_module
	* @return void
	*/
	public function config_forms($id_module = 0)
	{
		if($this->validation->is_integer_($id_module))
		{
			$this->validate_permission('CONFIG_FORMS');
			
			// Dados do modulo
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			
			// Verifica existência da tabela e sql (filtros e outros forms)
			$args['module'] = $module;
			$args['table_name'] = get_value($module, 'table_name');
			$args['sql_list'] = get_value($module, 'sql_list');
			$args['id_module'] = $id_module;
			
			$this->template->load_page('_acme/acme_module_manager/config_forms', $args);
		} else {
			redirect('acme_module_manager');
		}
	}
	
	/**
	* ajax_config_form()
	* Carrega o bloco html do formulario com base na operacao encaminhada.
	* @param string operation
	* @param int id_module
	* @return void
	*/
	public function ajax_config_form($operation = '', $id_module = 0)
	{
		// Função interna
		$this->{'_ajax_config_form_'. $operation}($id_module);
	}
	
	/**
	* _ajax_config_form_filter()
	* Bloco html carregado via ajax que preenche box de configurações de formulário de filtros. É 
	* acionado quando existe o clique na aba de formulário de filtros, na página de configurações
	* de formulários (action: config_forms).
	* @param integer id_module
	* @return void
	*/
	public function _ajax_config_form_filter($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, 'filter');
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table, true);
			
			// Variaveis para view
			$args['module'] = $module;
			$args['form'] = $form;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_filter', $args, false, false);
		}
	}
	
	/**
	* _ajax_config_form_insert()
	* Bloco html carregado via ajax que preenche box de configurações de formulário de inserção. É 
	* acionado quando existe o clique na aba de formulário de inserção, na página de configurações
	* de formulários (action: config_forms).
	* @param integer id_module
	* @return void
	*/
	public function _ajax_config_form_insert($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Dados do menu
			$menu = $this->acme_module_manager_model->get_module_menu_insert($id_module, get_value($module, 'controller') . '/form/insert');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, 'insert');
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table);
			
			// Variaveis para view
			$args['module'] = $module;
			$args['menu'] = $menu;
			$args['form'] = $form;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_insert', $args, false, false);
		}
	}
	
	/**
	* _ajax_config_form_update()
	* Bloco html carregado via ajax que preenche box de configurações de formulário de edição. É 
	* acionado quando existe o clique na aba de formulário de edição, na página de configurações
	* de formulários (action: config_forms).
	* @param integer id_module
	* @return void
	*/
	public function _ajax_config_form_update($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Dados da ação de registro do módulo
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/update');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, 'update');
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table);
			
			// Variaveis para view
			$args['module'] = $module;
			$args['action'] = $action;
			$args['form'] = $form;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_update', $args, false, false);
		}
	}
	
	/**
	* _ajax_config_form_delete()
	* Bloco html carregado via ajax que preenche box de configurações de formulário de deleção. É 
	* acionado quando existe o clique na aba de formulário de deleção, na página de configurações
	* de formulários (action: config_forms).
	* @param integer id_module
	* @return void
	*/
	public function _ajax_config_form_delete($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Dados da ação de registro do módulo
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/delete');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, 'delete');
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table);
			
			// Variaveis para view
			$args['module'] = $module;
			$args['action'] = $action;
			$args['form'] = $form;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_delete', $args, false, false);
		}
	}
	
	/**
	* _ajax_config_form_view()
	* Bloco html carregado via ajax que preenche box de configurações de formulário de visualização. É 
	* acionado quando existe o clique na aba de formulário de visualização, na página de configurações
	* de formulários (action: config_forms).
	* @param integer id_module
	* @return void
	*/
	public function _ajax_config_form_view($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Dados da ação de registro do módulo
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/view');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, 'view');
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table);
			
			// Variaveis para view
			$args['module'] = $module;
			$args['action'] = $action;
			$args['form'] = $form;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_view', $args, false, false);
		}
	}
	
	/**
	* ajax_config_form_fields()
	* Carrega tabela de campos de um determinado formulario. Utilizado em view de configuração de 
	* forms.
	* @param integer id_module
	* @param string operation
	* @return void
	*/
	public function ajax_config_form_fields($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Carrega dados do modulo (para saber tabela, etc)
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$table = get_value($module, 'table_name');
			$controller = get_value($module, 'controller');
			
			// Carrega dados do formulario e campos da tabela
			$form = $this->acme_module_manager_model->get_config_form_data($id_module, $operation);
			$id_form = (get_value($form, 'id_module_form') == '') ? 0 : get_value($form, 'id_module_form');
			
			// Carrega campos
			$is_filter = (strtolower($operation) == 'filter') ? true : false;
			$fields = $this->acme_module_manager_model->get_config_form_fields_data($id_form, $table, $is_filter);
			
			// Variaveis para view
			$args['form_enabled'] = (get_value($form, 'dtt_inative') != '' || count($form) <= 0) ? false : true;
			$args['form'] = $form;
			$args['operation'] = $operation;
			$args['fields'] = $fields;
			$args['table_name'] = $table;
			$args['controller'] = $controller;
			$args['id_module'] = $id_module;
			
			// Tratamento para campos
			$form_enabled = $args['form_enabled'];
			$args['class_disabled'] = (!$form_enabled) ? 'disabled' : '';
			$args['disabled'] = (!$form_enabled) ? 'disabled="disabled"' : '';
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_config_form_fields', $args, false, false);
		}
	}
	
	/**
	* ajax_enable_form()
	* Habilita um formulario. Disparado quando clicado no input checkbox do formulario em questao,
	* na pagina de configurações de formularios.
	* @param string operation
	* @param integer id_module
	* @return void
	*/
	public function ajax_enable_form($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Verifica se linha de form existe ou nao
			if(count($this->acme_module_manager_model->get_config_form_data($id_module, $operation)) > 0)
			{
				$this->db->set('dtt_inative', 'NULL', false);
				$this->db->where(array('id_module' => $id_module, 'operation' => $operation));
				$this->db->update('acm_module_form');
			} else {
				// Insere um novo registro de formulário para esta operação
				$this->db->insert('acm_module_form', array('id_module' => $id_module, 'operation' => $operation));
			}
		}
	}
	
	/**
	* ajax_disable_form()
	* Desabilita um formulario. Disparado quando clicado no input checkbox do formulario em questao,
	* na pagina de configurações de formularios.
	* @param string operation
	* @param integer id_module
	* @return void
	*/
	public function ajax_disable_form($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Verifica se linha de form existe ou nao
			if(count($this->acme_module_manager_model->get_config_form_data($id_module, $operation) > 0))
			{
				$this->db->set('dtt_inative', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_module' => $id_module, 'operation' => $operation));
				$this->db->update('acm_module_form');
			}
		}
	}
	
	/**
	* ajax_enable_form_field()
	* Habilita um campo de formulario. Disparado quando clicado no input checkbox de determinado
	* campo de formulario em questao, na pagina de configurações de formularios.
	* @param string column_name
	* @param integer id_form
	* @return void
	*/
	public function ajax_enable_form_field($column_name = '', $id_form = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Verifica se linha de form existe ou nao
			if(count($this->acme_module_manager_model->get_config_form_field_data($column_name, $id_form)) > 0)
			{
				$this->db->set('dtt_inative', 'NULL', false);
				$this->db->where(array('id_module_form' => $id_form, 'table_column' => $column_name));
				$this->db->update('acm_module_form_field');
			} 
			
			// Campo não existe no banco de dados
			else {
				// Dados do formulario
				$form = $this->acme_module_manager_model->get_form_data($id_form);
				
				// Dados do módulo e qual tabela este módulo possui
				$module = $this->acme_module_manager_model->get_module_data(get_value($form, 'id_module'));
				$table = get_value($module, 'table_name');
				
				// Busca meta-dados da tabela
				$fields = $this->db->field_data($table);
				
				// Varre campos até localizar o campo da coluna correto
				foreach ($fields as $field)
				{
					if($field->name == $column_name)
					{
						$field_insert = $this->form->build_array_field_db_from_object($field, $table);
						$field_insert['id_module_form'] = $id_form;
						foreach($field_insert as $index => $value)
						{
							$escape = ($value != 'NULL') ? true : false;
							$this->db->set($index, $value, $escape);
						}
						
						// Insere um novo registro de campo para este formulario
						$this->db->insert('acm_module_form_field');
					}
				}
			}
		}
	}
	
	/**
	* ajax_disable_form_field()
	* Desabilita um campo de formulario. Disparado quando clicado no input checkbox de determinado
	* campo de formulario em questao, na pagina de configurações de formularios.
	* @param string column_name
	* @param integer id_form
	* @return void
	*/
	public function ajax_disable_form_field($column_name = '', $id_form = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Verifica se linha de form existe ou nao
			if(count($this->acme_module_manager_model->get_config_form_field_data($column_name, $id_form) > 0))
			{
				$this->db->set('dtt_inative', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_module_form' => $id_form, 'table_column' => $column_name));
				$this->db->update('acm_module_form_field');
			}
		}
	}
	
	/**
	* ajax_enable_menu_insert()
	* Habilita o menu (link) de inserção do formulário. Disparado quando clicado no input checkbox 
	* de vincular menu ao formulario.
	* @param integer id_module
	* @return void
	*/
	public function ajax_enable_menu_insert($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e menu
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$menu = $this->acme_module_manager_model->get_module_menu_insert($id_module, get_value($module, 'controller') . '/form/insert');

			// Verifica se linha de menu existe ou nao
			if(count($menu) > 0)
			{
				$this->db->set('dtt_inative', 'NULL', false);
				$this->db->where(array('id_module_menu' => get_value($menu, 'id_module_menu')));
				$this->db->update('acm_module_menu');
			} 
			
			// Campo não existe no banco de dados
			else {
				$menu_ins['id_module'] = $id_module;
				$menu_ins['link'] = '<acme eval="URL_ROOT"/>/' . get_value($module, 'controller') . '/form/insert';
				$menu_ins['url_img'] = '<acme eval="URL_IMG"/>/icon_insert.png';
				$menu_ins['lang_key_rotule'] = 'Novo';
				
				// Insere um novo registro de menu para este formulario
				$this->db->insert('acm_module_menu', $menu_ins);
			}
		}
	}
	
	/**
	* ajax_disable_menu_insert()
	* Desabilita o menu (link) de inserção do formulário. Disparado quando clicado no input checkbox 
	* de vincular menu ao formulario.
	* @param integer id_module
	* @return void
	*/
	public function ajax_disable_menu_insert($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e menu
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$menu = $this->acme_module_manager_model->get_module_menu_insert($id_module, get_value($module, 'controller') . '/form/insert');

			// Verifica se linha de menu existe ou nao
			if(count($menu) > 0)
			{
				$this->db->set('dtt_inative', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_module_menu' => get_value($menu, 'id_module_menu')));
				$this->db->update('acm_module_menu');
			}
		}
	}
	
	/**
	* ajax_enable_config_action()
	* Habilita uma ação (link) de uma determinada operação a um formulário. Disparado quando clicado 
	* no input checkbox de vincular ação ao formulario.
	* @param string operation
	* @param integer id_module
	* @return void
	*/
	public function ajax_enable_config_action($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e ação
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/' . $operation);
			
			// DEBUG
			// print_r($action);

			// Verifica se linha de acao existe ou nao
			if(count($action) > 0)
			{
				$this->db->set('dtt_inative', 'NULL', false);
				$this->db->where(array('id_module_action' => get_value($action, 'id_module_action')));
				$this->db->update('acm_module_action');
			} 
			
			// Ação não existe no banco de dados
			else {
				// Array de keys de linguagem
				$arr_lang['update'] = 'Editar';
				$arr_lang['delete'] = 'Deletar';
				$arr_lang['view'] = 'Visualizar';
				
				// Dados para inserção
				$action_ins['id_module'] = $id_module;
				$action_ins['order'] = 30;
				$action_ins['link'] = '<acme eval="URL_ROOT"/>/' . get_value($module, 'controller') . '/form/' . $operation . '/{0}';
				$action_ins['url_img'] = '<acme eval="URL_IMG"/>/icon_' . strtolower($operation) . '.png';
				$action_ins['lang_key_rotule'] = $arr_lang[strtolower($operation)];
				$action_ins['description'] = $arr_lang[strtolower($operation)];
				
				// Insere um novo registro de acao para este formulario
				$this->db->insert('acm_module_action', $action_ins);
			}
		}
	}
	
	/**
	* ajax_modal_insert_form_field()
	* Janela de inserção de novo campo de formulário (filter).
	* @param integer id_module_form
	* @return void
	*/
	public function ajax_modal_insert_form_field($id_module_form = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			$error = false;
			$form = array();
			$module = array();
			
			// Verificação para ver se o form existe ou não
			if(!is_null($id_module_form) && $id_module_form != 0 && $id_module_form != '')
			{
				$form = $this->acme_module_manager_model->get_form_data($id_module_form);
				$module = $this->acme_module_manager_model->get_module_data(get_value($form, 'id_module'));
			} else {
				$error = true;
			}
			
			// Vars para view
			$args['form'] = $form;
			$args['module'] = $module;
			$args['error'] = $error;
			$args['id_module_form'] = $id_module_form;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_insert_form_field', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_insert_form_field_process()
	* Processa form de edição de dados de um campo de formulário.
	* @return void
	*/
	public function ajax_modal_insert_form_field_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Processa campos do post corretamente
			foreach($this->input->post() as $column => $value)
			{
				// Escapa campos corretamente
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				
				// Set apenas nas colunas que nao seja ID
				if($column != 'id_module')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->insert('acm_module_form_field');
			
			// Coleta ultimo id encaminhado
			$where['id_module_form'] = $this->input->post('id_module_form');
			$where['table_column'] = $this->input->post('table_column');
			$where['lang_key_label'] = $this->input->post('lang_key_label');
			$form_field = $this->db->get_where('acm_module_form_field', $where)->result_array();
			$form_field = isset($form_field[0]) ? $form_field[0] : array();
			$id_module_form_field = get_value($form_field, 'id_module_form_field');
			
			// Coleta dados do field novamente, para uso no view
			$args['field'] = $this->acme_module_manager_model->get_form_field_data($id_module_form_field);
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_insert_form_field_process', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_form_field()
	* Janela de edição de dados de um campo de formulário.
	* @param integer id_module_form_field
	* @return void
	*/
	public function ajax_modal_update_form_field($id_module_form_field = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			$error = false;
			$field = array();
			$module = array();
			
			// Verificação para ver se o campo existe ou não (ainda)
			if(!is_null($id_module_form_field) && $id_module_form_field != 0 && $id_module_form_field != '')
			{
				$field = $this->acme_module_manager_model->get_form_field_data($id_module_form_field);
				$module = $this->acme_module_manager_model->get_module_data(get_value($field, 'id_module'));
			} else {
				$error = true;
			}
			
			// Vars para view
			$args['field'] = $field;
			$args['module'] = $module;
			$args['error'] = $error;
			$args['id_module_form_field'] = $id_module_form_field;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_form_field', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_form_field_process()
	* Processa form de edição de dados de um campo de formulário.
	* @return void
	*/
	public function ajax_modal_update_form_field_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Processa campos do post corretamente
			foreach($this->input->post() as $column => $value)
			{
				// Escapa campos corretamente
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				
				// Set apenas nas colunas que nao seja ID
				if($column != 'id_module_form_field')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_form_field' => $this->input->post('id_module_form_field')));
			$this->db->update('acm_module_form_field');
			
			// Coleta dados do field novamente, para uso no view
			$args['field'] = $this->acme_module_manager_model->get_form_field_data($this->input->post('id_module_form_field'));
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_form_field_process', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_delete_form_field()
	* Janela de deleção de um campo de formulário.
	* @param integer id_module_form_field
	* @return void
	*/
	public function ajax_modal_delete_form_field($id_module_form_field = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			$error = false;
			$field = array();
			
			// Verificação para ver se o campo existe ou não (ainda)
			if(!is_null($id_module_form_field) && $id_module_form_field != 0 && $id_module_form_field != '')
			{
				$field = $this->acme_module_manager_model->get_form_field_data($id_module_form_field);
			} else {
				$error = true;
			}
			
			// Vars para view
			$args['field'] = $field;
			$args['error'] = $error;
			$args['id_module_form_field'] = $id_module_form_field;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_delete_form_field', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_delete_form_field_process()
	* Processa janela de deleção de um campo de formulário.
	* @return void
	*/
	public function ajax_modal_delete_form_field_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Coleta dados do field novamente, para uso no view
			$args['field'] = $this->acme_module_manager_model->get_form_field_data($this->input->post('id_module_form_field'));
			
			// Deleta registro
			$this->db->where(array('id_module_form_field' => $this->input->post('id_module_form_field')));
			$this->db->delete('acm_module_form_field');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_delete_form_field_process', $args, false, false);
		}
	}
	
	/**
	* ajax_disable_config_action()
	* Desabilita a ação (link) com o formulário. Disparado quando clicado no input checkbox 
	* de vincular ação ao formulario.
	* @param string operation
	* @param int id_module
	* @return void
	*/
	public function ajax_disable_config_action($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e acao
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/' . $operation);

			// Verifica se linha de acao existe ou nao
			if(count($action) > 0)
			{
				$this->db->set('dtt_inative', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_module_action' => get_value($action, 'id_module_action')));
				$this->db->update('acm_module_action');
			}
		}
	}
	
	/**
	* ajax_modal_update_menu_insert()
	* Tela de edição de menu de inserção de formulario de inserção de módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_update_menu_insert($id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e menu
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$menu = $this->acme_module_manager_model->get_module_menu_insert($id_module, get_value($module, 'controller') . '/form/insert');
			
			// Verifica existencia do campo
			$error = (count($menu) <= 0) ? true : false;
			
			// Variaveis para view
			$args['menu'] = $menu;
			$args['error'] = $error;
			$args['module'] = $module;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_menu_insert', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_menu_insert_process()
	* Processa tela de edição de menu de inserção de formulario de inserção de módulo.
	* @return void
	*/
	public function ajax_modal_update_menu_insert_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Processa campos do post corretamente
			foreach($this->input->post() as $column => $value)
			{
				// Escapa campos corretamente
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				
				// Set apenas nas colunas que nao seja ID
				if($column != 'id_module_menu')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_menu' => $this->input->post('id_module_menu')));
			$this->db->update('acm_module_menu');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_menu_insert_process', array('id_module' => $this->input->post('id_module')), false, false);
		}
	}
	
	/**
	* ajax_modal_update_action()
	* Tela de edição de ação de registro de modulo (link) com formulario de determinada operacao 
	* de módulo.
	* @param string operation
	* @param int id_module
	* @return void
	*/
	public function ajax_modal_update_action($operation = '', $id_module = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Cata dados do modulo e ação
			$module = $this->acme_module_manager_model->get_module_data($id_module);
			$action = $this->acme_module_manager_model->get_module_action($id_module, get_value($module, 'controller') . '/form/' . $operation);
			
			// Verifica existencia do campo
			$error = (count($action) <= 0) ? true : false;
			
			// Variaveis para view
			$args['action'] = $action;
			$args['error'] = $error;
			$args['module'] = $module;
			$args['operation'] = $operation;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_action', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_action_process()
	* Processa tela de edição de ação de registro de modulo (link) com formulario de determinada operacao 
	* de módulo.
	* @return void
	*/
	public function ajax_modal_update_action_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Processa campos do post corretamente
			foreach($this->input->post() as $column => $value)
			{
				// Escapa campos corretamente
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				
				// Set apenas nas colunas que nao seja ID
				if($column != 'id_module_action' && $column != 'operation')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_action' => $this->input->post('id_module_action')));
			$this->db->update('acm_module_action');
			
			// Variaveis para view
			$args['id_module'] = $this->input->post('id_module');
			$args['operation'] = $this->input->post('operation');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_action_process', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_form_data()
	* Tela de edição de dados do formulario (action, method, etc).
	* @param integer id_module_form
	* @return void
	*/
	public function ajax_modal_update_form_data($id_module_form = 0)
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			$error = false;
			$form = array();
			$module = array();
			
			// Verificação para ver se o campo existe ou não (ainda)
			if(!is_null($id_module_form) && $id_module_form != 0 && $id_module_form != '')
			{
				$form = $this->acme_module_manager_model->get_form_data($id_module_form);
				$module = $this->acme_module_manager_model->get_module_data(get_value($form, 'id_module'));
			} else {
				$error = true;
			}
			
			// Vars para view
			$args['form'] = $form;
			$args['module'] = $module;
			$args['error'] = $error;
			$args['id_module_form_field'] = $id_module_form;
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_form_data', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_form_data_process()
	* Processa tela de edição de dados do formulario (action, method, etc).
	* @return void
	*/
	public function ajax_modal_update_form_data_process()
	{
		if($this->validate_permission('CONFIG_FORMS', false))
		{
			// Processa campos do post corretamente
			foreach($this->input->post() as $column => $value)
			{
				// Escapa campos corretamente
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				
				// Set apenas nas colunas que nao seja ID
				if($column != 'id_module_form')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_form' => $this->input->post('id_module_form')));
			$this->db->update('acm_module_form');
			
			// Variaveis para view
			$args['form'] = $this->acme_module_manager_model->get_form_data($this->input->post('id_module_form'));
			$args['module'] = $this->acme_module_manager_model->get_module_data($this->input->post('id_module'));
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_form_data_process', $args, false, false);
		}
	}
	
	/**
	* administration()
	* Página de administração de um módulo em específico. Nesta página estão as informações do
	* móudlo, suas permissões, ações e menus, cada um editável.
	* @param integer id_module
	* @return void
	*/
	public function administration($id_module = 0)
	{
		if($this->validation->is_integer_($id_module))
		{
			$this->validate_permission('ADMINISTRATION');
			
			// Dados do modulo
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
			
			$this->template->load_page('_acme/acme_module_manager/administration', $args);
		} else {
			redirect('acme_module_manager');
		}
	}
	
	/**
	* ajax_modal_view_module_ini_file()
	* Modal de visualização de arquivo .ini do módulo
	* @return void
	*/
	public function ajax_modal_view_module_ini_file($id_module = 0)
	{
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Dados do modulo
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_view_module_ini_file', $args, false, false);
		}
	}
	
	/**
	* ajax_load_table_permissions()
	* Retorna string de uma tabela de permissões de um modulo.
	* @param integer id_module
	* @return string table
	*/
	public function ajax_load_table_permissions($id_module = 0)
	{
		$table = '';
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Trabalha com objeto table
			$obj_table = $this->array_table->get_instance();
			$obj_table->set_id('module_table_permissions');
			$obj_table->set_items_per_page(50000);
			$obj_table->set_data($this->acme_module_manager_model->get_module_permissions($id_module));
			
			// Adiciona colunas à tabela e seta as colunas de exibição
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Editar Permissão de Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_permission_update/{0}\', \'' . URL_IMG . '/icon_update.png\', 700, 600)"><img src="' . URL_IMG . '/icon_update.png" title="' . lang('Editar Permissão de Módulo') . '" /></a>');
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Deletar Permissão de Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_permission_delete/{0}\', \'' . URL_IMG . '/icon_delete.png\', 700, 600)"><img src="' . URL_IMG . '/icon_delete.png" title="' . lang('Deletar Permissão de Módulo') . '" /></a>');
			$obj_table->set_columns(array('#', 'ROTULE', 'PERMISSION NAME', 'DESCRIPTION'));
			
			// Processa tabela do modulo
			$table = $obj_table->get_html();
		}
		
		echo $table;
	}
	
	/**
	* ajax_load_table_actions()
	* Retorna string de uma tabela de actions de um modulo.
	* @param integer id_module
	* @return string table
	*/
	public function ajax_load_table_actions($id_module = 0)
	{
		$table = '';
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Trabalha com objeto table
			$obj_table = $this->array_table->get_instance();
			$obj_table->set_id('module_table_actions');
			$obj_table->set_items_per_page(50000);
			$obj_table->set_data($this->acme_module_manager_model->get_module_actions($id_module));
			
			// Adiciona colunas à tabela e seta as colunas de exibição
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Editar Ação de Registro do Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_action_update/{0}\', \'' . URL_IMG . '/icon_update.png\', 700, 600)"><img src="' . URL_IMG . '/icon_update.png" title="' . lang('Editar Ação de Registro do Módulo') . '" /></a>');
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Deletar Ação de Registro do Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_action_delete/{0}\', \'' . URL_IMG . '/icon_delete.png\', 700, 600)"><img src="' . URL_IMG . '/icon_delete.png" title="' . lang('Deletar Ação de Registro do Módulo') . '" /></a>');
			$obj_table->set_columns(array('#', 'ROTULE', 'LINK', 'JAVASCRIPT', 'DESCRIPTION', 'ICON'));
			
			// Processa tabela do modulo
			$table = $obj_table->get_html();
		}
		
		echo $table;
	}
	
	/**
	* ajax_load_table_menus()
	* Retorna string de uma tabela de menus de um modulo.
	* @param integer id_module
	* @return string table
	*/
	public function ajax_load_table_menus($id_module = 0)
	{
		$table = '';
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Trabalha com objeto table
			$obj_table = $this->array_table->get_instance();
			$obj_table->set_id('module_table_menus');
			$obj_table->set_items_per_page(50000);
			$obj_table->set_data($this->acme_module_manager_model->get_module_menus($id_module));
			
			// Adiciona colunas à tabela e seta as colunas de exibição
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Editar Menu de Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_menu_update/{0}\', \'' . URL_IMG . '/icon_update.png\', 700, 600)"><img src="' . URL_IMG . '/icon_update.png" title="' . lang('Editar Menu de Módulo') . '" /></a>');
			$obj_table->add_column('<a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Deletar Menu de Módulo') . '\', \'' . URL_ROOT . '/acme_module_manager/ajax_modal_module_menu_delete/{0}\', \'' . URL_IMG . '/icon_delete.png\', 700, 600)"><img src="' . URL_IMG . '/icon_delete.png" title="' . lang('Deletar Menu de Módulo') . '" /></a>');
			$obj_table->set_columns(array('#', 'ROTULE', 'LINK', 'JAVASCRIPT', 'DESCRIPTION'));
			
			// Processa tabela do modulo
			$table = $obj_table->get_html();
		}
		
		echo $table;
	}
	
	/**
	* ajax_modal_update_module_data()
	* Modal de edição de dados de um módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_update_module_data($id_module = 0)
	{
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Dados do módulo
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_module_data', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_update_module_data_process()
	* Processa modal de edição de dados de um módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_update_module_data_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				$value  = ($column == 'dtt_inative' && $value == '') ? 'NULL' : $value;
				$escape = ($column == 'dtt_inative') ? false : true;
				if($column != 'id_module')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module' => $this->input->post('id_module')));
			$this->db->update('acm_module');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_update_module_data_process', array(), false, false);
		}
	}
	
	/**
	* ajax_modal_module_permission_new()
	* Modal de inserção de permissão para módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_module_permission_new($id_module = 0)
	{
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			$args['id_module'] = $id_module;
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_permission_new', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_module_permission_new_process()
	* Processa modal de inserção de permissão para módulo.
	* @return void
	*/
	public function ajax_modal_module_permission_new_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				$this->db->set($column, $value, $escape);
			}
			
			$this->db->insert('acm_module_permission');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'permissions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_permission_update()
	* Modal de atualização de permissão para módulo.
	* @param integer id_permission
	* @return void
	*/
	public function ajax_modal_module_permission_update($id_permission = 0)
	{
		if($this->validation->is_integer_($id_permission) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_permission', array('id_module_permission' => $id_permission));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_permission_update', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_permission_update_process()
	* Processa modal de atualização de permissão para módulo.
	* @return void
	*/
	public function ajax_modal_module_permission_update_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_permission')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = ($column == 'dtt_inative') ? false : true;
				}
				
				if($column != 'id_module_permission')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_permission' => $this->input->post('id_module_permission')));
			$this->db->update('acm_module_permission');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'permissions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_permission_delete()
	* Modal de deleção de permissão para módulo.
	* @param integer id_permission
	* @return void
	*/
	public function ajax_modal_module_permission_delete($id_permission = 0)
	{
		if($this->validation->is_integer_($id_permission) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_permission', array('id_module_permission' => $id_permission));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_permission_delete', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_permission_delete_process()
	* Processa modal de deleção de permissão para módulo.
	* @return void
	*/
	public function ajax_modal_module_permission_delete_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_permission')) && $this->validate_permission('ADMINISTRATION', false))
		{
			$this->db->delete('acm_module_permission', array('id_module_permission' => $this->input->post('id_module_permission')));
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'permissions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_action_new()
	* Modal de inserção de action para módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_module_action_new($id_module = 0)
	{
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Variaveis para view
			$args['id_module'] = $id_module;
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_action_new', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_module_action_new_process()
	* Processa modal de inserção de action para módulo.
	* @return void
	*/
	public function ajax_modal_module_action_new_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				$this->db->set($column, $value, $escape);
			}
			
			$this->db->insert('acm_module_action');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'actions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_action_update()
	* Modal de atualização de action para módulo.
	* @param integer id_action
	* @return void
	*/
	public function ajax_modal_module_action_update($id_action = 0)
	{
		if($this->validation->is_integer_($id_action) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_action', array('id_module_action' => $id_action));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_action_update', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_action_update_process()
	* Processa modal de atualização de action para módulo.
	* @return void
	*/
	public function ajax_modal_module_action_update_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_action')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = ($column == 'dtt_inative') ? false : true;
				}
				
				if($column != 'id_module_action')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_action' => $this->input->post('id_module_action')));
			$this->db->update('acm_module_action');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'actions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_action_delete()
	* Modal de deleção de action para módulo.
	* @param integer id_action
	* @return void
	*/
	public function ajax_modal_module_action_delete($id_action = 0)
	{
		if($this->validation->is_integer_($id_action) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_action', array('id_module_action' => $id_action));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_action_delete', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_action_delete_process()
	* Processa modal de deleção de action para módulo.
	* @return void
	*/
	public function ajax_modal_module_action_delete_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_action')) && $this->validate_permission('ADMINISTRATION', false))
		{
			$this->db->delete('acm_module_action', array('id_module_action' => $this->input->post('id_module_action')));
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'actions'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_menu_new()
	* Modal de inserção de menu para módulo.
	* @param integer id_module
	* @return void
	*/
	public function ajax_modal_module_menu_new($id_module = 0)
	{
		if($this->validation->is_integer_($id_module) && $this->validate_permission('ADMINISTRATION', false))
		{
			// Variaveis para view
			$args['id_module'] = $id_module;
			$args['module'] = $this->acme_module_manager_model->get_module_data($id_module);
			$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_menu_new', $args, false, false);
		}
	}
	
	/**
	* ajax_modal_module_menu_new_process()
	* Processa modal de inserção de menu para módulo.
	* @return void
	*/
	public function ajax_modal_module_menu_new_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = true;
				}
				$this->db->set($column, $value, $escape);
			}
			
			$this->db->insert('acm_module_menu');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'menus'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_menu_update()
	* Modal de atualização de menu para módulo.
	* @param integer id_menu
	* @return void
	*/
	public function ajax_modal_module_menu_update($id_menu = 0)
	{
		if($this->validation->is_integer_($id_menu) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_menu', array('id_module_menu' => $id_menu));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_menu_update', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_menu_update_process()
	* Processa modal de atualização de menu para módulo.
	* @return void
	*/
	public function ajax_modal_module_menu_update_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_menu')) && $this->validate_permission('ADMINISTRATION', false))
		{
			foreach($this->input->post() as $column => $value)
			{
				if($value == '')
				{
					$value = 'NULL';
					$escape = false;
				} else {
					$escape = ($column == 'dtt_inative') ? false : true;
				}
				
				if($column != 'id_module_menu')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_module_menu' => $this->input->post('id_module_menu')));
			$this->db->update('acm_module_menu');
			
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'menus'), false, false);
		}
	}
	
	/**
	* ajax_modal_module_menu_delete()
	* Modal de deleção de menu para módulo.
	* @param integer id_menu
	* @return void
	*/
	public function ajax_modal_module_menu_delete($id_menu = 0)
	{
		if($this->validation->is_integer_($id_menu) && $this->validate_permission('ADMINISTRATION', false))
		{
			$result = $this->db->get_where('acm_module_menu', array('id_module_menu' => $id_menu));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$args['data'] = $result[0];
				$args['module'] = $this->acme_module_manager_model->get_module_data(get_value($args['data'], 'id_module'));
				$args['manage_acme_modules_permission'] = $this->validate_permission('MANAGE_ACME_MODULES', false);
				
				// Carrega view
				$this->template->load_page('_acme/acme_module_manager/ajax_modal_module_menu_delete', $args, false, false);
			}
		}
	}
	
	/**
	* ajax_modal_module_menu_delete_process()
	* Processa modal de deleção de action para módulo.
	* @return void
	*/
	public function ajax_modal_module_menu_delete_process()
	{
		if($this->validation->is_integer_($this->input->post('id_module_menu')) && $this->validate_permission('ADMINISTRATION', false))
		{
			$this->db->delete('acm_module_menu', array('id_module_menu' => $this->input->post('id_module_menu')));
			// Carrega view
			$this->template->load_page('_acme/acme_module_manager/ajax_modal_process_reload_table', array('id_module' => $this->input->post('id_module'), 'data_type' => 'menus'), false, false);
		}
	}
}
