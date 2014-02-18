<?php
/**
* -------------------------------------------------------------------------------------------------
* App_Config Helper
*
* Centraliza funções relativas ao uso de configurações da aplicação. Utiliza os métodos da biblioteca
* App_Config, do ACME Engine.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (App_Config). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*	example_function(); // função localizada neste arquivo
* 	$this->app_config->example_function();
* 
* @since		15/07/2013
* @location		acme.helpers.app_config
*
* -------------------------------------------------------------------------------------------------
*/

/**
* get_app_config_db()
* Retorna uma configuração da aplicação cadastrada no banco de dados, com base na chave inteligente
* encaminhada. Isto é, localiza na tabela acm_app_config a configuração de config encaminhada.
* @param string config
* @return mixed value
*/
function get_app_config_db($config = '')
{
	$CI =& get_instance();
	return $CI->app_config->get_app_config_db($config);
}

/**
* get_input_configurations()
* Retorna uma string contendo uma série de inputs HTML contendo o valor das configurações da
* aplicacao (arquivo settings). Ideal para utilização em view. O segundo parametro define se
* as configurações serão carregadas em modo seguro (recomendável). Desta forma, configurações
* internas como de banco de dados NÃO SERÃO CARREGADAS.
* @param boolean protected_mode
* @return string html_inputs
*/
function get_input_configurations($protected_mode = true)
{
	$CI =& get_instance();
	return $CI->app_config->get_input_configurations($protected_mode);
}