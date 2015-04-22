<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Template_Model
*
* Database layer for the library template.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Template_Model extends CI_Model {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* get_menus()
	* Returns all available application menus for an user according with its group.
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
