<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Model App_module_manager_model
 *
 * Database layer for the controller app_module_manager.
 *
 * @since 	03/11/2012
 * --------------------------------------------------------------------------------------------------
 */
class App_module_manager_model extends CI_Model {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns fields form data. Used on config page.
	 *
	 * @param int id_form
	 * @param string table
	 * @return array fields
	 */
	public function get_form_fields($id_form = 0, $table = '')
	{
		// Build query according with driver
		switch (strtolower(DB_DRIVER))
		{
			// MySQL driver
			case 'mysql':
			case 'mysqli':
				$sql = "SELECT DISTINCT
							   c.column_name,
							   c.column_key,
							   'N' AS column_not_exists,
							   c.ordinal_position,
							   f.*
						  FROM information_schema.columns c
					 LEFT JOIN acm_module_form_field      f on (f.table_column = c.column_name and f.id_module_form = $id_form)
						 WHERE c.table_name = '$table'
						   AND c.table_schema = '" . $this->db->database . "'

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
			break;

			// Postgre driver
			case 'postgre':
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
			break;

			// Oracle driver
			case 'oci8':
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
			break;
		}

		// Return fields
		return $this->db->query($sql)->result_array();
	}
}
