<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Model ACME_Controller_Model
 *
 * Generic model layer for application base controller.
 *
 * @since 	26/03/2013
 * --------------------------------------------------------------------------------------------------
 */
class ACME_Controller_Model extends CI_Model {

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Returns the primary key name for the given table name.
	 *
	 * @param string table_name
	 * @return string pk
	 */
	public function get_pk_name($table = '')
	{
		// Build query according with driver
		switch (strtolower(DB_DRIVER))
		{
			// MySQL driver
			case 'mysql':
			case 'mysqli':
				$sql = "SELECT column_name
						  FROM information_schema.columns
						 WHERE table_name = '" . $table . "'
						   AND column_key = 'PRI'";
			break;

			// Postgre
			case 'postgre':
				$sql = "SELECT ccu.column_name
					      FROM information_schema.table_constraints         tc
					 LEFT JOIN information_schema.constraint_column_usage  ccu ON (ccu.constraint_name = tc.constraint_name)
						 WHERE tc.table_name   = '$table'
						   AND tc.constraint_type = 'PRIMARY KEY'";
			break;

			// Oracle driver
			case 'oci8':
				$sql = "SELECT cols.column_name
						  FROM all_constraints  cons
					INNER JOIN all_cons_columns cols ON (cons.constraint_name = cols.constraint_name AND cons.owner = cols.owner)
						 WHERE (cols.table_name = '" . strtoupper($table) . "' OR cols.table_name = '" . strtolower($table) . "')
						   AND cons.constraint_type = 'P'";
			break;
		}

		// Gets column name
		return get_value($this->db->query($sql)->row_array(0), 'column_name');
	}

	/**
	 * Inserts a record in a given table.
	 *
	 * @param string table
	 * @param array data
	 * @return mixed result
	 */
	public function insert($table = '', $data = array())
	{
		// Adjusts columns according with values
		foreach ($data as $column => $value)
		{
			if ($value == '')
			{
				$value = 'NULL';
				$escape = false;
			}

			else {
				$escape = true;

				// Adjust date values for Oracle driver
				if (is_date_format_db($value) && strtolower(DB_DRIVER) == 'oci8')
				{
					$escape = false;
					$value = "TO_DATE('" . $value . "', 'yyyy-mm-dd')";
				}
			}

			$this->db->set($column, $value, $escape);
		}

		return $this->db->insert($table);
	}

	/**
	 * Update one record or more according with given parameters.
	 *
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
			}

			else {
				$escape = true;

				// Adjust date values for Oracle driver
				if (is_date_format_db($value) && strtolower(DB_DRIVER) == 'oci8')
				{
					$escape = false;
					$value = "TO_DATE('" . $value . "', 'yyyy-mm-dd')";
				}
			}

			$this->db->set($column, $value, $escape);
		}

		$this->db->where($where);

		return $this->db->update($table);
	}
}
