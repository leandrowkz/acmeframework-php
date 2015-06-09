<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Form
 *
 * Gathers methods related with application html forms.
 *
 * @since 	27/10/2012
 * --------------------------------------------------------------------------------------------------
 */
class Form {

	/**
	 * CI controller instance.
	 * @var object
	 */
	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct ()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Receives a resultset of inputs (from table acm_module_form_field) and transforms
	 * them into an array of html input elements, like:
	 *
	 * Array
	 * (
	 * 		[0] => '<label>Email</label><input type="text" name="acm_user[email]" id="email" />'
	 * 		[1] => '<label>Password</label><input type="text" name="acm_user[password]" id="password" />'
	 * 		[2] => ...
	 * )
	 *
	 * @param array fields
	 * @param array values
	 * @return array html_fields
	 */
	public function build_form_fields($fields = array(), $values = array())
	{
		$html_fields = array();

		if(count($fields) <= 0)
			return array();

		// Each field
		foreach($fields as $field) {

			// Build all attributes
			$field['value'] = get_value($values, get_value($field, 'table_column'));

			// add field
			array_push($html_fields, $this->CI->template->load_html_component('module-form-field', array('field' => $field)));

		}

		return $html_fields;
	}

	/**
	 * Builds a set of HTML tags <option> from a resultset array. This array must
	 * has two indexes, the first one is value will be placed on value attribute
	 * and the second one must be the label will be placed on option.
	 *
	 * Take an example:
	 * Array
	 * (
	 * 		[0] => Array ( [0] => VALUE, [1] => ROTULE )
	 * 		[1] => Array ( [0] => VALUE, [1] => ROTULE )
	 * )
	 *
	 * @param array data
	 * @param option_selected 		// Value must be set as selected="selected"
	 * @param boolean blank_option 	// true for inserting an initial blank <option>
	 * @return string html
	 */
	public function build_select_options($data = null, $option_selected = '', $blank_option = true)
	{
		$html = '';
		if(!is_null($data) && is_array($data))
		{
			// DEBUG:
			// print_r($data);

			if($blank_option)
			{
				$html .= '<option value=""';
				$html .= ($option_selected == '') ? ' selected="selected"></option>' : '></option>';
			}

			foreach($data as $row)
			{
				$row = array_values($row);
				$html .= '<option value="' . $row[0] . '"';
				$html .= ($option_selected == $row[0]) ? ' selected="selected">' : '>';
				$html .= array_key_exists(1, $row) ? $row[1] : $row[0];
				$html .= '</option>';
			}
		}
		return $html;
	}

	/**
	 * Receives two strings each one separated by semicolon and returns a single
	 * array of index => value containing this labels and values.
	 *
	 * Example:
	 * $indexes = '1;2;3;4';
	 * $values  = 'A;B;C;D';
	 *
	 * print_r( build_array_semicolon($indexes, $vales) );
	 *
	 * Will reproduce:
	 * Array
	 * (
	 * 		[1] => A,
	 * 		[2] => B ...
	 * )
	 *
	 * @param string indexes
	 * @param string values
	 * @return array options
	 */
	public function build_array_semicolon($indexes = '', $values = '')
	{
		$return = array();
		$arr_index = explode(';', $indexes);
		$arr_value = explode(';', $values);
		$count_index = count($arr_index);
		$count_value = count($arr_value);

		if(($count_index > 0 && $count_value > 0) && ($count_index == $count_value))
		{
			for($i = 0; $i < $count_index; $i++)
			{
				$return[$i]['key'] = $arr_index[$i];
				$return[$i]['value'] = $arr_value[$i];
			}
		}
		return $return;
	}

	/**
	 * Builds a validation string, used by plugin jquery.validationEngine.js and by all
	 * application forms validation.
	 *
	 * For more information see https://github.com/posabsolute/jQuery-Validation-Engine
	 *
	 * All validations must be forwarded separating each one by semicolon.
	 *
	 * Validation examples:
	 * 		=> required
	 * 		=> email
	 * 		=> phone
	 * 		=> url
	 * 		=> number
	 * 		=> integer
	 *
	 * The string value must be sent as: required;email;phone
	 *
	 * @param string validate
	 * @return string new_validate
	 */
	public function build_string_validation($validate = '')
	{
		$return = 'validate[';
		$part_one = '';
		$part_two = '';
		$part_thr = '';

		// Adjusts the validation string, separating each validation
		trim($validate, ';');
		$arr_validations = explode(';', $validate);
		$count_validations = count($arr_validations);

		// Starts to build the correct validation string
		for($i = 0; $i < $count_validations; $i++)
		{
			switch($arr_validations[$i])
			{
				// Required
				case 'required':
					$part_one .= $arr_validations[$i] . ',';
				break;

				// Custom regex
				case 'email':
				case 'fullname':
				case 'phone':
				case 'phone-us':
				case 'url':
				case 'integer':
				case 'decimal':
				case 'ipv4':
				case 'date':
				case 'date-us':
				case 'cpf':
				case 'cnpj':
				case 'time':
				case 'hour':
				case 'credit-card':
				case 'zip':
				case 'cep':
				case 'onlyNumberSp':
				case 'onlyLetterSp':
				case 'onlyLetterAccentSp':
				case 'onlyLetterNumber':
					$part_two .= $arr_validations[$i] . ',';
				break;

				// Others
				default:
					if(stristr($arr_validations[$i], 'equals'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'minCheckbox'))
						$part_two .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'maxCheckbox'))
						$part_two .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'min'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'max'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'past'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'future'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'minSize'))
						$part_one .= $arr_validations[$i] . ',';

					if(stristr($arr_validations[$i], 'maxSize'))
						$part_one .= $arr_validations[$i] . ',';
				break;
			}

			// OLDER
			// $return .= $arr_validations[$i] . ',';
			// if(strtolower($arr_validations[$i]) == "required")
		}

		// Builds the correct string from all parts
		$part_one = ($part_one != '') ? rtrim($part_one, ',') : $part_one;
		$part_two = ($part_two != '') ? rtrim($part_two, ',') : $part_two;
		$part_thr = ($part_thr != '') ? rtrim($part_thr, ',') : $part_thr;
		$return .= ($part_one != '') ? $part_one : '';
		$return .= ($part_two != '' && $part_one != '') ? ',custom[' . $part_two . ']' : '';
		$return .= ($part_two != '' && $part_one == '') ?  'custom[' . $part_two . ']' : '';
		$return .= ($part_thr != '' && ($part_two != '' || $part_one != '')) ? ',' . $part_thr : '';
		$return .= ($part_thr != '' && ($part_two == '' || $part_one == '')) ? $part_thr : '';
		$return .= ']';

		// Return something like validate[required,custom[email]]
		return $return;
	}

	/**
	 * Prepares and returns an array representing a valid row to be inserted
	 * on table acm_module_form_field. This array is builded from a CI object
	 * generated by the call $this->db->field_data(table).
	 *
	 * @param object obj_field
	 * @param string table
	 * @return array field
	 */
	public function build_field($obj_field = null, $table = '')
	{
		// Builds an array with all table columns
		$field = array();
		$field['id_module_form'] = 'NULL';
		$field['table_column'] = 'NULL';
		$field['type'] = 'NULL';
		$field['label'] = 'NULL';
		$field['description'] = 'NULL';
		$field['id_html'] = 'NULL';
		$field['class_html'] = 'NULL';
		$field['maxlength'] = 'NULL';
		$field['options_json'] = 'NULL';
		$field['options_sql'] = 'NULL';
		$field['style'] = 'NULL';
		$field['javascript'] = 'NULL';
		$field['masks'] = 'NULL';
		$field['validations'] = 'NULL';
		$field['order_'] = 'NULL';
		$field['dtt_inative'] = 'NULL';

		// Process field
		if(!is_null($obj_field))
		{
			// Gets from database other information about this column that CI doesnt supply
			$field_data = $this->_get_field_meta_data($table, $obj_field->name);

			// Fill basic data of field
			$field['table_column'] = $obj_field->name;
			$field['label'] = $obj_field->name;
			$field['id_html'] = $obj_field->name;
			$field['maxlength'] = $obj_field->max_length;
			$field['order_'] = get_value($field_data, 'ordinal_position') * 10;
			$field['validations'] = (get_value($field_data, 'is_nullable') != 'YES') ? 'required;' : '';

			// Set some specific data about the field
			switch( strtolower($obj_field->type) )
			{
				case 'char':
				case 'varchar':
				case 'varchar2':
				case 'longtext':
				case 'mediumtext':
				case 'tinytext':
					$field['type'] = 'text';
				break;

				case 'text':
					$field['type'] = 'textarea';
				break;

				case 'date':
				case 'datetime':
				case 'timestamp':
				case 'timestamptz':
					$field['type'] = 'text';
					$field['masks'] = 'date';
					$field['validations'] .= 'date';
					$field['description'] = lang('YYYY-MM-DD format');
				break;

				case 'time':
				case 'timetz':
					$field['type'] = 'text';
					$field['masks'] = 'time';
					$field['description'] = lang('HH:MM format');
				break;

				case 'int':
				case 'int2':
				case 'int4':
				case 'int8':
				case 'int16':
				case 'int32':
				case 'integer':
				case 'number':
				case 'bigint':
				case 'mediumint':
				case 'smallint':
				case 'tinyint':
					$field['type'] = 'text';
					$field['masks'] = 'integer';
					$field['validations'] .= 'integer';
					$field['description'] = lang('Only numbers');
				break;

				case 'float':
				case 'float2':
				case 'float4':
				case 'float8':
				case 'float16':
				case 'float32':
				case 'double':
				case 'decimal':
				case 'money':
				case 'numeric':
					$field['type'] = 'text';
					$field['masks'] = 'decimal';
					$field['validations'] .= 'decimal';
				break;

				default:
					$field['type'] = 'text';
				break;
			}

			// Still exists the possibility of this field be a foreing key
			if(get_value($field_data, 'constraint_type') == 'FOREIGN KEY')
			{
				$field['type'] = 'select';
				$field['description'] = '';
				$field['options_sql'] = 'SELECT ' . $obj_field->name . ', ' . $obj_field->name . ' AS LABEL FROM ' . get_value($field_data, 'referenced_table_name');
			}
		}

		return $field;
	}

	/**
	 * Returns a field meta-data according with the given table and field.
	 *
	 * @param string table
	 * @param string column
	 * @return array fields
	 */
	private function _get_field_meta_data($table = '', $column_name = '')
	{
		// Loads database layer
		$this->CI->load->database();

		// Builds query according with driver
		switch(strtolower(DB_DRIVER))
		{
			// MySQL driver
			case 'mysql':
			case 'mysqli':
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
			break;

			// Postgre driver
			case 'postgre':
				$sql = "SELECT *
						  FROM information_schema.columns c

					 LEFT JOIN (SELECT ccu.column_name,
									   ccu.table_name AS referenced_table_name,
									   tc.constraint_type
								  FROM information_schema.table_constraints        tc
							 LEFT JOIN information_schema.constraint_column_usage ccu ON (ccu.constraint_name = tc.constraint_name)
							     WHERE tc.table_name   = '$table'
								   AND tc.constraint_type = 'FOREIGN KEY'
					 ) fk ON (fk.column_name = c.column_name)

					 LEFT JOIN (SELECT CASE WHEN tc.constraint_type = 'PRIMARY KEY' THEN 'PRI' ELSE '' END AS column_key,
					 				   ccu.column_name
					 	 		  FROM information_schema.table_constraints         tc
							 LEFT JOIN information_schema.constraint_column_usage  ccu ON (ccu.constraint_name = tc.constraint_name)
							     WHERE tc.table_name   = '$table'
								   AND tc.constraint_type = 'PRIMARY KEY'
					 ) pk ON (pk.column_name = c.column_name)

					 	 WHERE c.table_name  = '$table'
						   AND c.column_name = '$column_name'";
			break;

			// Oracle driver
			case 'oci8':
				$sql = "SELECT c.*,
							   fk.*,
		      				   CASE WHEN (SELECT COUNT(*)
		         							FROM all_constraints cons
		   							  INNER JOIN all_cons_columns cols ON (cons.constraint_name = cols.constraint_name AND cols.owner = cons.owner)
		        						   WHERE cols.table_name = c.table_name
		           							 AND cols.column_name = c.column_name
		           							 AND cons.constraint_type = 'P'
		      							 ) > 0 THEN 'PRI' END AS column_key,
		      				   CASE WHEN c.nullable = 'N' THEN 'NO' ELSE 'YES' END AS IS_NULLABLE,
		      				   c.internal_column_id AS ORDINAL_POSITION
						  FROM user_tab_cols c
					 LEFT JOIN (SELECT a.column_name,
					 				   c_pk.table_name AS REFERENCED_TABLE_NAME,
					 				   'FOREIGN KEY' AS CONSTRAINT_TYPE,
					 				   a.TABLE_NAME
		       					  FROM all_cons_columns a
		  						  JOIN all_constraints    c ON (a.owner = c.owner AND a.constraint_name = c.constraint_name)
		  						  JOIN all_constraints c_pk ON (c.r_owner = c_pk.owner AND c.r_constraint_name = c_pk.constraint_name)
		 						 WHERE c.constraint_type = 'R'
		 						   AND a.table_name = '" . strtoupper($table) . "'
		 					   ) fk ON (fk.column_name = c.column_name AND fk.table_name = c.table_name)
						 WHERE c.table_name  = '" . strtoupper($table) . "'
		  				   AND c.column_name = '" . strtoupper($column_name) . "'";
			break;
		}

		// Return field metadata array
		return $this->CI->db->query($sql)->row_array(0);
	}
}