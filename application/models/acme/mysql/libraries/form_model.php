<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model Form_Model
*
* Database layer for the library form.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Form_Model extends CI_Model {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* get_field_meta_data()
	* Returns a field meta-data according with the given table and field.
	* @param string table
	* @param string column
	* @return array fields
	*/
	public function get_field_meta_data($table = '', $column_name = '')
	{
		$sql = "SELECT * 
				  FROM information_schema.columns c
			 LEFT JOIN (SELECT t2.column_name, 
							   t2.referenced_table_name, 
							   t1.constraint_type, 
							   t1.table_name
						  FROM information_schema.table_constraints t1
					 LEFT JOIN information_schema.key_column_usage  t2 ON (t2.constraint_name = t1.constraint_name and t1.table_name = t2.table_name)
					     WHERE t1.table_name = '$table' 
						   AND constraint_type = 'FOREIGN KEY') t2 ON (c.table_name = t2.table_name and t2.column_name = c.column_name)
			 	 WHERE c.table_name  = '$table'
				   AND c.column_name = '$column_name'";
		
		return $this->db->query($sql)->row_array(0);
	}
}
