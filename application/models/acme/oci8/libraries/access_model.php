<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model Access_Model
*
* Camada model para a biblioteca Access.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Access_Model extends CI_Model {
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* validate_login()
	* Valida um login (usuário e senha) encaminhado, verificando se existe no banco
	* de dados um registro de usuário equivalente. Retorna a tupla inteira do registro
	* do usuário em forma de array, ou array vazio caso não encontrado.
	* @param string user
	* @param string pass
	* @return array data
	*/
	public function validate_login($user = '', $pass = '')
	{
		$data = array();
		if(isset($user) && isset($pass) && $user != '' && $pass != '')
		{
			$sql = "SELECT u.id_user,
						   u.login,
						   u.email,
						   u.name AS user_name,
						   ug.name as user_group,
						   uc.url_default,
						   uc.lang_default,
						   uc.url_img
					  FROM acm_user u
				INNER JOIN acm_user_config uc ON (uc.id_user = u.id_user)
				INNER JOIN acm_user_group  ug ON (ug.id_user_group = u.id_user_group)
					 WHERE login = '" . $this->db->escape_like_str($user) . "' AND password = '" . $this->db->escape_like_str(md5($pass)) . "'
					   AND u.dtt_inative IS NULL";
			$data = $this->db->query($sql);
			$data = $data->result_array();
			$data = (isset($data[0])) ? $data[0] : array();
		}
		return $data;
	}
}
