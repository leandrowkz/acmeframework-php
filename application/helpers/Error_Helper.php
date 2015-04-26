<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Helper Error
 *
 * Gathers functions related with application error handling.
 *
 * These functions are aliases to the same method names of error library.
 *
 * @example
 *     // Function of this helper
 *     example_function();
 *
 *     // Equivalent call
 *     $this->error->example_function();
 *
 * @since 	15/07/2013
 * --------------------------------------------------------------------------------------------------
 */

/**
 * Shows a generic error page according with the forwarded parameters.
 *
 * @param string header
 * @param string message
 * @param string template
 * @param string status_code
 * @param boolean log_error
 * @return void
 */
function show_error_($header = '', $message = '', $template = 'error_general', $status_code = 500, $log_error = true)
{
	$CI =& get_instance();
	$CI->error->show_error($header, $message, $template, $status_code, $log_error);
}

/**
 * Shows an exception page according with given Exception object.
 *
 * @param Exception $exception
 * @return void
 */
function show_exception_(Exception $exception)
{
    $CI =& get_instance();
    $CI->error->show_exception($exception);
}

/**
 * Shows a HTML box containing a PHP error. The page proccess is not interrupted.
 *
 * @param string severity
 * @param string message
 * @param string filepath
 * @param string line
 * @param boolean log_error
 * @return void
 */
function show_php_error($severity = '', $message = '', $filepath = '', $line = 0, $log_error = true)
{
	$CI =& get_instance();
	$CI->error->show_php_error($severity, $message, $filepath, $line, $log_error);
}

/**
 * Shows a 404 error page.
 *
 * @return void
 */
function show_404_()
{
	$CI =& get_instance();
	$CI->error->show_404();
}
