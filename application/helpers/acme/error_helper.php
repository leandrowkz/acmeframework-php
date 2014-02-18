<?php
/**
* -------------------------------------------------------------------------------------------------
* Error Helper
*
* Centraliza funções relativas ao uso de erros na aplicação. Utiliza os métodos da biblioteca
* Error, do ACME Engine.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Error). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->error->example_function();
* 
* @since		15/07/2013
* @location		acme.helpers.error
*
* -------------------------------------------------------------------------------------------------
*/

/**
* show_error_()
* Exibe uma página de erro conforme parametros encaminhados.
* @param string header
* @param string message
* @param string template
* @param string status_code
* @return void
*/
function show_error_($header = '', $message = '', $template = 'error_general', $status_code = 500, $log_error = true)
{
	$CI =& get_instance();
	$CI->error->show_error($header, $message, $template, $status_code, $log_error);
}

/**
* show_exception_page()
* Exibe uma página com uma mensagem de exceção, apenas. Quando informado o segundo parametro, 
* a página exibirá um botão inferior o qual conterá um link de volta.
* @param string message
* @return void
*/
function show_exception_page($message = '', $link_to_back = '')
{
	$CI =& get_instance();
	$CI->error->show_exception_page($message, $link_to_back);
}

/**
* show_exception_message()
* Exibe uma mensagem de exceção, sem página master ou algo do tipo. Ideal para modais. Quando 
* informado o segundo parametro, a página exibirá conteúdo html adicional, após a mensagem.
* @param string message
* @param string additional_html
* @return void
*/
function show_exception_message($message = '', $additional_html = '')
{
	$CI =& get_instance();
	$CI->error->show_exception_message($message, $additional_html);
}

/**
* show_php_error()
* Box de erro ou warning do PHP.
* @param string severity
* @param string message
* @param string filepath
* @param string line
* @return void
*/
function show_php_error($severity = '', $message = '', $filepath = '', $line = 0)
{
	$CI =& get_instance();
	$CI->error->show_php_error($severity, $message, $filepath, $line);
}

/**
* show_404()
* Página de erro 404.
* @return void
*/
function show_404_()
{
	$CI =& get_instance();
	$CI->error->show_404();
}