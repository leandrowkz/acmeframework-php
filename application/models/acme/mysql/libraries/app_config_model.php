<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe App_Config_Model
*
* Gerencia camada modelo referente as configurações da aplicação. O conjunto de configurações da
* tabela acm_app_config é gerenciado aqui.
* 
* @since		24/10/2012
* @location		acme.models.app_config_model
*
*/
class App_Config_Model extends CI_Model {
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
	* get_app_config_db()
	* Retorna uma configuração da aplicação cadastrada no banco de dados, com base na chave inteligente
	* encaminhada. Isto é, localiza na tabela acm_app_config a configuração de config encaminhada.
	* @param string config
	* @return mixed config_value
	*/
	public function get_app_config_db($config = '')
	{
		$sql = "SELECT value FROM acm_app_config WHERE config = '" . $config . "'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? get_value($data[0], 'value') : '';
	}
	
	/**
	* get_app_configs_db()
	* Retorna array de configurações da tabela acm_app_config
	* @return array configs
	*/
	public function get_app_configs_db()
	{
		$sql = "SELECT * FROM acm_app_config";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
