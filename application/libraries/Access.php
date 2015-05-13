<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Access
 *
 * Gather methods related with the application access.
 *
 * @since 	01/10/2012
 * --------------------------------------------------------------------------------------------------
 */
class Access {

	/**
	 * CI controller instance.
	 * @var object
	 */
	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Validates an application login. Expect an email and password and
	 * returns the user data in case of true, or boolean in case of false.
	 *
	 * @param string email
	 * @param string pass
	 * @return mixed user/false
	 */
	public function validate_login($email = '', $pass = '')
	{
		// Basic return
		$user = array();

		// Only check if given email and pass are valid
		if(isset($email) && isset($pass) && $email != '' && $pass != '')
		{
			// Load a database connection here
			$this->CI->load->database();

			// Builds query according with driver
			switch (strtolower(DB_DRIVER))
			{
				// ALl drivers
				case 'mysql':
				case 'mysqli':
				case 'postgre':
				case 'oci8':
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
							 WHERE email = '" . $this->CI->db->escape_like_str($email) . "'
							   AND password = '" . $this->CI->db->escape_like_str(md5($pass)) . "'
							   AND u.dtt_inative IS NULL";
				break;
			}

			// Gets user
			$user = $this->CI->db->query($sql)->row_array(0);
		}

		// Find user
		return count($user) > 0 ? $user : false;
	}

	/**
	 * Validates the session. Returns true if user is logged or redirect to
	 * login page if it does not.
	 *
	 * @return mixed boolean
	 */
	public function validate_session()
	{
		if( ! $this->check_session() ) {
			redirect('/');
			exit;
		}
		return true;
	}

	/**
	 * Validates the session. Returns true true or false if user is logged or not.
	 *
	 * @return boolean
	 */
	public function check_session()
	{
		if($this->CI->session->userdata('login_access') == '' || $this->CI->session->userdata('id_user') == '')
			return false;
		else
			return true;
	}

	/**
	 * Verify a single permission for the forwarded module and user. Returns
	 * true or false if user has this permission or not.
	 *
	 * @param string module 		// controller name
	 * @param string permission
	 * @param integer id_user
	 * @return boolean
	 */
	public function check_permission($module = '', $permission = '', $id_user = 0)
	{
		// Resolve iduser
		$id_user = ($id_user != 0) ? $id_user : $this->CI->session->userdata('id_user');

		// Builds query according with driver
		switch (strtolower(DB_DRIVER))
		{
			// All drivers
			case 'mysql':
			case 'mysqli':
			case 'postgre':
			case 'oci8':
				$sql = "SELECT COUNT(*) AS permission
		  				  FROM acm_user_permission up
					INNER JOIN acm_module_permission mp on (mp.id_module_permission = up.id_module_permission)
					INNER JOIN acm_module m on (m.id_module = mp.id_module)
						 WHERE up.id_user = $id_user
						   AND m.controller = '$module'
						   AND mp.permission = '$permission'";
			break;
		}

		// Load a database connection
		$this->CI->load->database();

		// Gets user permissions as array
		$data = $this->CI->db->query($sql)->row_array(0);
		$data = get_value($data, 'permission') != '' ? get_value($data, 'permission') : 0;

		// Adjusts return
		return ($data > 0) ? true : false;
	}

	/**
	 * Verify a single permission for the forwarded module and user. Returns true if user
	 * has this permission, or load an error permission page if user has not.
	 *
	 * @param string module 		// controller name
	 * @param string permission
	 * @param integer id_user
	 * @return mixed boolean/redirect
	 */
	public function validate_permission($controller = '', $permission = '', $id_user = 0)
	{
		if( ! $this->check_permission($controller, $permission, $id_user) )
			$this->CI->error->show_error(lang('User without permission'), lang('User without permission for this action') . ' (' . $permission . ')', 'error_permission', 500, false);
		else
			return false;
	}
}
