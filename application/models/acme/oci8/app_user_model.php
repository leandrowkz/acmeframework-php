<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model App_User_Model
*
* Camada model do modulo app_user.
* 
* @since 	03/11/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_User_Model extends CI_Model {
		
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
	* get_users()
	* Return an array list of users.
	* @return array user
	*/
	public function get_users()
	{	
		$sql = "SELECT u.*,
					   uc.*,
					   ug.name AS user_group
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)";
		return $this->db->query($sql)->result_array();
	}

	/**
	* get_user()
	* Retorna an array data of user of id refered.
	* @param int id_user
	* @return array user
	*/
	public function get_user($id_user = 0)
	{	
		$sql = "SELECT u.*,
					   ug.name as user_group,
					   uc.lang_default,
					   uc.url_default,
					   uc.url_img,
					   uc.url_img_large,
					   CASE WHEN u.dtt_inative IS NULL THEN 'Y' ELSE 'N' END AS ACTIVE
				  FROM acm_user u
			 LEFT JOIN acm_user_group  ug ON (u.id_user_group = ug.id_user_group)
			 LEFT JOIN acm_user_config uc ON (u.id_user = uc.id_user)
			     WHERE u.id_user = $id_user";

		return $this->db->query($sql)->row_array(0);
	}
	
	/**
	* get_permissions()
	* Return an array of permissions to user of refered id.
	* @param int id_user
	* @return array permissions
	*/
	public function get_permissions($id_user = 0)
	{
		$sql = "SELECT m.id_module,
					   m.label as module,
					   m.description as module_description,
					   mp.id_module_permission,
                       mp.permission,
					   mp.description as permission_observation , 
					   mp.label AS permission_description, 
                       CASE WHEN up.id_user_permission IS NOT NULL THEN 'Y' ELSE 'N' END AS has_permission
				  FROM acm_module_permission  mp 
			 LEFT JOIN acm_module              m ON (mp.id_module = m.id_module)   
			 LEFT JOIN acm_user_permission    up ON (up.id_module_permission = mp.id_module_permission AND up.id_user = $id_user)
			 LEFT JOIN acm_user                u ON (u.id_user = up.id_user)
			  ORDER BY m.controller, 
					   m.label, 
					   mp.permission";

		return $this->db->query($sql)->result_array();
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
	public function browser_rank_user($id_user = 0)
	{
		$sql = "SELECT distinct browser_name, EXTRACT(MONTH FROM SYSDATE) as mes_atual,					   			 
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name) AS TOTAL_ACESSOS,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)) AS acessos_mes_1,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)-1) AS acessos_mes_2,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)-2) AS acessos_mes_3,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)-3) AS acessos_mes_4,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)-4) AS acessos_mes_5,
						 (SELECT COUNT(*) FROM acm_log l2 WHERE action = 'login' and l2.browser_name = l.browser_name AND EXTRACT(MONTH FROM log_dtt_ins) = EXTRACT(MONTH FROM SYSDATE)-5) AS acessos_mes_6,
						 EXTRACT(MONTH FROM SYSDATE) AS   nome_mes_1,
						 EXTRACT(MONTH FROM SYSDATE)-1 AS nome_mes_2,
						 EXTRACT(MONTH FROM SYSDATE)-2 AS nome_mes_3,
						 EXTRACT(MONTH FROM SYSDATE)-3 AS nome_mes_4,
						 EXTRACT(MONTH FROM SYSDATE)-4 AS nome_mes_5,
						 EXTRACT(MONTH FROM SYSDATE)-5 AS nome_mes_6     
				  FROM acm_log l
				  WHERE id_user = $id_user ";
			  
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
