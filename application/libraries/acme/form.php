<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Form
*
* Library of functions related with application html forms.
* 
* @since 	27/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Form {
	
	public $CI = null;
	
	/**
	* __construct()
	* @return object
	*/
	public function __construct () { }
	
	/**
	* build_form_fields()
	* Receive a resultset of inputs (from table acm_module_form_field) and transforms them into an array
	* of html input elements, like:
	*
	*		Array 
	* 		(
	*			[0] => '<label>Email</label><input type="text" name="acm_user[email]" id="email" />'
	* 			[1] => '<label>Password</label><input type="text" name="acm_user[password]" id="password" />'
	*			[2] => ...
	* 		)
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

		// procced with no errors :)
		$CI =& get_instance();

		foreach($fields as $field) {

			// Build all attributes
			$field['value'] = get_value($values, get_value($field, 'table_column'));

			// add field
			array_push($html_fields, $CI->template->load_html_component('module_form_field', array($field)));
			
		}
		
		return $html_fields;
	}
	
	/** 
	* build_select_options()
	* Monta um conjunto de tags html <option> com base em um array encaminhado como parametro. 
	* O array encaminhado deverá possuir dois indices em uma mesma linha, ao menos, 
	* por exemplo:
	*
	* 		Array 
	* 		(
	* 			[0] => Array ( [0] => VALUE, [1] => ROTULE )
	* 			[1] => Array ( [0] => VALUE, [1] => ROTULE )
	*		)
	*
	* @param array data
	* @param option_selected 		// valor que deve ser marcado como selected="selected"
	* @param boolean blank_option 	// true para inserir <option> inicial em branco
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
	* build_array_comma()
	* Recebe 2 strings de dados separados por ponto-e-virgula e retorna um único array de 
	* índice => valor com base nestas strings. Por exemplo:
	* 		
	*		As strings:
	* 		String 1: "1;2;3;4"
	* 		String 2: "A;B;C;D"
	*
	* 		Retornarao o array:
	*		Array 
	*		(
	*			[1] => A,
	*			[2] => B ...
	*		)
	*
	* @param string indexes
	* @param string values
	* @return array options
	*/
	public function build_array_comma($indexes = '', $values = '')
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
	* build_string_validation()
	* Monta a string de validação de formulários utilizada pelo plugin jquery.validationEngine.
	* As validações deverão ser encaminhadas todas em uma string separadas por ponto-e-vírgula.
	* 
	*		Exemplos de validação:
	* 		- required
	*		- email
	*		- phone
	* 		- url
	* 		- number
	*		- integer
	*
	*		A string deverá ser encaminhada como:
	*		required;email;phone
	*		
	* OBS: Para mais informações, consulte https://github.com/posabsolute/jQuery-Validation-Engine
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
		
		// Ajusta string de validação e explode os itens de validacao
		trim($validate, ';');
		$arr_validations = explode(';', $validate);
		$count_validations = count($arr_validations);
		
		// Varre todo o array de validações, alterando a string final
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
				case 'phone':
				case 'url':
				case 'number':
				case 'integer':
				case 'ipv4':
				case 'datept_BR':
				case 'onlyNumberSp':
				case 'onlyLetterSp':
				case 'onlyLetterNumber':
					$part_two .= $arr_validations[$i] . ',';
				break;
				
				// Anothers
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
		
		// Monta a string pelas partes montadas
		$part_one = ($part_one != '') ? rtrim($part_one, ',') : $part_one;
		$part_two = ($part_two != '') ? rtrim($part_two, ',') : $part_two;
		$part_thr = ($part_thr != '') ? rtrim($part_thr, ',') : $part_thr;
		$return .= ($part_one != '') ? $part_one : '';
		$return .= ($part_two != '' && $part_one != '') ? ',custom[' . $part_two . ']' : '';
		$return .= ($part_two != '' && $part_one == '') ?  'custom[' . $part_two . ']' : '';
		$return .= ($part_thr != '' && ($part_two != '' || $part_one != '')) ? ',' . $part_thr : '';
		$return .= ($part_thr != '' && ($part_two == '' || $part_one == '')) ? $part_thr : '';
		$return .= ']';
		
		// Retorna string ajustada
		return $return;
	}
	
	/** 
	* build_field()
	* Prepara e retorna um array de campo pronto para ser inserido na tabela acm_form_field.
	* Este field/array é montado a partir de um objeto do codeigniter // $this->db->field_data(table).
	* @param object obj_field
	* @param string table
	* @return array field
	*/
	public function build_field($obj_field = null, $table = '')
	{
		// Monta array com colunas do banco de dados
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
		
		// Processa campo
		if(!is_null($obj_field))
		{
			// Coleta do banco de dados informações sobre o campo (outras que o CI não fornece)
			$this->CI =& get_instance();
			$this->CI->load->model('libraries/form_model');
			$field_data = $this->CI->form_model->get_field_meta_data($table, $obj_field->name);
			
			// Preenche dados básicos do campo
			$field['table_column'] = $obj_field->name;
			$field['label'] = $obj_field->name;
			$field['id_html'] = $obj_field->name;
			$field['maxlength'] = $obj_field->max_length;
			$field['order_'] = get_value($field_data, 'ordinal_position') * 10;
			$field['validations'] = (get_value($field_data, 'is_nullable') != 'YES') ? 'required;' : '';
			
			switch(strtolower(get_value($field_data, 'data_type')))
			{
				case 'varchar':
				case 'varchar2':
					$field['type'] = 'text';
				break;
				
				case 'text':
					$field['type'] = 'textarea';
				break;
				
				case 'date':
				case 'datetime':
				case 'timestamp':
					$field['type'] = 'text';
					$field['masks'] = 'date';
					$field['validations'] .= 'date';
					$field['description'] = lang('Formato DD/MM/AAAA');
				break;

				case 'time':
					$field['type'] = 'text';
					$field['masks'] = 'time';
					$field['description'] = lang('Formato HH:MM');
				break;
				
				case 'int':
				case 'number':
					$field['type'] = 'text';
					$field['masks'] = 'integer';
					$field['validations'] .= 'integer';
					$field['description'] = lang('Somente números');
				break;
				
				case 'decimal':
					$field['type'] = 'text';
					$field['masks'] = 'decimal';
					$field['maxlength'] = (get_value($field_data, 'numeric_precision') + get_value($field_data, 'numeric_scale')) - 1;
					$field['validations'] .= 'number';
				break;
				
				case 'float':
				case 'double':
					$field['type'] = 'text';
					$field['masks'] = 'decimal';
					$field['validations'] .= 'number';
				break;
				
				default:
					$field['type'] = 'text';
				break;
			}
			
			// Campo processado, ainda existe a possibilidade de ser chave estrangeira
			if(get_value($field_data, 'constraint_type') == 'FOREIGN KEY')
			{
				$field['type'] = 'select';
				$field['description'] = '';
				$field['options_sql'] = 'SELECT ' . $obj_field->name . ', ' . $obj_field->name . ' AS LABEL FROM ' . get_value($field_data, 'referenced_table_name');
			}
		}
		
		return $field;
	}
}