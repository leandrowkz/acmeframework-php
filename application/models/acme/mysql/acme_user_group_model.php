<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_User_Group_Model
*
* Gerencia camada de dados do módulo de grupos de usuários do sistema.
* 
* @since		26/06/2013
* @location		acme.models.acme_user_group_model
*
*/
class Acme_User_Group_Model extends Base_Module_Model {
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
	* get_user_groups()
	* Retorna um array de grupos de usuários cadastrados no banco de dados.
	* @return array groups
	*/
	public function get_user_groups()
	{
		$sql = "SELECT * FROM acm_user_group ORDER BY name";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_user_group()
	* Retorna um grupo de usuário com base no id_encaminhado.
	* @param int id
	* @return array group
	*/
	public function get_user_group($id_group = '')
	{
		$sql = "SELECT * FROM acm_user_group WHERE id_user_group = '$id_group'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_user_group_by_name()
	* Retorna um grupo de usuário com base no nome encaminhado.
	* @param string name
	* @return array group
	*/
	public function get_user_group_by_name($group = '')
	{
		$sql = "SELECT * FROM acm_user_group WHERE name = '$group'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_users_by_group()
	* Retorna quantidade de usuários cadastrados por grupo.
	* @return array groups
	*/
	public function get_users_by_group()
	{
		$sql = "SELECT g.name as group_name,
					   (SELECT COUNT(*) FROM acm_user u WHERE u.id_user_group = g.id_user_group) AS users
				  FROM acm_user_group g
			  ORDER BY g.name";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_all_group()
	* Retorna um array com todos os grupos.
	* @return array module
	*/
	public function get_all_group()
	{
		$sql = "SELECT id_user_group, name FROM acm_user_group order_ by name";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
