<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Template_Model
*
* Camada model para a biblioteca Template.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Template_Model extends CI_Model {
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* get_menus()
	* Retorna o conjunto de menus do sistema com base no grupo de usuario informado.
	* @param string user_group
	* @return array menus
	*/
	public function get_menus($user_group = '')
	{
		$sql = "SELECT m.*,
					   NVL(id_menu_parent, 0) AS id_menu_parent
				  FROM acm_menu m 
			INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
				 WHERE ug.name = '$user_group'
			  ORDER BY m.id_menu_parent, m.order_";
		
		// Run SQL and return data
		return $this->db->query($sql)->result_array();
	}
}
