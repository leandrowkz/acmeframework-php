<?php
/**
*
* Classe Form
*
* Esta biblioteca gerencia funções relacionadas à formulários e misc de formulários em geral.
* 
* @since		27/10/2012
* @location		acme.libraries.form
*
*/
class Form {
	// Definição de Atributos
	var $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* build_array_html_form_fields()
	* Recebe um array de inputs de formulario do modulo (tabela acm_module_form_field) e os transforma 
	* em um array de string de elementos de formularios html, como input, select e afins. O retorno
	* contém um label indicando um elemento de form, como:
	*
	* array 
	* (
	* 	'ID Usuário' => '<input type="text" name="acm_user[id_user]" id="id_user" />',
	*	'Login' => '<input type="text" name="acm_user[login]" id="login" />'
	* )
	* Terceiro parametro diz se os campos são de filtros ou não (boolean).
	* @param array fields
	* @param array values
	* @param boolean is_filter
	* @return array string_form_elements
	*/
	public function build_array_html_form_fields($fields = array(), $values = array(), $is_filter = false)
	{
		$return = array();
		if(count($fields) > 0)
		{
			// DEBUG:
			// print_r($values);
			
			foreach($fields as $field)
			{
				// Monta atributos comuns a todos os elementos
				$key = (stristr(get_value($field, 'validations'), 'required') && !$is_filter) ? get_value($field, 'lang_key_label') . '<span class="fnt_error">&nbsp;*</span>' : get_value($field, 'lang_key_label');
				
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
	* build_array_html_options()
	* Monta um conjunto de tags html <option> com base em um array encaminhado como parametro. O array
	* encaminhado deverá possuir dois indices em uma mesma linha, ao menos, sendo eles:
	* Array [0] ( 
	*			 [0] => VALUE
	* 			 [1] => ROTULE
	*			)
	* Array [1] (
	*			 [0] => VALUE
	* 			 [1] => ROTULE
	*			)
	* @param array data
	* @param value_to_select
	* @param boolean blank_option
	* @return string html
	*/
	public function build_array_html_options($data = null, $value_to_selected = null, $blank_option = true)
	{
		$html = '';
		if(!is_null($data) && is_array($data))
		{
			// DEBUG:
			// echo($value_to_selected);
			// $data = array_values($data);
			// print_r($data);
			$val_selected = (!is_null($value_to_selected)) ? $value_to_selected : '';
			if($blank_option)
			{
				$html .= '<option value=""';
				$html .= ($val_selected == '') ? ' selected="selected"></option>' : '></option>';
			}
			foreach($data as $row)
			{
				$row = array_values($row);
				$html .= '<option value="' . $row[0] . '"';
				$html .= ($val_selected == $row[0]) ? ' selected="selected">' : '>';
				$html .= array_key_exists(1, $row) ? $row[1] : $row[0];
				$html .= '</option>';
			}
		}
		return $html;
	}
	
	/** 
	* build_array_options_by_separator()
	* Monta um array de dados de opcoes explodindo string com base no separador ponto-e-virgula. 
	* A primeira string será os indices que o array possuira e a segunda, seus values. Sendo assim
	* as strings:
	* => '1;2;3;4'
	* => 'A;B;C;D'
	* retornarao o array:
	* [0] => 1
	* [1] => A
	* @param string indexs
	* @param string values
	* @return array options
	*/
	public function build_array_options_by_separator($indexs = '', $values = '')
	{
		$return = array();
		$arr_index = explode(';', $indexs);
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
	* get_string_validation()
	* Retorna a string de validação que deve ser utilizada junto à classe, para validação de
	* formulários no estilo jquery validation engine. As informações de validação devem ser 
	* encaminhadas separadas por ';', por exemplo, se você quer que um campo seja obrigatório 
	* e valide emails, então deve encaminhar a string 'required;email'. Abaixo, as validações 
	* disponíveis:
	* -> required: Campo obrigatório
	*
	* custom[]
	* -> email: validador de email
	* -> phone: valida telefone
	* -> url: Campo URL válida
	* -> number: Valida floats com informação de negação ou não
	* -> integer: Valida números inteiros
	* -> ipv4: Valida endereços de ip válidos
	* -> dateEn: valida datas no formato AAAA-MM-DD
	* -> datePtb: valida datas no formato DD/MM/AAAA
	* -> onlyLetterSp: Permite apenas letras e espaços
	* -> onlyNumberSp: Permite apenas numeros e espaços
	* -> onlyLetterNumber: Permite apenas letras e números, sem espaços
	* 
	* Após custom[]
	* -> equals[fieldID]: Compara com o valor de outro campo (passwords, ex)
	* -> minCheckbox[7]: mínimo de checkboxes a serem marcados
	* -> maxCheckbox[7]: Um máximo de checkboxes permitidos em um grupo
	* -> min[7]: Valida quando o valor do campo é menor do que o parametro informado [7]
	* -> max[7]: Valida quando o valor do campo é maior do que o parametro informado [7]
	* -> past[NOW or date YYYY-MM-DD]: Verifica se o valor do elemento é uma data anterior à data informada como parametro.
	* -> future[NOW or date YYYY-MM-DD]: Verifica se o valor do elemento é uma data posterior à data informada como parametro.
	* -> minSize[7]: Verifica se o tamanho em caracteres do campo é maior do que o informado [7].
	* -> maxSize[7]: Verifica se o tamanho em caracteres do campo é menor do que o informado [7].
	* @param string validate
	* @return string new_validate
	*/
	public function get_string_validation($validate = '')
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
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'minCheckbox'))
					{
						$part_two .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'maxCheckbox'))
					{
						$part_two .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'min'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'max'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'past'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'future'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'minSize'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
					if(stristr($arr_validations[$i], 'maxSize'))
					{
						$part_one .= $arr_validations[$i] . ',';
					}
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
	* build_array_field_db_from_object()
	* Monta um array para manipulação do banco de dados (tabela acm_module_form_field) de um objeto
	* de field criado pelo codeigniter ($this->db->field_data(table)).
	* @param object obj_field
	* @param string table
	* @return array field
	*/
	public function build_array_field_db_from_object($obj_field = null, $table = '')
	{
		// Monta array com colunas do banco de dados
		$field = array();
		$field['id_module_form'] = 'NULL';
		$field['table_column'] = 'NULL';
		$field['type'] = 'NULL';
		$field['lang_key_label'] = 'NULL';
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
			$field['lang_key_label'] = $obj_field->name;
			$field['id_html'] = $obj_field->name;
			$field['maxlength'] = $obj_field->max_length;
			$field['order_'] = get_value($field_data, 'ordinal_position') * 10;
			$field['validations'] = (get_value($field_data, 'is_nullable') != 'YES') ? 'required;' : '';
			
			switch(strtolower(get_value($field_data, 'data_type')))
			{
				case 'varchar':
					$field['type'] = 'text';
					$field['style'] = 'width:' . ($obj_field->max_length) . 'px';
				break;
				
				case 'text':
				case 'varchar2':
					$field['type'] = 'textarea';
					$field['style'] = 'width:300px;height:100px';
				break;
				
				case 'date':
				case 'datetime':
				case 'timestamp':
					$field['type'] = 'text';
					$field['masks'] = 'date';
					$field['validations'] .= 'date';
					$field['style'] = 'width:130px';
					$field['description'] = lang('Formato DD/MM/AAAA');
				break;

				case 'time':
					$field['type'] = 'text';
					$field['masks'] = 'time';
					$field['style'] = 'width:100px';
					$field['description'] = lang('Formato HH:MM');
				break;
				
				case 'int':
				case 'number':
					$field['type'] = 'text';
					$field['masks'] = 'integer';
					$field['validations'] .= 'integer';
					$style['style'] = 'width:150px;';
					$field['description'] = lang('Somente números');
				break;
				
				case 'decimal':
					$field['type'] = 'text';
					$field['masks'] = 'decimal';
					$field['maxlength'] = (get_value($field_data, 'numeric_precision') + get_value($field_data, 'numeric_scale')) - 1;
					$field['validations'] .= 'number';
					$style['style'] = 'width:150px;';
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
				$field['style'] = 'width:150px';
				$field['description'] = '';
				$field['options_sql'] = 'SELECT ' . $obj_field->name . ', ' . $obj_field->name . ' AS LABEL FROM ' . get_value($field_data, 'referenced_table_name');
			}
		}
		
		return $field;
	}
	
	/** 
	* input_file()
	* Monta um input tipo file que seja cross browser, ou seja, que funcione e possua as mesmas 
	* características em todos os browsers.
	* @param string id
	* @param string name
	* @param string class
	* @param string value
	* @param string javascript
	* @return string html_input
	*/
	public function input_file($id = '', $name = '', $class = '', $value = '', $javascript = '')
	{
		$this->CI =& get_instance();
		return $this->CI->template->load_html_component('_input_file', array($id, $name, $class, $value, $javascript));
	}
}