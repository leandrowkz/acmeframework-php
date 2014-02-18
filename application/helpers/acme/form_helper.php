<?php
/**
* -------------------------------------------------------------------------------------------------
* Form Helper
*
* Centraliza funções relativas ao uso de funcionalidades de formulários da aplicação. Utiliza os 
* métodos da biblioteca Form, do ACME Engine.
* 
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Form). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->form->example_function();
* 
* @since		15/07/2013
* @location		acme.helpers.form
*
* -------------------------------------------------------------------------------------------------
*/

/** 
* build_array_html_options()
* Monta um conjunto de tags html <option> com base em um array encaminhado como parametro. O array
* encaminhado deverá possuir dois indices em uma mesma linha, ao menos, sendo eles:
* Array [0] ( 
*			 [0] => VALUE
* 			 [1] => ROTULE
*			)
* Array [1] (
*			 [0] => VALUE
* 			 [1] => ROTULE
*			)
* @param array data
* @param value_to_select
* @param boolean blank_option
* @return string html
*/
function build_array_html_options($data = null, $value_to_selected = null, $blank_option = true)
{
	$CI =& get_instance();
	return $CI->form->build_array_html_options($data, $value_to_selected, $blank_option);
}

/** 
* build_array_options_by_separator()
* Monta um array de dados de opcoes explodindo string com base no separador ponto-e-virgula. 
* A primeira string será os indices que o array possuira e a segunda, seus values. Sendo assim
* as strings:
* => '1;2;3;4'
* => 'A;B;C;D'
* retornarao o array:
* [0] => 1
* [1] => A
* @param string indexs
* @param string values
* @return array options
*/
function build_array_options_by_separator($indexs = '', $values = '')
{
	$CI =& get_instance();
	return $CI->form->build_array_options_by_separator($indexs, $values);
}

/** 
* input_file()
* Monta um input tipo file que seja cross browser, ou seja, que funcione e possua as mesmas 
* características em todos os browsers.
* @param string id
* @param string name
* @param string class
* @param string value
* @param string javascript
* @return string html_input
*/
function input_file($id = '', $name = '', $class = '', $value = '', $javascript = '')
{
	$CI =& get_instance();
	return $CI->form->input_file($id, $name, $class, $value, $javascript);
}