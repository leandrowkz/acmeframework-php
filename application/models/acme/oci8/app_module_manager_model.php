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
		$sql = "SELECT c.column_name,
				       CASE WHEN 
				       (SELECT COUNT(*) 
				          FROM all_constraints cons 
				    INNER JOIN all_cons_columns cols ON (cons.constraint_name = cols.constraint_name and cols.owner = cons.owner) 
				         WHERE cols.table_name = c.table_name 
				           AND cols.column_name = c.column_name 
				           AND cons.constraint_type = 'P'
				       ) > 0 THEN 'PRI' END AS column_key,
					   c.column_id AS ordinal_position,
					   'Y' AS column_exists,
					   f.*
				  FROM user_tab_cols c
			 LEFT JOIN acm_module_form_field f on (UPPER(f.table_column) = UPPER(c.column_name) AND f.id_module_form = $id_form)
				 WHERE UPPER(table_name) = '" . strtoupper($table) . "'

			  UNION
				
				/* fields that are in form but aren't on table query above */
				SELECT DISTINCT
					   f.table_column,
					   '' as column_key,
					   10000 AS ordinal_position,
					   'N' AS column_exists,
					   f.*
				  FROM acm_module_form_field f
				 WHERE UPPER(f.table_column) NOT IN (SELECT UPPER(c.column_name) FROM user_tab_cols c WHERE c.table_name = '" . strtoupper($table) . "')
				   AND f.id_module_form = $id_form
				   
			  ORDER BY ordinal_position ASC";

		// Return this motherfucker fields!
		return $this->db->query($sql)->result_array();
	}
}
