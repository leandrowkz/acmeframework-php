<?php
/**
* -------------------------------------------------------------------------------------------------
* Access Helper
*
* Centraliza funções relativas ao controle de acesso da aplicação, como validação de sessão e 
* permissões.
*
* A chamada das funções contidas neste arquivo ajudante são alias para os métodos de mesmo nome
* localizados na respectiva biblioteca (Access). Sendo assim, as instruções abaixo retornam o mesmo
* resultado esperado:
*
* @example	
*		example_function(); // função localizada neste arquivo
* 		$this->access->example_function();
* 
* @since 	15/07/2013
*
* -------------------------------------------------------------------------------------------------
*/

/**
* validate_session()
* Valida a sessão. Retorna true caso logado, redireciona para pagina inicial caso nao logado.
* @return mixed boolean
*/
function validate_session()
{
	$CI =& get_instance();
	return $CI->access->validate_session();
}

/**
* browser_rank()
* Retorna lista de browsers que acessaram o sistema e a porcentagem de acesso de cada um.
* Utilizado no dashboard do sistema.
* @return array browsers
*/
function browser_rank()
{
	$CI =& get_instance();
	return $CI->access->browser_rank();
}

/**
* validate_permission()
* Valida uma permissão com base na permissao e modulo encaminhados (permissao do usuario logado
* para o modulo encaminhado). Exibe página de erro de permissão ou booleano quando parametro
* de teste de permissao é encaminhado.
* @param string module
* @param string permission
* @param boolean exib_page
* @param integer id_user
* @return mixed has_permission
*/
function validate_permission($module = '', $permission = '', $exib_page = true, $id_user = 0)
{
	$CI =& get_instance();
	return $CI->access->validate_permission($module, $permission, $exib_page, $id_user);
}