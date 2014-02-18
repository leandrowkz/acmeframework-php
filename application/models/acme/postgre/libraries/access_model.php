<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Access_Model
*
* Abstração da camada modelo (banco de dados) para acesso ao sistema.
* 
* @since		04/10/2012
* @location		acme.models.access_model
*
*/
class Access_Model extends CI_Model {
	// Definição de Atributos
	
	/**
	* __construct()
	* Construtor de classe. Chama o construtor pai, que abre uma conexão com
	* o banco de dados, automaticamente.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
						   u.url_img,
						   ug.name as user_group,
						   uc.url_default,
						   uc.lang_default
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
	
	/**
	* browser_rank()
	* Retorna o ranking de acessos por browser no sistema.
	* @return array data
	*/
	public function browser_rank()
	{
		// Retorna o nome da coluna primária conforme o tipo de banco
		switch(strtolower($this->db->dbdriver))
		{
			// MySQL and Postgre
			case 'mysql':
			case 'postgre':
			default:
				$sql = "SELECT x.browser_name,
							   x.acessos,
							   ((x.acessos * 100) / x.total_acessos) as prcnt
						 FROM (
								SELECT DISTINCT 
									  browser_name, 
									  IFNULL(COUNT(*), 0) AS acessos,
									  (SELECT COUNT(*) FROM acm_log WHERE action = 'login') AS total_acessos
								 FROM acm_log 
								WHERE action = 'login'
							 GROUP BY browser_name
							   ) x ORDER BY prcnt DESC";
			break;
			
			// Oracle
			case 'oci8':
				$sql = "SELECT x.browser_name,
							   x.acessos,
							   ((x.acessos * 100) / x.total_acessos) as prcnt
						 FROM (
								SELECT DISTINCT 
									  browser_name, 
									  NVL(COUNT(*), 0) AS acessos,
									  (SELECT COUNT(*) FROM acm_log WHERE action = 'login') AS total_acessos
								 FROM acm_log 
								WHERE action = 'login'
							 GROUP BY browser_name
							   ) x ORDER BY prcnt DESC";
			break;
		}
		// Run query
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_user_permission()
	* Retorna contador de permissoes de usuario conforme parametros encaminhados.
	* @param string module
	* @param string permission
	* @param integer id_user
	* @return integer count(data)
	*/
	public function get_user_permission($module = '', $permission = '', $id_user = 0)
	{
		$sql = "SELECT COUNT(*) AS permission 
  				  FROM acm_user_permission up
			INNER JOIN acm_module_permission mp on (mp.id_module_permission = up.id_module_permission)
			INNER JOIN acm_module m on (m.id_module = mp.id_module)
				 WHERE up.id_user = $id_user
				   AND m.controller = '$module'
				   AND mp.permission = '$permission'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? get_value($data[0], 'permission') : array();
	}
	
}
