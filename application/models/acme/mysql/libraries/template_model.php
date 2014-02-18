<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Template_Model
*
* Gerencia dados que estarão disponíveis no template da aplicação, isto é, gerencia a camada
* de modelo do template da aplicação base, ACME Engine.
* 
* @since		22/10/2012
* @location		acme.models.template_model
*
*/
class Template_Model extends CI_Model {
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
	* get_menus()
	* Função que retorna o conjunto de menus do sistema, com base no grupo de usuario
	* encaminhado (string).
	* @param string user_group
	* @return array menus
	*/
	public function get_menus($user_group = '')
	{
		// Seleciona todo conjunto de menus em um unico resultset
		switch(strtolower($this->db->dbdriver))
		{
			case 'mysql':
			case 'postgre':
				$sql = "SELECT m.*,
							   IFNULL(id_menu_parent, 0) AS id_menu_parent
						  FROM acm_menu m 
					INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
						 WHERE ug.name = '$user_group'
						   AND m.dtt_inative IS NULL
					  ORDER BY m.id_menu_parent, m.order_";
			break;
			
			// Oracle
			case 'oci8':
				$sql = "SELECT m.*,
							   NVL(id_menu_parent, 0) AS id_menu_parent
						  FROM acm_menu m 
					INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
						 WHERE ug.name = '$user_group'
						   AND m.dtt_inative IS NULL
					  ORDER BY m.id_menu_parent, m.order_";
			break;
		}
		// Run SQL and return data
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_user_bookmarks()
	* Retorna um array de links favoritos gravados pelo usuário.
	* @param integer id_user
	* @return array bookmarks
	*/
	public function get_user_bookmarks($id_user = 0)
	{
		$sql = "SELECT * FROM acm_user_bookmark WHERE id_user = $id_user";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
