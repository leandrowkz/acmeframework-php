<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Access
*
* Biblioteca de funções relacionadas ao acesso ao sistema, como validação de sessão ou
* permissões de módulo.
* 
* @since 	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Access {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	* validate_login()
	* Valida um login da aplicação. Espera usuário e senha, retorna false caso login nao exista,
	* array de dados do usuário caso exista.
	* @param string user
	* @param string pass
	* @return mixed data/false
	*/
	public function validate_login($user = '', $pass = '')
	{
		$this->CI->load->model('libraries/access_model');

		$arr_validate = $this->CI->access_model->validate_login($user, $pass);
		
		return (count($arr_validate) > 0) ? $arr_validate : false;
	}
	
	/**
	* validate_session()
	* Valida a sessão. Retorna true caso logado, redireciona para pagina inicial caso nao logado.
	* @return mixed boolean
	*/
	public function validate_session()
	{
		if( ! $this->check_session()) {
			redirect('/');
			exit;
		}
		return true;
	}

	/**
	* check_session()
	* Valida a sessão. Retorna true caso logado, falso caso não logado.
	* @return mixed boolean
	*/
	public function check_session()
	{
		if($this->CI->session->userdata('login_access') == '' || $this->CI->session->userdata('id_user') == '')
			return false;
		else
			return true;
	}
	
	/**
	* browser_rank()
	* Retorna lista de browsers que acessaram o sistema e a porcentagem de acesso de cada um.
	* @return array browsers
	*/
	public function browser_rank()
	{
		// Carrega model
		$this->CI->load->model('libraries/access_model');
		
		// Verifica se variáveis da sessão estão preenchidas
		return $this->CI->access_model->browser_rank();
	}

	/**
	* check_permission()
	* Checa uma permissão de módulo encaminhada para determinado usuário. Retorna true
	* caso o usuário possua a permissão, ou false caso não possua.
	* @param string module 		// controller name
	* @param string permission
	* @param integer id_user
	* @return boolean
	*/
	public function check_permission($module = '', $permission = '', $id_user = 0)
	{
		// Carrega model
		$this->CI->load->model('libraries/access_model');
		
		// Resolve iduser
		$id_user = ($id_user != 0) ? $id_user : $this->CI->session->userdata('id_user');
		
		// Checa permissão no banco de dados
		$count_permission = $this->CI->access_model->get_user_permission($module, $permission, $id_user);
		
		// Ajusta retorno
		return ($count_permission > 0) ? true : false;
	}
	
	/**
	* validate_permission()
	* Checa uma permissão de módulo encaminhada para determinado usuário. Retorna true
	* caso possua a permissão, ou redireciona para página de exceção caso não possua.
	* @param string module 		// controller name
	* @param string permission
	* @param integer id_user
	* @return mixed boolean/redirect
	*/
	public function validate_permission($module = '', $permission = '', $id_user = 0)
	{
		if( ! $this->check_permission($module, $permission, $id_user))
			$this->CI->error->show_error(lang('Usuário sem Permissão'), lang('Usuário sem permissão para esta ação') . ' (' . $permission . ')', 'error_permission', 500, false);
		else
			return false;
	}
}