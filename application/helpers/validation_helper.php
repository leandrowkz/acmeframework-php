<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Helper Validation
 *
 * Gathers functions related with validations.
 *
 * These functions are aliases to the same method names of validation library.
 *
 * @example
 * 		// Function of this helper
 * 		example_function();
 *
 * 		// Equivalent call
 * 		$this->validation->example_function();
 *
 * @since 	15/07/2013
 * --------------------------------------------------------------------------------------------------
 */

/**
 * Checks if the given value is on format DD/MM/YYYY.
 *
 * @param string value
 * @return boolean valid
 */
function is_date_format($value = null)
{
	$CI =& get_instance();
	return $CI->validation->is_date_format($value);
}

/**
 * Checks if the given value is on format YYYY-MM-DD.
 *
 * @param string value
 * @return boolean valid
 */
function is_date_format_db($value = null)
{
	$CI =& get_instance();
	return $CI->validation->is_date_format_db($value);
}

/**
 * Checks if the given value is a valid class name.
 *
 * @param string name
 * @return boolean valid
 */
function is_class_name($name = null)
{
	$CI =& get_instance();
	return $CI->validation->is_class_name($name);
}

/**
 * Checks if the given value is a valid variable name.
 *
 * @param string name
 * @return boolean valid
 */
function is_variable_name($name = null)
{
	$CI =& get_instance();
	return $CI->validation->is_variable_name($name);
}

/**
 * Checks if the given value is a valid double.
 *
 * @param double number
 * @return boolean valid
 */
function is_double_($number = null)
{
	$CI =& get_instance();
	return $CI->validation->is_double_($number);
}

/**
 * Checks if the given value is a valid float.
 *
 * @param double number
 * @return boolean valid
 */
function is_float_($number = null)
{
	$CI =& get_instance();
	return $CI->validation->is_float_($number);
}

/**
 * Checks if the given value is a valid currency value.
 *
 * @param double number
 * @return boolean valid
 */
function is_currency($number = null)
{
	$CI =& get_instance();
	return $CI->validation->is_currency($number);
}

/**
 * Checks if the given value is a valid integer.
 *
 * @param int number
 * @return boolean Valid
 */
function is_integer_($number = null)
{
	$CI =& get_instance();
	return $CI->validation->is_integer_($number);
}

/**
 * Checks if the given value is a valid alfa numeric value.
 *
 * @param string word
 * @return boolean valid
 */
function is_alfa($word = null)
{
	$CI =& get_instance();
	return $CI->validation->is_alfa($word);
}

/**
 * Checks if the given value is only letters value.
 *
 * @param string word
 * @return boolean valid
 */
function is_letter($word = null)
{
	$CI =& get_instance();
	return $CI->validation->is_letter($word);
}

/**
 * Checks if the given parameters match.
 *
 * @param mutable value_one
 * @param mutable value_two
 * @return boolean valid
 */
function is_equal($value_one = null, $value_two = null)
{
	$CI =& get_instance();
	return $CI->validation->is_equal($value_one, $value_two);
}

/**
 * Checks if the given value is a valid email.
 *
 * @param string email
 * @return boolean valid
 */
function is_email($email = null)
{
	$CI =& get_instance();
	return $CI->validation->is_email($email);
}

/**
 * Checks if the given value is a valid ip v4 address.
 *
 * @param string ip
 * @return boolean valid
 */
function is_ip_v4($ip = null)
{
	$CI =& get_instance();
	return $CI->validation->is_ip_v4($ip);
}

/**
 * Checks if the given value is a valid roman number.
 *
 * @param string number
 * @return boolean valid
 */
function is_roman($number = null)
{
	$CI =& get_instance();
	return $CI->validation->is_roman($number);
}

/**
 * Checks if the given value is empty even if was an empty string.
 *
 * @param mutable value
 * @return boolean valid
 */
function is_empty($value = null)
{
	$CI =& get_instance();
	return $CI->validation->is_empty($value);
}

/**
 * Checks if the given value length is between $ini and $end.
 *
 * Example:
 * 		length('abc',0,3)  == TRUE
 * 		length('1274',0,3) == FALSE
 *
 * @param mixed value
 * @param int ini
 * @param int end
 * @return boolean valid
 */
function length($value = null, $ini = null, $end = null)
{
	$CI =& get_instance();
	return $CI->validation->length($value, $ini, $end);
}

/**
 * Checks if the given value length is until $length.
 *
 * Example:
 * 		min_length('abc', 3) == TRUE
 * 		min_length('1274',3) == FALSE
 *
 * @param mixed value
 * @param integer length
 * @return boolean valid
 */
function min_length($value = null, $length = null)
{
	$CI =& get_instance();
	return $CI->validation->min_length($value, $length);
}

/**
 * Checks if the given value length is more than $length.
 *
 * Example:
 * 		maxLength('abc', 2) == FALSE
 * 		maxLength('1274',3) == TRUE
 *
 * @param mixed value
 * @param integer length
 * @return boolean valid
 */
function max_length($value = null, $length = null)
{
	$CI =& get_instance();
	return $CI->validation->max_length($value, $length);
}

/**
 * Checks if the given value is between $ini and $end.
 *
 * Example:
 * 		between('99',0,100) == TRUE
 * 		between('10',0,3) == FALSE
 *
 * @param integer number
 * @param integer ini
 * @param integer end
 * @return boolean valid
 */
function between($number = null, $ini = null, $end = null)
{
	$CI =& get_instance();
	return $CI->validation->between($number, $ini, $end);
}

/**
 * Checks if the given value is a hexadecimal.
 *
 * @param string hexa
 * @return boolean valid
 */
function is_hexa($hexa = null)
{
	$CI =& get_instance();
	return $CI->validation->is_hexa($hexa);
}

/**
 * Checks if the given value is only special chars.
 *
 * @param string word
 * @return boolean valid
 */
function is_special_char($word = null)
{
	$CI =& get_instance();
	return $CI->validation->is_special_char($word);
}

/**
 * Checks if the given value is a valid hexadecimal color.
 *
 * @param string hexa
 * @return boolean valid
 */
function is_hexa_color($hexa = null)
{
	$CI =& get_instance();
	return $CI->validation->is_hexa_color($hexa);
}

/**
 * Checks if the given value is a valid CPF number.
 *
 * @param integer cpf
 * @return boolean valid
 */
function is_cpf($cpf = null)
{
	$CI =& get_instance();
	return $CI->validation->is_cpf($cpf);
}

/**
 * Checks if the given value is a valid CNPJ number.
 *
 * @param integer cnpj
 * @return boolean is_valid
 */
function is_cnpj($cnpj = null)
{
	$CI =& get_instance();
	return $CI->validation->is_cnpj($cnpj);
}

/**
 * Checks if the given value is a valid SSN number.
 *
 * @param string ssn
 * @return boolean valid
 */
function is_ssn($ssn)
{
	$CI =& get_instance();
	return $CI->validation->is_ssn($ssn);
}
