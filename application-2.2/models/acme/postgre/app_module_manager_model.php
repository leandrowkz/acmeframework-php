<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model App_Module_Manager_Model
*
* Database layer for the controller app_module_manager.
* 
* @since 	03/11/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Module_Manager_Model extends CI_Model {
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* get_form_fields()
	* Returns fields form data. Used on config page.
	* @param int id_form
	* @param string table
	* @return array fields
	*/
	public function get_form_fields($id_form = 0, $table = '')
	{
		$sql = "SELECT DISTINCT
					   c.column_name,
					   pk.column_key,
					   'N' AS column_not_exists,
					   c.ordinal_position,
					   f.*
				  FROM information_schema.columns c
			 LEFT JOIN acm_module_form_field      f on (f.table_column = c.column_name and f.id_module_form = $id_form)

			 LEFT JOIN (SELECT CASE WHEN tc.constraint_type = 'PRIMARY KEY' THEN 'PRI' ELSE '' END AS column_key,
			 				   ccu.column_name
			 	 		  FROM information_schema.table_constraints         tc
					 LEFT JOIN information_schema.constraint_column_usage  ccu ON (ccu.constraint_name = tc.constraint_name)
					     WHERE tc.table_name   = '$table'
						   AND tc.constraint_type = 'PRIMARY KEY'
			 ) pk ON (pk.column_name = c.column_name)

				 WHERE c.table_name = '$table'
				   AND c.table_catalog = '" . $this->db->database . "'
							
			  UNION
				
				/* fields that are in form but aren't on table query above */
				SELECT DISTINCT
					   f.table_column,
					   '',
					   'Y' AS column_not_exists,
					   10000 AS ordinal_position,
					   f.*
				  FROM acm_module_form_field f
				 WHERE f.table_column NOT IN (SELECT c.column_name FROM information_schema.columns c WHERE c.column_name = f.table_column AND c.table_name = '$table')
				   AND f.id_module_form = $id_form
				   
			  ORDER BY ordinal_position";

		// Return this motherfucker fields!
		return $this->db->query($sql)->result_array();
	}
}
