<?php
/**
* --------------------------------------------------------------------------------------------------
* 
* Helper Access
*
* Gathers functions related with application access. 
*
* These functions are aliases to the same method names of access library.
*
* @example	// Function of this helper	
*			example_function();
*
*			// Equivalent call
* 			$this->access->example_function();
* 
* @since 	15/07/2013
*
* --------------------------------------------------------------------------------------------------
*/

/**
* validate_session()
* Validates the session. Returns true if user is logged or redirect to login page if it does not.
* @return mixed boolean
*/
function validate_session()
{
	$CI = get_instance();
	return $CI->access->validate_session();
}

/**
* check_session()
* Validates the session. Returns true true or false if user is logged or not.
* @return mixed boolean
*/
function check_session()
{
	$CI = get_instance();
	return $CI->access->check_session();
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
function check_permission($module = '', $permission = '', $id_user = 0)
{
	$CI = get_instance();
	return $CI->access->check_permission($module, $permission, $id_user);
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
function validate_permission($module = '', $permission = '', $id_user = 0)
{
	$CI = get_instance();
	return $CI->access->validate_permission($module, $permission, $id_user);
}