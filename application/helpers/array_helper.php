<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Helper Array
 *
 * Gathers functions related with arrays and array manipulation.
 *
 * @since 	15/07/2013
 * --------------------------------------------------------------------------------------------------
 */

/**
 * Returns an array value even index exist or not. If the index does not exist then
 * this function returns an empty string ''.
 *
 * @param array data
 * @param string indexes 	// it can be case-insensitive
 * @return mixed value
 */
function get_value($data = null, $index = null)
{
	$value = '';

	if (!is_null($data) && !is_null($index) && is_array($data))
	{
		// Puts all indexes to lower case
		$arr_aux = array_change_key_case($data, CASE_LOWER);

		// Gets properly value
		$value = isset( $arr_aux[strtolower($index)] ) ? $arr_aux[strtolower($index)] : '';
	}

	return $value;
}

/**
 * This function is the same of array_change_key_case() except this does not care
 * if the array is multidimensional or not.
 *
 * @param array array
 * @param const case 	// Like CASE_UPPER or CASE_LOWER
 * @return array new array
 */
function array_change_key_case_recursive($array, $case)
{
	$array = array_change_key_case($array, $case);

	foreach ($array as $key => $value)
		if ( is_array($value) )
			$array[$key] = array_change_key_case_recursive($value, $case);

	return $array;
}
