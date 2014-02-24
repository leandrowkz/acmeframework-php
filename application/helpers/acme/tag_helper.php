<?php
/**
* -------------------------------------------------------------------------------------------------
* Tag Helper
*
* Centraliza funções quanto a utilização de tags na aplicação, que estarão disponíveis em todo 
* controlador derivado de Acme_Core_Controller.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Tag). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->tag->example_function();
* 
* @since		24/10/2012
* @location		acme.helpers.tag
* -------------------------------------------------------------------------------------------------
*/

/**
* tag_replace()
* Este método faz replace de n instruções localizadas dentro de uma tag pelo resultado destas 
* instruções. Caso a na string encaminhada como parametro não exista uma tag válida para fazer 
* replace, retorna a string sem modificações.
* Veja o exemplo:
* String contendo a tag: <acme eval=" URL_IMG " />
* Resultado: URL_IMG substituído
* @param string string
* @param array variables
* @return mixed result
*/
function tag_replace($string = '')
{
	// Objeto CI
	$codeigniter =& get_instance();
	
	// Carrega classe padrão de manipulação de tags
	$codeigniter->load->library('acme/tag');
	
	// Retorna valor padrão utilizando função da biblioteca tag
	return $codeigniter->tag->tag_replace($string);
}

/**
* replace_tag()
* Faz a substituição do valor {NUMERO_COLUNA} em uma string por um valor de 
* um íncide de array.
* @param string value
* @param array data 
* @return string new_string
*/
function replace_tag($value = null, $arr_data = array())
{
	// Objeto CI
	$codeigniter =& get_instance();
	
	// Carrega classe padrão de manipulação de tags
	$codeigniter->load->library('acme/tag');
	
	// Retorna valor padrão utilizando função da biblioteca tag
	return $codeigniter->tag->replace_tag($value, $arr_data);
}

/**
* replace_define_constant()
* Faz a substituição do valor {DEFINE_CONSTANT} pelo valor correspondente da constante.
* @param string value 
* @return mixed constant
*/
function replace_define_constant($value = '')
{
	// Objeto CI
	$codeigniter =& get_instance();
	
	// Carrega classe padrão de manipulação de tags
	$codeigniter->load->library('acme/tag');
	
	// Retorna valor padrão utilizando função da biblioteca tag
	return $codeigniter->tag->replace_define_constant($value);
}