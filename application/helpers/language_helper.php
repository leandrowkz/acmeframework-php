<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Helper Language
 *
 * Gathers functions related with application language.
 *
 * @since 	15/07/2013
 * --------------------------------------------------------------------------------------------------
 */

/**
 * Translates an index located on array $lang inside of file
 * application/language/LANGUAGE/app_lang.php. If the key does not
 * have a translation then this function returns the key.
 *
 * @param string key
 * @param string $lang['key']
 */
function lang($key = '')
{
	$CI =& get_instance();
	$line = $CI->lang->line($key);
	$line = ($line == '') ? $key : $line;
	return $line;
}
