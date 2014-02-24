<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Form
*
* Biblioteca de funções relacionadas a formulários html da aplicação.
* 
* @since 	27/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Form {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* build_form_fields()
	* Recebe resultset de inputs de formulario de modulo (tabela acm_module_form_field) e transforma 
	* em array de elementos de formularios html, como input, select, textarea, etc. 
	*
	* 		O array de retorno é algo como:
	*		Array 
	* 		(
	*			'Login' => '<input type="text" name="acm_user[login]" id="login" />'
	* 			'Senha' => '<input type="text" name="acm_user[password]" id="password" />',
	* 		)
	*
	* @param array fields
	* @param array values
	* @return array string
	*/
	public function build_form_fields($fields = array(), $values = array())
	{
		$return = array();

		if(count($fields) > 0)
		{
			// DEBUG:
			// print_r($values);
			
			foreach($fields as $field)
			{
				// Monta atributos comuns a todos os elementos
				$key  = get_value($field, 'label');
				$key .= stristr(get_value($field, 'validations'), 'required') ? '*' : '';
				
				// Monta o name e id
				// monta diferenciado, caso montagem seja de filtros
				$id = 'id="' . get_value($field, 'id_html') . '" ';
				if($is_filter)
				{
					if(stristr(get_value($field, 'table_column'), '.'))
					{
						$arr_name = explode('.', get_value($field, 'table_column'));
						$name = 'name="' . $arr_name[0] . '[' . $arr_name[1] . ']"';
					} else {
						$name = 'name="' . get_value($field, 'table_column') . '"';
					}
				} else {
					$name = 'name="' . get_value($field, 'table_name') . '[' . get_value($field, 'table_column') . ']"';
				}
				
				// Class tem tratamento especial por tratar das validações também
				$class  = ($is_filter) ? 'class="mini ' : 'class="';
				$class .=  get_value($field, 'class_html');
				$class .= (get_value($field, 'validations') != '') ? ' ' . $this->get_string_validation(get_value($field, 'validations')) : '';
				$class .= '"';
				
				// Prossegue com atributos tradicionais
				$javascript = get_value($field, 'javascript');
				$style = 'style="' . get_value($field, 'style') . '" ';
				$maxlength = (get_value($field, 'maxlength') != '') ? 'maxlength="' . get_value($field, 'maxlength') . '"' : '';
				$masks = (get_value($field, 'masks') != '') ? 'alt="' . get_value($field, 'masks') . '"' : '';
				
				// Separa options e descricao, que aparece abaixo do campo
				$options_sql = get_value($field, 'options_sql');
				$options_rotules = get_value($field, 'options_rotules');
				$options_values = get_value($field, 'options_values');
				$description = (get_value($field, 'description') != '') ? '<div style="margin:4px 0 0 0" class="font_11 comment">' . get_value($field, 'description') . '</div>' : '';
				
				// Coleta o valor do campo (quando valor encaminhado)
				if($is_filter && stristr(get_value($field, 'table_column'), '.'))
				{
					$arr_name = explode('.', get_value($field, 'table_column'));
					$value = get_value(get_value($values, $arr_name[0]), $arr_name[1]);
				} else {
					$column = get_value($field, 'table_column');
					$value = get_value($values, $column);
				}
				
				switch(strtolower(get_value($field, 'type')))
				{
					case 'text':
						// Ajusta valor caso tipo seja data
						if(is_date_format_db($value))
						{ 
							$date = strtotime($value);
							$value = date('d/m/Y', $date);
						}
						$field_value = "value=\"$value\"";
						$return[$key] = "<input type=\"text\" $name $id $class $maxlength $masks $style $javascript $field_value />$description";
					break;
					
					case 'password':
						$field_value = "value=\"$value\"";
						$return[$key] = "<input type=\"password\" $name $id $class $maxlength $masks $style $javascript $field_value />$description";
					break;
					
					case 'textarea':
						$return[$key] = "<textarea $name $id $class $masks $style $javascript>$value</textarea>$description";
					break;
					
					case 'select':
						// Monta os options dando prioridade para o SQL
						$options = ($options_sql != '') ? query_array($options_sql) : $this->build_array_options_by_separator($options_values, $options_rotules);
						
						// Monta o select [e adiciona options]
						$return[$key]  = "<select $name $id $class $style $javascript>";
							$return[$key] .= $this->build_array_html_options($options, $value);
						$return[$key] .= "</select>";
					break;
					
					case 'radio':
						// Monta os options dando prioridade para o SQL
						$options = ($options_sql != '') ? query_array($options_sql) : array_values($this->build_array_options_by_separator($options_values, $options_rotules));
						
						// Inicializa o indice
						$return[$key] = '';
						
						// Monta a lista de radios
						foreach($options as $option)
						{
							$option = array_values($option);
							$field_value = 'value="' . $option[0] . '"';
							$checked = ($option[0] == $value) ? ' checked="true"' : '';
							$return[$key] .=  "<div class=\"inline top\" style=\"margin-top:2px\"><input type=\"radio\" $name $id $class $maxlength $masks $style $javascript $field_value $checked /></div>";
							$return[$key] .=  '<div class="inline top" style="margin-left:4px">' . $option[1] . '</div><br />';
						}
					break;
					
					
					case 'file':
						$field_value = "value=\"$value\"";
						$return[$key]  = "<input type=\"file\" $name $id $class $maxlength $style $javascript $field_value />";
					break;
					
					// CHECKBOX (BETA)
					// case 'checkbox':
					// $return[$key]  = "<input type=\"checkbox\" name=\"$name\" $id $class $maxlength $masks $style $javascript value=\"$value\" />";
					// break;
					
					default:
						$field_value = "value=\"$value\"";
						$return[$key] = "<input type=\"text\" $name $id $class $maxlength $masks $style $javascript $field_value />";
					break;
				}
			}
		}
		
		// Retorna array de campos em formato html
		return $return;
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
		$field['options_rotules'] = 'NULL';
		$field['options_values'] = 'NULL';
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
					$field['type'] = 'text';
				break;
				
				case 'text':
				case 'varchar2':
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