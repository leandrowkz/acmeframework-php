<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model App_user_model
*
* Database layer for the controller app_user.
*
* @since 	03/11/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_user_model extends CI_Model {

	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* get_users()
	* Return an array list of users.
	* @return array user
	*/
	public function get_users()
	{
		$sql = "SELECT u.*,
					   uc.*,
					   ug.name AS user_group
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)";

		return $this->db->query($sql)->result_array();
	}

	/**
	* get_user()
	* Returns an user array data according with the given id.
	* @param int id_user
	* @return array user
	*/
	public function get_user($id_user = 0)
	{
		$sql = "SELECT u.*,
					   ug.name as user_group,
					   uc.lang_default,
					   uc.url_default,
					   uc.url_img,
					   uc.url_img_large,
					   CASE WHEN u.dtt_inative IS NULL THEN 'Y' ELSE 'N' END AS active
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)
			     WHERE u.id_user = $id_user";

		return $this->db->query($sql)->row_array(0);
	}

	/**
	* get_permissions()
	* Returns an array of permissions from referenced user id.
	* @param int id_user
	* @return array permissions
	*/
	public function get_permissions($id_user = 0)
	{
		$sql = "SELECT m.id_module,
					   m.controller,
					   m.label as module,
					   m.description as module_description,
					   mp.id_module_permission,
                       mp.permission,
					   mp.description as permission_observation ,
					   mp.label AS permission_description,
                       CASE WHEN up.id_user_permission IS NOT NULL THEN 'Y' ELSE 'N' END AS has_permission
				  FROM acm_module_permission  mp
			 LEFT JOIN acm_module              m ON (mp.id_module = m.id_module)
			 LEFT JOIN acm_user_permission    up ON (up.id_module_permission = mp.id_module_permission AND up.id_user = $id_user)
			 LEFT JOIN acm_user                u ON (u.id_user = up.id_user)
			  ORDER BY m.controller,
					   m.label,
					   mp.permission";

		return $this->db->query($sql)->result_array();
	}

}
