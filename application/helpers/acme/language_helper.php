<?php
/**
* -------------------------------------------------------------------------------------------------
* Language Helper
*
* Centraliza funções de linguagem da aplicação, que estarão disponíveis em todo controlador
* derivado de Acme_Core_Controller.
* 
* @since		03/10/2012
* @location		acme.helpers.language
*
* -------------------------------------------------------------------------------------------------
*/

/**
* lang()
* Traduz um indice localizado no array $lang do arquivo de linguagem carregado por ultimo.
* Este arquivo está localizado em application/language/LANGUAGE_ATUAL_SESSION/acme_global_lang.php
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