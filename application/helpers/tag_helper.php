<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Helper Tag
 *
 * Gathers functions related with application tags.
 *
 * An app tag is every tag as {URL_ROOT} or {URL_IMG} inside a text. You can replace this tags by
 * the corresponding value, in this case, URL_ROOT and URL_IMG constant values.
 *
 * These functions are aliases to the same method names of tag library.
 *
 * @example
 *     // Function of this helper
 *     example_function();
 *
 *     // Equivalent call
 *     $this->tag->example_function();
 * @since 	15/07/2013
 * --------------------------------------------------------------------------------------------------
 */

/**
 * Replaces all tag ocurrences by their respective values inside a string.
 *
 * Example:
 *     tag_replace('{URL_ROOT}/app-dashboard') => URL_ROOT constant value + /app-dashboard
 *
 * @param string string
 * @return mixed result
 */
function tag_replace($string = '')
{
	$CI =& get_instance();
	return $CI->tag->tag_replace($string);
}

/**
 * Replaces an specific tag as {NUMBER OR COLUMN_NAME} by the equivalent value inside an array.
 *
 * Example:
 *      $param_1 = String 'http://foobar.com/form/edit/{0}';
 *      $param_2 = Array ('id' => 1, 'label' => 'my_label', 'email' => 'some@some.com');
 *      echo array_tag_replace($param_1, $param_2);
 *      // will reproduce http://foobar.com/form/edit/1
 *
 * @param string value
 * @param array arr_data
 * @return string new_string
 */
function array_tag_replace($value = null, $arr_data = array())
{
	$CI =& get_instance();
	return $CI->tag->array_tag_replace($value, $arr_data);
}
