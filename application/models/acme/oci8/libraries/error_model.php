<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Error_Model
*
* Abstração da camada modelo (banco de dados) para erros do sistema.
* 
* @since		30/10/2012
* @location		acme.models.error_model
*
*/
class Error_Model extends CI_Model {
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
	* insert_log_error()
	* Insere um registro de log de erro na tabela acm_log_error.
	* @param string template
	* @param string header
	* @param string message
	* @param string status_code
	* @return void
	*/
	public function insert_log_error($template = '', $header = '', $message = '', $status_code = '')
	{
		$arr = array();
		$arr['error_type'] = $template;
		$arr['header'] = $header;
		$arr['message'] = $message;
		$arr['status_code'] = $status_code;
		return $this->db->insert('acm_log_error', $arr);
	}
	
	/**
	* get_log_errors()
	* Retorna um resultset de erros inseridos na tabela acm_log_error.
	* @param string error_type
	* @param integer limit
	* @return void
	*/
	public function get_log_errors($error_type = '', $limit = 0)
	{
		$sql = '';
		
		// Define a consulta conforme tipo de banco
		switch(strtolower($this->db->dbdriver))
		{
			// MySQL and Postgre
			case 'mysql':
			case 'postgre':
			default:
				$sql  = "SELECT * FROM acm_log_error";
				$sql .= ($error_type != '') ? " WHERE error_type = '$error_type'" : '';
				$sql .= ' ORDER BY log_dtt_ins DESC ';
				$sql .= ($limit > 0) ? " LIMIT 0, $limit" : '';
			break;
			
			// Oracle
			case 'oci8':
				$sql  = "SELECT * FROM acm_log_error WHERE 1 = 1";
				$sql .= ($error_type != '') ? " AND error_type = '$error_type'" : '';
				$sql .= ($limit > 0) ? " AND ROWNUM <= $limit" : '';
				$sql .= ' ORDER BY log_dtt_ins DESC ';
			break;
		}
		
		// Run sql
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* count_distinct_errors()
	* Contagem total de erros considerados distintos um do outro, registrados até o momento, no 
	* sistema através do manipulador de erros.
	* @return void
	*/
	public function count_distinct_errors()
	{
		$sql = "SELECT COUNT(DISTINCT message) AS TOTAL FROM acm_log_error";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? get_value($data[0], 'TOTAL') : array();
	}
	
	/**
	* distinct_types()
	* Resultset de tipos distintos de erros.
	* @return void
	*/
	public function distinct_types()
	{
		$sql = "SELECT DISTINCT error_type FROM acm_log_error ORDER BY error_type";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_count_errors_by_type()
	* Resultset de quantidade de erros por tipo de erro.
	* @return void
	*/
	public function get_count_errors_by_type()
	{
		$sql = "SELECT e.error_type,
					   count(*) AS count_errors
				  FROM acm_log_error e
			  GROUP BY error_type";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
