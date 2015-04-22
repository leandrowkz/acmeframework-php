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
		$sql = "SELECT column_name 
				  FROM information_schema.columns
				 WHERE table_name = '" . $table . "'
				   AND column_key = 'PRI'";

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
		// Adjusts columns according with values
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
		// Adjusts columns according with values
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
