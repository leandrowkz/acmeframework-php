<?php
/**
* -------------------------------------------------------------------------------------------------
* Template Helper
*
* Centraliza funções da biblioteca de templates da aplicação derivado de Acme_Base_Module.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Template). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->template->example_function();
* 
* @since		21/03/2013
* @location		acme.helpers.template
* -------------------------------------------------------------------------------------------------
*/

/**
* message()
* Retorna o componente html mensagem, que é montado conforme parametros encaminhados.
* @param string tipo
* @param string titulo
* @param string descricao
* @param boolean close
* @param string style
* @return string html_message
*/
function message($type = 'info', $title = '', $description = '', $close = false, $style = '')
{
	$CI =& get_instance();
	return $CI->template->message($type, $title, $description, $close, $style);
}

/**
* app_settings_inputs()
* Retorna configurações da aplicação no formato de inputs tipo hidden.
* @return string html
*/
function app_settings_inputs()
{
	$CI =& get_instance();
	return $CI->template->app_settings_inputs();
}

/**
* load_html_component()
* Carrega componente html de nome encaminhado. Espera-se que exista um diretorio, arquivo e 
* função de mesmo nome do que encaminhado. O segundo parametro é um array de parametros que 
* serão encaminhados à função.
* @param string component
* @param array config
* @return string html_menu
*/
function load_html_component($component = '', $params = array())
{
	$CI =& get_instance();
	return $CI->template->load_html_component($component, $params);
}

/**
* load_js_file()
* Carrega um arquivo js, retornando tag script. O nome do arquivo encaminhado como parametro
* não deve conter a extensão do arquivo.
* @param string file
* @return string html
*/
function load_js_file($file = '')
{
	$CI =& get_instance();
	return $CI->template->load_js_file($file);
}

/**
* load_css_file()
* Carrega um arquivo css, retornando tag <link...>. O nome do arquivo encaminhado como parametro
* pode não conter a extensão do arquivo.
* @param string file
* @return string html
*/
function load_css_file($file = '')
{
	$CI =& get_instance();
	return $CI->template->load_css_file($file);
}