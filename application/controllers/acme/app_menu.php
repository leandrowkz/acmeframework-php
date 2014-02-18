<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Menu
* 
* Módulo abstração para gerenciamento de menus presentes na aplicação.
*
* @since		13/08/2012
* @location		acme.controllers.acme_menu
*
*/
class Acme_Menu extends Acme_Base_Module {
	// Definição de atributos
	
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
	* @override
	* index()
	* Entrada do módulo. Exibe menus do sistema em formato de árvore vertical
	* @return void
	*/
	public function index()
	{
		// Valida permissão de entrada do módulo
		$this->validate_permission('ENTER');
		
		// Carrega model que fará leitura dos menus no banco de dados
		$this->load->model('libraries/template_model');
		$this->load->model('acme_user_group_model');
		
		// Filtros encaminhados - dá preferencia por POST, se não tenta localizar o array
		// de filtros do modulo que fica perambulando na sessao. Para este segundo caso,
		// tenta localizar conforme o nome do modulo, entao apaga todos os outros filtros.
		if($this->input->post() != '')
		{
			$filters = $this->input->post();
		} else if (get_value($this->session->userdata('module_array_filters'), $this->controller . '_filters') != '') {
			$filters = get_value($this->session->userdata('module_array_filters'), $this->controller . '_filters');
			$this->session->set_userdata('module_array_filters', null);
		} else {
			$filters = array();
		}
		
		// Seta o array de filtros em sessão para que quando alterar a pagina ainda dentro do modulo
		// e voltar para a pagina de listagem os filtros permaneçam como estavam anteriormente.
		$this->session->set_userdata('module_array_filters', array($this->controller . '_filters' => $filters));
		
		// Grupo de usuário
		$group = (get_value($filters, 'user_group') == '') ? $this->session->userdata('user_group') : get_value($filters, 'user_group');
		$group_data = $this->acme_user_group_model->get_user_group_by_name($group);
		
		// Faz leitura do menu conforme o grupo de usuário atual
		// Esta leitura é recursiva, para cada menu o model busca
		// possíveis menus-filhos.
		$menus = $this->acme_menu_model->get_list_module($group);
		$menus = (count($menus) > 0) ? $this->template->menus_to_tree($menus) : array();
		
		// Opções para combo de filtros
		$options_groups = $this->form->build_array_html_options($this->acme_menu_model->get_list_groups_options(), $group, false);
		
		// Carrega view
		$this->template->load_page('_acme/acme_menu/index', array('menus' => $menus, 'group' => $group, 'options_groups' => $options_groups, 'group_data' => $group_data));
	}
	
	/**
	* ajax_reorder_menu()
	* Atualiza o nodo de menu reordenado via interface, com base no id do nodo encaminhado.
	* @param int id_menu
	* @param int id_menu_parent_new
	* @param int order
	* @return void
	*/
	public function ajax_reorder_menu($id_menu = 0, $id_menu_parent_new = 0, $order = 0)
	{
		if($this->validate_permission('UPDATE', false))
		{
			$this->db->set('id_menu_parent', $id_menu_parent_new, false);
			$this->db->set('order_', $order, false);
			$this->db->where(array('id_menu' => $id_menu));
			$this->db->update('acm_menu');
		} else {
			// Quando encaminhado um erro no cabeçalho http, o ajax dispara o callback error
			// exibindo a mensagem de que o usuário atual não possui esta permissão (UPDATE)
			header("HTTP/1.0 500 Internal Server Error");
		}
	}
	
	/**
	* ajax_modal_menu_new()
	* Modal de inserção de dados de um novo menu de sistema.
	* @param int id_user_group
	* @return void
	*/
	public function ajax_modal_menu_new($id_user_group = 0)
	{
		if($this->validate_permission('INSERT', false))
		{
			// Carrega models necessarios
			$this->load->model('acme_user_group_model');
			
			// Coleta dados do grupo
			$args['group'] = $this->acme_user_group_model->get_user_group($id_user_group);
			
			// Coleta os menus disponíveis para este grupo
			$args['options_menus'] = $this->form->build_array_html_options($this->acme_menu_model->get_list_menus_group($id_user_group), '', false);
			
			// Carrega view
			$this->template->load_page('_acme/acme_menu/ajax_modal_menu_new', $args, false, false);
		} else {
			$this->error->show_exception_message(lang('Você não possui permissões para executar esta ação (insert).'));
		}
	}
	
	/**
	* ajax_modal_menu_new_process()
	* Processa modal de inserção de menu de sistema.
	* @return void
	*/
	public function ajax_modal_menu_new_process()
	{
		if($this->validation->is_integer_($this->input->post('id_user_group')) && $this->validate_permission('INSERT', false))
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
			
			$this->db->insert('acm_menu');
			
			// Carrega view
			$this->template->load_page('_acme/acme_menu/ajax_close_modal_reload_page', array(), false, false);
		}
	}
	
	/**
	* ajax_modal_menu_update()
	* Modal de edição de dados de um determinado menu.
	* @param int id_menu
	* @return void
	*/
	public function ajax_modal_menu_update($id_menu = 0)
	{
		if($this->validate_permission('UPDATE', false))
		{
			$result = $this->db->get_where('acm_menu', array('id_menu' => $id_menu));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Busca menu, Carrega view
				$args['data'] = $result[0];
				$this->template->load_page('_acme/acme_menu/ajax_modal_menu_update', $args, false, false);
			}
		} else {
			$this->error->show_exception_message(lang('Você não possui permissões para executar esta ação (update).'));
		}
	}
	
	/**
	* ajax_modal_menu_update_process()
	* Processa modal de atualização de menu do sistema.
	* @return void
	*/
	public function ajax_modal_menu_update_process()
	{
		if($this->validation->is_integer_($this->input->post('id_menu')) && $this->validate_permission('UPDATE', false))
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
				
				if($column != 'id_menu')
					$this->db->set($column, $value, $escape);
			}
			
			$this->db->where(array('id_menu' => $this->input->post('id_menu')));
			$this->db->update('acm_menu');
			
			// Carrega view
			$this->template->load_page('_acme/acme_menu/ajax_close_modal_reload_page', array(), false, false);
		}
	}
	
	/**
	* ajax_modal_menu_delete()
	* Modal de deleção de menu do sistema.
	* @param integer id_menu
	* @return void
	*/
	public function ajax_modal_menu_delete($id_menu = 0)
	{
		if($this->validation->is_integer_($id_menu) && $this->validate_permission('DELETE', false))
		{
			$result = $this->db->get_where('acm_menu', array('id_menu' => $id_menu));
			$result = $result->result_array();
			if(isset($result[0]))
			{
				// Variaveis para view
				$this->load->model('libraries/template_model');
				$args['data'] = $result[0];
				$menus = $this->template_model->get_menus($this->session->userdata('user_group'));
				$args['menus'] = (count($menus) > 0) ? $this->template->menus_to_tree($menus) : array();
		
				// Carrega view
				$this->template->load_page('_acme/acme_menu/ajax_modal_menu_delete', $args, false, false);
			}
		} else {
			$this->error->show_exception_message(lang('Você não possui permissões para executar esta ação (delete).'));
		}
	}
	
	/**
	* ajax_modal_menu_delete_process()
	* Processa modal de deleção de menu do sistema.
	* @return void
	*/
	public function ajax_modal_menu_delete_process()
	{
		if($this->validation->is_integer_($this->input->post('id_menu')) && $this->validate_permission('DELETE', false))
		{
			$this->db->delete('acm_menu', array('id_menu' => $this->input->post('id_menu')));
			// Carrega view
			$this->template->load_page('_acme/acme_menu/ajax_close_modal_reload_page', array(), false, false);
		}
	}
}
