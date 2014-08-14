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
	* Class constructor.
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
	* Inserts a record in a given table.
	* @param string table
	* @param array data
	* @return mixed result
	*/
	public function insert($table = '', $data = array())
	{	
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;
			
			} else {
				$escape = true;
			}
			
			$this->db->set($column, $value, $escape);
		}
		
		return $this->db->insert($table);
	}
	
	/**
	* update()
	* Updates one record or more according with given parameters.
	* @param string table
	* @param array data
	* @param mixed where (it can be array('id' => $id)... or string "id = 1")
	* @return mixed result
	*/
	public function update($table = '', $data = array(), $where = array())
	{
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;

			} else {
				$escape = true;
			}
			
			$this->db->set($column, $value, $escape);
		}
		
		$this->db->where($where);
		
		return $this->db->update($table);
	}
}
