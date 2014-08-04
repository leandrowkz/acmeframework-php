<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* ACME_Module_Controller
* 
* Controlador base da aplicação. Contém o conjunto de regras e métodos referentes aos módulos da
* aplicação. Todos os controladores devem extender desta classe.
*
* Fluxo de carregamento de um módulo:
* 1) Construção do objeto da classe;
* 2) Verifica se a sessão é válida, isto é, usuário está logado;
* 3) Localiza dados do módulo no banco de dados, com base no nome da classe;
* 4) Carrega o módulo, isto é, transpassa os dados do banco de dados para o objeto,
*    para que fique num estado utilizável;
* 5) Carrega model do módulo
* 6) Redireciona para listagem / tela de entrada do módulo;
*
* @since	25/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class ACME_Module_Controller extends ACME_Core_Controller {
	
	public $id_module;
	public $controller; 		// controlador do módulo
	public $table_name;			// nome da tabela (caso possua uma tabela-alvo)
	public $label;				// label, rótulo do módulo
	public $url_img;			// URL da imagem do módulo
	public $description;		// descrição
	public $sql_list;			// SQL de listagem (exibido na entrada do módulo)
	public $menus = array();	// menus do módulo
	public $actions = array();	// ações de registro (para cada registro da listagem)
	

	/**
	* __construct()
	* Recebe o nome da classe do módulo a ser carregado.
	* @param string controller
	* @return object
	*/
	public function __construct($controller = '')
	{
		parent::__construct();
		
		// Valida a sessão (comportamento padrão de módulo)
		$this->access->validate_session();
		
		// Define o nome do controlador atual do módulo
		$this->controller = strtolower($controller);
		
		// Tenta carregar o módulo
		$this->_load_module();
	}
	
	/**
	* load_module()
	* Carrega os dados do módulo do banco de dados para o objeto atual.
	* @return void
	*/
	private function _load_module()
	{
		// Tenta localizar o módulo com base no nome do controlador
		$module = $this->db->from('acm_module')
						   ->where(array('controller' => $this->controller))
						   ->get()
						   ->row_array(0);

		if(count($module) <= 0) {
			// Não localizou um módulo cadastrado com o nome da classe
			$this->error->show_error(lang('Módulo não localizado.'), lang('Não foi possível carregar o módulo especificado. Certifique-se que o nome da classe definida para este módulo está de acordo com o cadastrado no banco de dados.') . ' Classe: ' . $this->controller);			
			exit;
		}

		// Seta atributos do objeto atual
		$this->id_module = get_value($module, 'id_module');
		$this->label = lang(get_value($module, 'label'));
		$this->sql_list = get_value($module, 'sql_list');
		$this->url_img = tag_replace(get_value($module, 'url_img'));
		$this->description = get_value($module, 'description');
		$this->table_name = get_value($module, 'table_name');
		$this->menus = $this->db->get_where('acm_module_menu', array('id_module' => $this->id_module))->result_array();
		$this->actions = $this->db->get_where('acm_module_action', array('id_module' => $this->id_module))->result_array();
		
		// Carrega model do modulo
		$this->load->model($this->controller . '_model');

		// Load base model
		$this->load->model('core/acme_module_controller_model');
	}
	
	/**
	* validate_permission()
	* Valida uma permissão do módulo corrente para o usuário de id informado. Retorna true
	* caso possua permissão, ou redireciona para página de erro de permissão caso false.
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
	* Valida uma permissão do módulo corrente para o usuário de id informado. Retorna true/false.
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
	* Tela de entrada, listagem do módulo, retrieve de dados.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		if($this->sql_list != '') {
			
			// Executa o sql do módulo e converte em array
			$resultset = $this->db->query($this->sql_list)->result_array();
		
			// Monta tabela de dados
			$table = $this->array_table->get_instance();
			$table->set_id( uniqid() );
			$table->set_items_per_page(100);
			$table->set_data($resultset);
			
			// Adiciona a tabela de dados, as possíveis ações do módulo
			foreach($this->actions as $action)
				$table->add_column($this->template->load_html_component('module_action', array('action' => $action)));

			// Html da tabela
			$args['module_table'] = $table->get_html();
		} else {
			$args['module_table'] = message('info', '', lang('Módulo sem consulta SQL'));
		}
		
		// Carrega view
		$this->template->load_page('_acme/acme_module_controller/index', $args);
	}
	
	/**
	* form()
	* Build form a single form of the given operation. The fields are got from database.
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
			$this->log->db_log('Inserção de registro', 'insert', $this->table_name, $data);
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
			$this->log->db_log('Edição de registro', 'update', $this->table_name, array_merge(array('new_data' => $data), array('old_data' => $old_data)));
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
			$this->log->db_log('Deleção de registro', 'delete', $this->table_name, $old_data);

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
