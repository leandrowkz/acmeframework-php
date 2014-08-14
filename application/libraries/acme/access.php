<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Access
*
* Gathers methods related with the application access.
* 
* @since 	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Access {
	
	public $CI = null;
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	* validate_login()
	* Validates an application login. Expect an email and password and returns the user data 
	* in case of true, or boolean in case of false.
	* @param string email
	* @param string pass
	* @return mixed user/false
	*/
	public function validate_login($email = '', $pass = '')
	{
		$this->CI->load->model('libraries/access_model');

		$user = $this->CI->access_model->validate_login($email, $pass);
		
		return (count($user) > 0) ? $user : false;
	}
	
	/**
	* validate_session()
	* Validates the session. Returns true if user is logged or redirect to login page if it does not.
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
	* check_session()
	* Validates the session. Returns true true or false if user is logged or not.
	* @return mixed boolean
	*/
	public function check_session()
	{
		if($this->CI->session->userdata('login_access') == '' || $this->CI->session->userdata('id_user') == '')
			return false;
		else
			return true;
	}

	/**
	* check_permission()
	* Verifies a single permission for the forwarded module and user. Returns true or false
	* if user has this permission or not.
	* @param string module 		// controller name
	* @param string permission
	* @param integer id_user
	* @return boolean
	*/
	public function check_permission($module = '', $permission = '', $id_user = 0)
	{
		$this->CI->load->model('libraries/access_model');
		
		// Resolve iduser
		$id_user = ($id_user != 0) ? $id_user : $this->CI->session->userdata('id_user');
		
		// Checks permission on database
		$count_permission = $this->CI->access_model->get_user_permission($module, $permission, $id_user);
		
		// Adjusts return
		return ($count_permission > 0) ? true : false;
	}
	
	/**
	* validate_permission()
	* Verifies a single permission for the forwarded module and user. Returns true if user
	* has this permission, or load an error permission page if user has not.
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