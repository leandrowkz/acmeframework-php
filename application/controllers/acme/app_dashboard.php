<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Dashboard
* 
* Dashboard padrão da aplicação. Por padrão, tela de entrada dos usuários do grupo ROOT.
*
* @since	15/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Dashboard extends ACME_Module_Controller {

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
	* Tela de dashboard.
	* @return void
	*/
	public function index()
	{
		// echo $note;
		// Valida permissão de visualização de dashboard
		$this->validate_permission('VIEW_DASHBOARD');
		
		// Módulos da app
		$args['modules'] = $this->db->from('acm_module')->order_by('label')->get()->result_array();

		// Dispositivos que acessam a app
		$args['devices'] = $this->db->select('distinct device_name, count(*) as count_access')
									->from('acm_log')
									->where(array('action' => 'login'))
									->group_by('device_name')
									->get()
									->result_array();

		// error tracker
		$args['errors'] = $this->db->from('acm_log_error')
								   ->order_by('log_dtt_ins desc')
								   ->get()
								   ->result_array();

		// browser ranking
		$args['browsers'] = $this->db->select('distinct browser_name, count(*) as count_access')
									 ->from('acm_log')
									 ->where(array('action' => 'login'))
									 ->group_by('browser_name')
									 ->order_by('browser_name')
									 ->get()
									 ->result_array();

		// Carrega view
		$this->template->load_page('_acme/app_dashboard/index', $args);
	}
}
