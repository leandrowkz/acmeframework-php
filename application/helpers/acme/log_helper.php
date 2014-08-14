<?php
/**
* --------------------------------------------------------------------------------------------------
* 
* Helper Log
*
* Gathers functions related with application logs and error logs. 
*
* These functions are aliases to the same method names of log library.
*
* @example	// Function of this helper	
*			example_function();
*
*			// Equivalent call
* 			$this->log->example_function();
* 
* @since 	15/07/2013
*
* --------------------------------------------------------------------------------------------------
*/

/**
* db_log()
* Saves a log on database (table acm_log). 
* @param string text_log
* @param string action
* @param string table
* @param array additional data 	// anything you consider relevant
* @return void
*/
function db_log($text_log = '', $action = '', $table = '', $additional_data = array())
{
	$CI =& get_instance();
	$CI->log->db_log($text_log, $action, $table, $additional_data = array());
}

/**
* log_error()
* Saves an error log on database (table acm_log_error). 
* @param string error_type
* @param string header
* @param string message
* @param string status_code
* @return void
*/
function log_error($error_type = '', $header = '', $message = '', $status_code = '')
{
	$CI =& get_instance();
	$CI->log->log_error($error_type, $header, $message, $status_code);
}