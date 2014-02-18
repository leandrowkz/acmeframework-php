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
class Acme_Dashboard_Model extends Base_Module_Model {
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
	* get_list_modules()
	* Retorna um array de modulos cadastrados no sistema. Segundo parametro diz se é para
	* retornar modulos do acme ou não (chaveador entre modulos do acme e da aplicacao).
	* @param boolean show_acme_modules
	* @return array module
	*/
	public function get_list_modules($show_acme_modules = false)
	{
		$sql  = "SELECT * FROM acm_module ";
		$sql .= ($show_acme_modules) ? " WHERE controller LIKE '%acme_%' " : " WHERE controller NOT LIKE '%acme_%' ";
		$sql .= " ORDER BY lang_key_rotule";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
