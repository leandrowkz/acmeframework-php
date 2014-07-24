<?php
/**
*
* module_form_field()
*
* Build a html input field for module form. Must return string.
*
* @param array $action
* @return string html
*
*/
function module_form_field($field = array())
{
	$html = '';

	$CI =& get_instance();

	// Build all attributes
	$type =strtolower(get_value($field, 'type'));
	$label = get_value($field, 'label');
	$id = 'id="' . get_value($field, 'id_html') . '"';
	$name = 'name="' . get_value($field, 'table_name') . '[' . get_value($field, 'table_column') . ']"';
	
	// class and validations
	$class  = 'class="form-control ';
	$class .= ' ' . get_value($field, 'class_html');
	$class .= ' ' . $CI->form->build_string_validation(get_value($field, 'validations'));
	$class .= '"';

	$javascript = get_value($field, 'javascript');
	$style = 'style="' . get_value($field, 'style') . '"';
	$maxlength = 'maxlength="' . get_value($field, 'maxlength') . '"';
	$masks = 'alt="'. get_value($field, 'masks') . '"';
	$options_sql = get_value($field, 'options_sql');
	$options_json = get_value($field, 'options_json');
	$description = get_value($field, 'description');
	$value = htmlentities(get_value($field, 'value'));

	// build label
	$label .= stristr(get_value($field, 'validations'), 'required') ? '*' : '';
	$label = '<label>' . $label . '</label>';
	
	switch($type) {
		
		default:
		case 'text':
		case 'file':
		case 'password':
			
			// Ajusta valor caso tipo seja data
			if(is_date_format_db($value)) { 
				$date = strtotime($value);
				$value = date('d/m/Y', $date);
			}
			
			$value = 'value="' . $value . '"';
			$html_field = "<input type=\"$type\" $name $id $class $maxlength $masks $style $javascript $value />";

		break;
				
		
		case 'textarea':
			$html_field = "<textarea $name $id $class $masks $style $javascript>$value</textarea>";
		break;
		

		case 'select':
		case 'radio':
			
			// Build html options adding first sql options then json options after
			$sql = ($options_sql != '') ? $CI->db->query($options_sql)->result_array() : array();

			$json = ($options_json != '') ? json_decode($options_json) : array();

			$options = array_merge($sql, $json);
			
			if($type == 'select') {
				
				// build <select>
				$html_field  = "<select $name $id $class $style $javascript>";
				$html_field .= $CI->form->build_select_options($options, $value);
				$html_field .= "</select>";

			}

			if($type == 'radio') {

				// Build all radios
				foreach($options as $option) {

					$option = array_values($option);
					$field_value = 'value="' . $option[0] . '"';
					$checked = ($option[0] == $value) ? ' checked="true"' : '';
					$return[$key] .=  "<div class=\"inline top\" style=\"margin-top:2px\"><input type=\"radio\" $name $id $class $maxlength $masks $style $javascript $field_value $checked /></div>";
					$return[$key] .=  '<div class="inline top" style="margin-left:4px">' . $option[1] . '</div><br />';
				}
			}
		break;
	}

	// put everything togheter
	$html = $label . $html_field;

	// add description
	if($description != '')
		$html . '<br /><small>' . $description . '</small>';

	return $html;
}