<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model Access_Model
*
* Database layer for the library access.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Access_Model extends CI_Model {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* validate_login()
	* Validates an application user by email and pass. Return the database array register for 
	* this user or an empty array.
	* @param string email
	* @param string pass
	* @return array data
	*/
	public function validate_login($email = '', $pass = '')
	{
		$data = array();
		
		if(isset($email) && isset($pass) && $email != '' && $pass != '') {

			$sql = "SELECT u.id_user,
						   u.email,
						   u.name AS user_name,
						   ug.name as user_group,
						   uc.url_default,
						   uc.lang_default,
						   uc.url_img
					  FROM acm_user u
				 LEFT JOIN acm_user_config uc ON (uc.id_user = u.id_user)
				 LEFT JOIN acm_user_group  ug ON (ug.id_user_group = u.id_user_group)
					 WHERE email = '" . $this->db->escape_like_str($email) . "' AND password = '" . $this->db->escape_like_str(md5($pass)) . "'
					   AND u.dtt_inative IS NULL";
			
			$data = $this->db->query($sql)->row_array(0);
		}

		return $data;
	}

	/**
	* get_user_permission()
	* Returns a permission counter for a given user, permission and module. 
	* If COUNT(*) > 0 then user has the forwarded permission.
	* @param string module
	* @param string permission
	* @param integer id_user
	* @return integer count(data)
	*/
	public function get_user_permission($module = '', $permission = '', $id_user = 0)
	{
		$sql = "SELECT COUNT(*) AS permission 
  				  FROM acm_user_permission up
			INNER JOIN acm_module_permission mp on (mp.id_module_permission = up.id_module_permission)
			INNER JOIN acm_module m on (m.id_module = mp.id_module)
				 WHERE up.id_user = $id_user
				   AND m.controller = '$module'
				   AND mp.permission = '$permission'";

		$data = $this->db->query($sql)->row_array(0);
		
		return (isset($data)) ? get_value($data, 'permission') : array();
	}
}
