<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller App_Menu
 *
 * Application menus module. Manage all application menus.
 *
 * @since 	13/08/2012
 * --------------------------------------------------------------------------------------------------
 */
class App_Menu extends ACME_Controller {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Module index. Show all menus by group, with reorder options in real time.
	 * Menus are loaded after loading page, through ajax.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->validate_permission('ENTER');

		// Load all groups
		$groups = $this->db->select('name, name AS label')->from('acm_user_group')->order_by('name')->get()->result_array();

		// Build group options
		$args['options'] = $this->form->build_select_options($groups, '', false);

		$this->template->load_view( $this->controller . '/index', $args );
	}

	/**
	 * Load html menu area. Expect $_POST['group'] as parameter to filter menus.
	 *
	 * @return void
	 */
	public function load_menus()
	{
		$group = $this->input->post('group');

		// Get all menus
		$args['menus'] = $this->template->get_array_menus($group);

		// Get all menus for forms
		$args['form_menus'] = $this->template->get_menus($group);

		$this->template->load_view( $this->controller . '/load-menus', $args, false, false );
	}

	/**
	 * Return a json with a string of all menus for the forwarded group.
	 *
	 * @param string group
	 * @return void
	 */
	public function group_menus_options($group = '')
	{
		if( ! $this->check_permission( 'UPDATE' ) ) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		// Load all menus
		$menus = $this->db->select('m.id_menu, m.label')
						  ->from('acm_menu m')
						  ->join('acm_user_group g', 'g.id_user_group = m.id_user_group', 'inner')
						  ->where(array('g.name' => $group))
						  ->order_by('id_menu_parent, order_')
						  ->get()
						  ->result_array();

		// Build menu options
		$options = $this->form->build_select_options($menus);

		// Adorable return!
		echo json_encode(array('return' => true, 'options' => $options));
	}

	/**
	 * Insert, update and delete for application menus. All data must be sent
	 * through ajax. Operation must be sent as parameter and data by $_POST.
	 * Print JSON as result operation status.
	 *
	 * @param string operation		// insert, update, delete
	 * @return void
	 */
	public function save($operation = '')
	{
		$permission = strtolower( $operation ) == 'reorder' ? 'UPDATE' : strtoupper( $operation );

		if( ! $this->check_permission( $permission ) ) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {

			case 'insert':
			case 'update':

				// Get values from post
				$id_menu_parent = $this->input->post('id_menu_parent') == '' ? 'NULL' : $this->input->post('id_menu_parent');
				$order_ = $this->input->post('order_') == '' ? 0 : $this->input->post('order_');
				$group = $this->db->select('id_user_group')
										  ->from('acm_user_group')
										  ->where(array('name' => $this->input->post('id_user_group')))
										  ->get()
										  ->row_array(0);

				// Set values
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
				// Delete all menus that current menu is parent
				$this->db->delete('acm_menu', array('id_menu_parent' => $this->input->post('id_menu')));

				// Now delete this menu
				$this->db->delete('acm_menu', array('id_menu' => $this->input->post('id_menu')));
			break;

			case 'reorder':

				// Values
				$id_menu_parent = $this->input->post('id_menu_parent') == '' ? 'NULL' : $this->input->post('id_menu_parent');
				$order_ = $this->input->post('order_') == '' ? 0 : $this->input->post('order_');

				// Set values
				$this->db->set('id_menu_parent', $id_menu_parent, false);
				$this->db->set('order_', $order_, false);

				// Do it!
				$this->db->where( array('id_menu' => $this->input->post('id_menu')) );
				$this->db->update('acm_menu');
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}
}
