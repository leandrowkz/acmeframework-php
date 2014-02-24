<?php
/**
* -------------------------------------------------------------------------------------------------
* Array Helper
*
* Centraliza funções relativas a manipulação de arrays, que estarão disponíveis em todo controlador
* derivado de Acme_Core_Controller.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Arrays). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->arrays->example_function();
* 
* @since		24/10/2012
* @location		acme.helpers.array
*
* -------------------------------------------------------------------------------------------------
*/

/**
* get_value()
* Retorna um valor de um array, idependentemente do índice existir ou não. Caso o índice nao
* exista, retorna uma string vazia.
* @param array data
* @param string index
* @return mixed value
*/
function get_value($data = null, $index = null)
{
	$value = '';
	if(!is_null($data) && !is_null($index) && is_array($data))
	{
		// passa os indices do array encaminhado como param para lower case
		$arr_aux = array_change_key_case($data, CASE_LOWER);
		$value = (isset($arr_aux[strtolower($index)])) ? $arr_aux[strtolower($index)] : '';
	}
	return $value;
}

/**
* array_change_key_case_recursive()
* array_change_key_case() recursivo. Ideal para uso em resultsets.
* @param array array
* @param const case 	// Like CASE_UPPER or CASE_LOWER
* @return array nee
*/
function array_change_key_case_recursive($array, $case) 
{
  $array = array_change_key_case($array, $case);
  foreach ($array as $key => $value) {
    if ( is_array($value) ) {
      $array[$key] = array_change_key_case_recursive($value, $case);
    }
  }
  return $array;
}