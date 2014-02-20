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
		$module = $this->db->get_where('acm_module', array('controller' => $this->controller))->result_array();
		$module = isset($module[0]) ? $module[0] : array();

		if(count($module) <= 0) {
			// Não localizou um módulo cadastrado com o nome da classe
			$this->error->show_error(lang('Módulo não localizado.'), lang('Não foi possível carregar o módulo especificado. Certifique-se que o nome da classe definida para este módulo está de acordo com o cadastrado no banco de dados.') . ' Classe: ' . $this->controller);			
			exit;
		}

		// Seta atributos do objeto atual
		$this->id_module = get_value($module, 'id_module');
		$this->label = lang(get_value($module, 'lang_key_rotule'));
		$this->sql_list = get_value($module, 'sql_list');
		$this->url_img = eval_replace(get_value($module, 'url_img'));
		$this->description = get_value($module, 'description');
		$this->table_name = get_value($module, 'table_name');
		$this->menus = $this->db->get_where('acm_module_menu', array('id_module' => $this->id_module))->result_array();
		$this->actions = $this->db->get_where('acm_module_action', array('id_module' => $this->id_module))->result_array();
		
		// Carrega model do modulo
		$this->load->model($this->controller . '_model');
	}
	
	/**
	* validate_permission()
	* Valida uma permissão do módulo corrente para o usuário de id informado.
	* @param string permission
	* @param boolean exib_page
	* @param integer id_user
	* @return mixed has_permission
	*/
	public function validate_permission($permission = '', $exib_page = true, $id_user = 0)
	{
		return $this->access->validate_permission($this->controller, $permission, $exib_page, $id_user);
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
			foreach($this->actions as $action) {

				$table->add_column($this->template->load_html_component('module_action', array($action)));

			}
		
			// Html da tabela
			$args['module_table'] = $table->get_html();
		} else {
			$args['module_table'] = message('note', '', lang('Módulo sem consulta SQL.'));
		}
		
		// Carrega view
		$this->template->load_page('_acme/acme_module_controller/index', $args);
	}
	
	/**
	* form()
	* Página de montagem de formulario. Recebe como parametro o tipo de formulario (operation)
	* que devera ser montado.
	* @param string operation
	* @param integer pk_value
	* @return void
	*/
	public function form($operation = '', $pk_value = '')
	{
		// Permissao da operacao do formulario
		$this->validate_permission(strtoupper($operation));
		
		// Ajusta operacao
		$operation = strtolower($operation);
		
		// Caso a operacao nao seja insert, deve validar a chave primaria
		if(($operation != 'insert' && $this->validation->is_integer_($pk_value)) || $operation == 'insert')
		{
			// Coleta dados do form
			$form = $this->{$this->controller . '_model'}->get_form($this->id_module, $operation);
			if(count($form) > 0)
			{
				// Coleta fields e values destes fields
				$fields = $this->{$this->controller . '_model'}->get_form_fields(get_value($form, 'id_module_form'));
				$values = (is_integer_($pk_value)) ? $this->{$this->controller . '_model'}->select($pk_value) : array();
				$values = (count($values) > 0) ? $values[0] : $values;
				
				// print_r($values[0]);
				
				// Transforma campos e valores em campos HTML
				$html_fields = $this->form->build_array_html_form_fields($fields, $values);
			
				// Variaveis do view
				$args['form'] = $form;
				$args['html_fields'] = $html_fields;
				$args['fields'] = $fields;
				$args['values'] = $values;
				$args['operation'] = $operation;
				$args['pk_value'] = $pk_value;
			
				// Load do view
				$this->template->load_page('_acme/acme_base_module/form_' . $operation, $args);
			} else {
				// Carrega página de formulário inexistente
				$this->template->load_page('_acme/acme_base_module/form_warning_exist');
			}
		} else {
			// Redireciona para entrada do modulo
			redirect(URL_ROOT . '/' . $this->controller);
		}
	}
	
	/**
	* form_process()
	* Processa formulario do modulo. Contempla as 4 operacoes basicas (insert, update, delete, view).
	* @return void
	*/
	public function form_process()
	{
		// Ajusta operacao
		$operation = strtolower($this->input->post('operation'));
		
		// Permissao da operacao do formulario
		$this->validate_permission(strtoupper($operation));
		
		// VALIDAÇÕES EM PHP, FAZER AQUI!
		
		// Chama funcao interna correspondente a operacao (_insert, _update, _view, _delete)
		$this->{'_' . $operation}($this->input->post());
	}
	
	/**
	* _insert()
	* Insere um registro encaminhado através de um processamento de formulario.
	* @param array post
	* @return void
	*/
	private function _insert($post = array())
	{
		// Só faz insert caso post encaminhado
		if(count($post) > 0)
		{			
			// Array de dados do insert
			$form_data = get_value($post, $this->table);
			
			// insere registro na tabela vinculada ao modulo
			$this->{$this->controller . '_model'}->insert($form_data);
			
			// Insere um registro de log
			$this->log->db_log('Inserção de registro', 'insert', $this->table, $post);
		}
		
		// Redireciona para entrada do modulo
		redirect(URL_ROOT . '/' . $this->controller);
	}
	
	/**
	* _update()
	* Atualiza um registro encaminhado atraves de um processamento de formulario.
	* @param array post
	* @return void
	*/
	private function _update($post = array())
	{
		// Só faz ação caso post encaminhado
		if(count($post) > 0)
		{			
			// Array de dados
			$form_data = get_value($post, $this->table);
			
			// Insere um registro de log
			$old = $this->{$this->controller . '_model'}->select(get_value($post, 'primary_key_value'));
			$arr_log['old'] = $old[0];
			$arr_log['new'] = $post;
			$this->log->db_log('Edição de registro', 'update', $this->table, $arr_log);
			
			// Atualiza registro na tabela vinculada ao modulo
			$this->{$this->controller . '_model'}->update($form_data, array($this->{$this->controller . '_model'}->primary_key => get_value($post, 'primary_key_value')));
		}
		
		// Redireciona para entrada do modulo
		redirect(URL_ROOT . '/' . $this->controller);
	}
	
	/**
	* _delete()
	* Remove um registro encaminhado atraves de um processamento de formulario.
	* @param array post
	* @return void
	*/
	private function _delete($post = array())
	{
		// Só faz ação caso post encaminhado
		if(count($post) > 0)
		{			
			// Insere um registro de log
			$old = $this->{$this->controller . '_model'}->select(get_value($post, 'primary_key_value'));
			$arr_log = $old[0];
			$this->log->db_log('Deleção de registro', 'delete', $this->table, $arr_log);
			
			// Remove registro
			$this->{$this->controller . '_model'}->delete(array($this->{$this->controller . '_model'}->primary_key => get_value($post, 'primary_key_value')));
		}
		
		// Redireciona para entrada do modulo
		redirect(URL_ROOT . '/' . $this->controller);
	}
	
	/**
	* _view()
	* View de um registro encaminhado atraves de um processamento de formulario (não faz nada).
	* @param array post
	* @return void
	*/
	private function _view($post = array())
	{
		// Redireciona para entrada do modulo
		redirect(URL_ROOT . '/' . $this->controller);
	}
}
