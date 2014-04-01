<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Tag Helper
*
* Joins all tag functions for application. This functions can be used on every class extended from
* ACME_Module_Controller.
*
* Invoking functions from here is an alias for the same call by the library tag. For example:
*
*		echo foo_bar();	// from any application point
*
* 		Is the same that:
*
*		echo $this->tag->foo_bar();
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/

/**
* tag_replace()
* Replace all tag ocurrences for their respective values inside a string.
* @param string string
* @return mixed result
*/
function tag_replace($string = '')
{
	$CI =& get_instance();
	$CI->load->library('acme/tag');
	return $CI->tag->tag_replace($string);
}

/**
* array_tag_replace()
* Replaces one tag with name {NUMBER OR COLUMN_NAME} by the value of an array followed
* $arr_data['NUMBER OR COLUMN_NAME'].
* @param string value
* @param array arr_data 
* @return string new_string
*/
function array_tag_replace($value = null, $arr_data = array())
{
	$CI =& get_instance();
	$CI->load->library('acme/tag');
	return $CI->tag->array_tag_replace($value, $arr_data);
}
