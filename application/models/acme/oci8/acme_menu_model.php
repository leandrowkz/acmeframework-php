<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Menu_Model
*
* Gerencia camada de dados do módulo de menus do sistema.
* 
* @since		26/06/2013
* @location		acme.models.acme_menu_model
*
*/
class Acme_Menu_Model extends Base_Module_Model {
	// Definição de Atributos
	
	/**
	* __construct()
	* Construtor de classe. Chama o construtor pai, que abre uma conexão com
	* o banco de dados, automaticamente.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* get_list_module()
	* Retorna um array de menus para um determinado grupo.
	* @param string grupo
	* @return array menu
	*/
	public function get_list_module($group = '')
	{
		$sql = "
			SELECT x.*, NVL(x.id_menu_parent, 0) AS id_menu_parent FROM (
			SELECT m.*
				  FROM acm_menu m 
			INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
				 WHERE ug.name = '$group'
			  ORDER BY m.order_) x ORDER BY x.id_menu_parent ";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_list_groups_options()
	* Retorna um array de grupos disponíveis e cadastrados no sistema.
	* @return array groups
	*/
	public function get_list_groups_options()
	{
		$sql = "SELECT name, name AS repeat_name FROM acm_user_group ORDER BY name";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_list_groups_id_options()
	* Retorna um array de grupos disponíveis e cadastrados no sistema.
	* @return array groups
	*/
	public function get_list_groups_id_options()
	{
		$sql = "SELECT id_user_group, name FROM acm_user_group ORDER BY name";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_list_menus_group()
	* Retorna um array de menus para um determinado grupo.
	* @param int id_group
	* @return array menu
	*/
	public function get_list_menus_group($id_group = 0)
	{
		$sql = "SELECT m.id_menu,
					   m.lang_key_rotule
				  FROM acm_menu m 
			INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
				 WHERE ug.id_user_group = '$id_group'
			  ORDER BY m.id_menu_parent, m.order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
