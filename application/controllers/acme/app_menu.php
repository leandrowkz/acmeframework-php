<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Menu
* 
* Módulo de gerenciamento de menus da aplicação.
*
* @since 	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Menu extends ACME_Module_Controller {
	
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
	* Module index. Show all menus by group, with reorder options in real time. Menus are loaded
	* after loading page, through ajax.
	* @return void
	*/
	public function index()
	{
		$this->validate_permission('ENTER');
		
		// load all groups
		$groups = $this->db->select('name, name AS label')->from('acm_user_group')->order_by('name')->get()->result_array();

		// build group options
		$args['options'] = $this->form->build_select_options($groups, '', false);

		$this->template->load_page('_acme/app_menu/index', $args);
	}
	
	/**
	* load_menus()
	* Load html menu area. Expect $_POST['group'] as parameter to filter menus.
	* @return void
	*/
	public function load_menus()
	{
		if( ! $this->check_permission('ENTER'))
			return;

		$group = $this->input->post('group');

		$args['menus'] = $this->template->get_array_menus($group);

		$this->template->load_page('_acme/app_menu/load_menus', $args, false, false);
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
