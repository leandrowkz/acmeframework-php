<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model ACME_Module_Controller_Model
*
* Generic model layer for application base controller.
* 
* @since 	26/03/2013
*
* --------------------------------------------------------------------------------------------------
*/
class ACME_Module_Controller_Model extends CI_Model {
	
	/**
	* __construct()
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	* get_pk_name()
	* Returns the primary key name for the given table name.
	* @param string table_name
	* @return string pk
	*/
	public function get_pk_name($table = '')
	{
		$sql = "SELECT ccu.column_name
			      FROM information_schema.table_constraints         tc
			 LEFT JOIN information_schema.constraint_column_usage  ccu ON (ccu.constraint_name = tc.constraint_name)
				 WHERE tc.table_name   = '$table'
				   AND tc.constraint_type = 'PRIMARY KEY'";

		return get_value($this->db->query($sql)->row_array(0), 'column_name');
	}
	
	/**
	* insert()
	* Insere registro na tabela do modulo.
	* @param array data
	* @return mixed result
	*/
	public function insert($data = array())
	{
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;
			} else {
				// Verifica se valor é date e o converte corretamente
				if(is_date_format($value))
				{ 
					$arrdate = explode('/', $value);
					$value = $arrdate[2] . '-' . $arrdate[1] . '-' . $arrdate[0];
				}
				$escape = true;
			}
			$this->db->set($column, $value, $escape);
		}
		$result = $this->db->insert($this->table);
		return $result;
	}
	
	/**
	* update()
	* Altera registro(s) na tabela do modulo.
	* @param array data
	* @param mixed where (pode ser array('id' => $id)... ou string "id = 1")
	* @return mixed result
	*/
	public function update($data = array(), $where = array())
	{
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;
			} else {
				// Verifica se valor é date e o converte corretamente
				if(is_date_format($value))
				{ 
					$arrdate = explode('/', $value);
					$value = $arrdate[2] . '-' . $arrdate[1] . '-' . $arrdate[0];
				}
				$escape = true;
			}
			$this->db->set($column, $value, $escape);
		}
		$this->db->where($where);
		$result = $this->db->update($this->table);
		return $result;
	}
}
