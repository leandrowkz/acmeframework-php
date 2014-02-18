<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Updater_Model (Arquivo gerado com construtor de módulos)
* 
* Módule Acme_Updater: 
*
* @since		15/07/2013
* @location		acme.models.Acme_Updater_model
*
*/
class Acme_Updater_Model extends CI_Model {
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
	* get_list_module()
	* Retorna listagem de dados da entrada do módulo.
	* @return array data
	*/
	public function get_list_module()
	{
		$sql = "SELECT p.version AS 'VERSÃO',
					   p.NAME AS NOME,
					   date_format(p.dtt_package_available, '%d/%m/%Y') AS 'DISPONÍVEL EM',
					   date_format(p.dtt_package_installed, '%d/%m/%Y') AS 'INSTALADO EM',
					   p.description AS 'DESCRIÇÃO',
					   p.version_father AS 'PACOTE PAI'
				  FROM acm_app_package_update p
			  ORDER BY p.dtt_package_available";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_package_data()
	* Retorna dados de um pacote de id encaminhado.
	* @param string version
	* @return array data
	*/
	public function get_package_data($version = '')
	{
		$sql = "SELECT * FROM acm_app_package_update WHERE version = '$version'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_package_errors()
	* Retorna dados de erros de um pacote de id encaminhado.
	* @param string version
	* @return array data
	*/
	public function get_package_errors($version = '')
	{
		$sql = "SELECT aue.order_  AS 'INSTRUÇÃO',
					   aue.message AS DESCRIPTION,
					   aue.*
				  FROM acm_app_package_update_error_message aue 
			INNER JOIN acm_app_package_update au ON (au.id_app_package_update = aue.id_app_package_update)	  
				 WHERE au.version = '$version' 
			  ORDER BY order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_package_dependencies()
	* Retorna dados de pacotes que são dependências do pacote de version encaminhado.
	* @param string version
	* @return array data
	*/
	public function get_package_dependencies($version = '')
	{
		$sql = "SELECT p.version AS 'VERSÃO',
					   p.id_app_package_update AS '#',
					   p.version_father AS 'PACOTE PAI',
					   p.name AS NOME,
					   p.path_file AS ARQUIVO,
					   date_format(p.dtt_package_available, '%d/%m/%Y') AS 'DISPONÍVEL EM',
					   date_format(p.dtt_package_installed, '%d/%m/%Y') AS 'INSTALADO EM', 
					   p.description AS 'DESCRIÇÃO'
			      FROM acm_app_package_update p WHERE version_father = '$version'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
