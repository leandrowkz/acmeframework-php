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
		$group = $this->input->post('group');

		// get all menus
		$args['menus'] = $this->template->get_array_menus($group);

		// get all menus for forms
		$args['form_menus'] = $this->template_model->get_menus($group);

		$this->template->load_page('_acme/app_menu/load_menus', $args, false, false);
	}

	/**
	* group_menus_options()
	* Return a json with a string of all menus for the forwarded group.
	* @param string group
	* @return void
	*/
	public function group_menus_options($group = '')
	{
		if( ! $this->check_permission( 'UPDATE' ) ) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso')));
			return;
		}

		// load all menus
		$menus = $this->db->select('m.id_menu, m.label')
						  ->from('acm_menu m')
						  ->join('acm_user_group g', 'g.id_user_group = m.id_user_group', 'inner')
						  ->where(array('g.name' => $group))
						  ->order_by('id_menu_parent, order_')
						  ->get()
						  ->result_array();

		// build menu options
		$options = $this->form->build_select_options($menus);

		// Adorable return!
		echo json_encode(array('return' => true, 'options' => $options));
	}

	/**
	* save()
	* Insert, update and delete for application menus. All data must be sent through ajax. Operation must
	* be sent as parameter and data by $_POST. Print json as result operation status.
	* @param string operation		// insert, update, delete
	* @return void
	*/
	public function save($operation = '')
	{
		$permission = strtolower( $operation ) == 'reorder' ? 'UPDATE' : strtoupper( $operation );

		if( ! $this->check_permission( $permission ) ) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! Você não tem permissão para fazer isso')));
			return;
		}

		switch(strtolower($operation)) {
			
			case 'insert':
			case 'update':

				// get values from post
				$id_menu_parent = $this->input->post('id_menu_parent') == '' ? 'NULL' : $this->input->post('id_menu_parent');
				$order_ = $this->input->post('order_') == '' ? 0 : $this->input->post('order_');
				$group = $this->db->select('id_user_group')
										  ->from('acm_user_group')
										  ->where(array('name' => $this->input->post('id_user_group')))
										  ->get()
										  ->row_array(0);

				// set values
				$this->db->set('id_menu_parent', $id_menu_parent, false);
				$this->db->set('order_', $order_, false);
				$this->db->set('id_user_group', get_value($group, 'id_user_group'), false);
				$this->db->set('label', $this->input->post('label'));
				$this->db->set('link', $this->input->post('link'));
				$this->db->set('target', $this->input->post('target'));
				$this->db->set('url_img', $this->input->post('url_img'));

				if( strtolower($operation) == 'insert' )
					$this->db->insert('acm_menu');
				else {
					$this->db->where( array('id_menu' => $this->input->post('id_menu')) );
					$this->db->update('acm_menu');
				}
			break;

			case 'delete';
				// delete all menus that current menu is parent
				$this->db->delete('acm_menu', array('id_menu_parent' => $this->input->post('id_menu')));

				// now delete this menu
				$this->db->delete('acm_menu', array('id_menu' => $this->input->post('id_menu')));
			break;

			case 'reorder':
				
				// values
				$id_menu_parent = $this->input->post('id_menu_parent') == '' ? 'NULL' : $this->input->post('id_menu_parent');
				$order_ = $this->input->post('order_') == '' ? 0 : $this->input->post('order_');
				
				// set values
				$this->db->set('id_menu_parent', $id_menu_parent, false);
				$this->db->set('order_', $order_, false);
				
				// do it!
				$this->db->where( array('id_menu' => $this->input->post('id_menu')) );
				$this->db->update('acm_menu');				
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
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
