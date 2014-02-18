<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Dashboard_Model
*
* Gerencia camada de dados do dashboard padrão do sistema.
* 
* @since		03/11/2012
* @location		acme.models.acme_dashboard_model
*
*/
class Acme_User_Model extends Base_Module_Model {
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
	}
	
	/**
	* get_list_permissions()
	* Retorna um array de permissões de um determinado usuário de id encaminhado. Segundo parametro 
	* diz se é para retornar modulos do acme ou não (chaveador entre modulos do acme e da aplicacao).
	* @param int id_user
	* @param boolean show_acme_modules
	* @return array permissions
	*/
	public function get_list_permissions($id_user = 0, $show_acme_modules = false)
	{
		$sql = "SELECT m.id_module,
					   m.lang_key_rotule as mod_lang_key_rotule, 
					   m.url_img,
					   m.description as mod_description,
                       mp.permission,
					   mp.id_module_permission,
					   mp.description as perm_description , 
					   mp.lang_key_rotule as perm_lang_key_rotule, 
                       CASE WHEN up.id_user_permission IS NOT NULL THEN 'S' ELSE 'N' END AS tem_permissao
				  FROM acm_module_permission  mp 
			 LEFT JOIN acm_module              m ON (mp.id_module = m.id_module)   
			 LEFT JOIN acm_user_permission    up ON (up.id_module_permission = mp.id_module_permission AND up.id_user = $id_user)
			 LEFT JOIN acm_user                u ON (u.id_user = up.id_user)";
		
		$sql .= ($show_acme_modules) ? " WHERE m.controller LIKE '%acme_%' " : " WHERE m.controller NOT LIKE '%acme_%' ";
		
		$sql .= "
			  ORDER BY m.controller, 
					   m.lang_key_rotule, 
					   mp.permission";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_user_data()
	* Retorna um array de dados do usuário de id encaminhado.
	* @param int id_user
	* @return array user
	*/
	public function get_user_data($id_user = 0)
	{	
		$sql = "SELECT u.*,
					   ug.name as grup,
					   ug.name as group_name,
					   uc.lang_default,
					   uc.url_default
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)
			     WHERE u.id_user = $id_user";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_user_data_by_login()
	* Retorna um array de dados do usuário de login encaminhado.
	* @param string login
	* @return array user
	*/
	public function get_user_data_by_login($login = '')
	{	
		$sql = "SELECT u.*,
					   ug.name as grup,
					   ug.name as group_name,
					   uc.lang_default,
					   uc.url_default
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)
			     WHERE u.login = '$login'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_users_to_html_options()
	* Retorna um array de usuários organizados por ordem alfabética, para ser utilizado em combos HTML.
	* @return array users
	*/
	public function get_users_to_html_options()
	{	
		$sql = "SELECT u.id_user,
						CONCAT(u.login, ' (', u.name, ')') AS name
				  FROM acm_user u
			  ORDER BY u.login";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* copy_permissions()
	* Copia permissões de um usuário para o outro.
	* @param int id_user_from
	* @param int id_user_to
	* @return boolean ok
	*/
	public function copy_permissions($id_user_from = 0, $id_user_to = 0)
	{	
		$sql = "INSERT INTO acm_user_permission (id_user, id_module_permission) SELECT $id_user_to, id_module_permission FROM acm_user_permission WHERE id_user = $id_user_from";
		return $this->db->query($sql);
	}
	
	/**
	* get_user_bookmark_data()
	* Retorna um array de dados de um favorito de usuario de id encaminahdo.
	* @param int id_user_bookmark
	* @return array bookmark
	*/
	public function get_user_bookmark_data($id_user_bookmark = 0)
	{	
		$sql = "SELECT ub.*, 
					   u.login 
				  FROM acm_user_bookmark ub 
			INNER JOIN acm_user 		  u ON (u.id_user = ub.id_user) 
		         WHERE id_user_bookmark = $id_user_bookmark";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* browser_rank_user()
	* Retorna o ranking de acessos por browser do usuário ao sistema dos últimos 6 meses. 
	* @param int id_user
	* @return array data
	*/
	public function browser_rank_user($id_user)
	{
		$sql = "SELECT distinct browser_name, EXTRACT(MONTH FROM CURRENT_DATE) as mes_atual,					   			 
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name) AS TOTAL_ACESSOS,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)) AS '1',
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)-1) AS '2',
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)-2) AS '3',
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)-3) AS '4',
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)-4) AS '5',
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM CURRENT_DATE)-5) AS '6',
						 EXTRACT(MONTH FROM CURRENT_DATE) AS   'nome_mes_1',
						 EXTRACT(MONTH FROM CURRENT_DATE)-1 AS 'nome_mes_2',
						 EXTRACT(MONTH FROM CURRENT_DATE)-2 AS 'nome_mes_3',
						 EXTRACT(MONTH FROM CURRENT_DATE)-3 AS 'nome_mes_4',
						 EXTRACT(MONTH FROM CURRENT_DATE)-4 AS 'nome_mes_5',
						 EXTRACT(MONTH FROM CURRENT_DATE)-5 AS 'nome_mes_6'     
				  FROM acm_log l
				  WHERE id_user = $id_user ";
			  
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
