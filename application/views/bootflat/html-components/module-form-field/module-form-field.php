<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component module-form-field.php
 *
 * This HTML component build a module field for automatic module forms.
 *
 * The $field structure is something like:
 *
 * $field = array(
 * 		[id_module_form_field] => 2
 * 		[id_module_form] => 3
 * 		[type] => 'text' // text, file, password, textarea, select, checkbox, radio
 * 		[label] => 'My field'
 * 		[id_html] => 'my_field'
 * 		[class_html] => 'my_field'
 * 		[javascript] => ''
 * 		[style] => ''
 * 		[maxlength] => ''
 * 		[masks] => 'integer;date'
 * 		[validations] => 'required;email'
 * 		[options_sql] => 'SELECT a, b FROM c'
 * 		[options_json] => '[{id : 1, label: 2}, {id : 3, label : 4}]'
 * 		[description] => ''
 * 		[value] => ''
 * )
 *
 * @param    array $action
 * @since    28/06/2013
 * --------------------------------------------------------------------------------------------------
 */

$CI =& get_instance();

// Build all attributes
$type =strtolower(get_value($field, 'type'));
$label = get_value($field, 'label');
$id = 'id="' . get_value($field, 'id_html') . '"';
$name = 'name="' . get_value($field, 'table_name') . '[' . get_value($field, 'table_column') . ']"';

// Class and validations
$class  = 'class="form-control ';
$class .= ' ' . get_value($field, 'class_html');
$class .= ' ' . $CI->form->build_string_validation(get_value($field, 'validations'));
$class .= '"';

// Js, maxlength, styles, masks, options, desc and value
$javascript = get_value($field, 'javascript');
$style = 'style="' . get_value($field, 'style') . '"';
$maxlength = 'maxlength="' . get_value($field, 'maxlength') . '"';
$masks = 'alt="'. get_value($field, 'masks') . '"';
$options_sql = get_value($field, 'options_sql');
$options_json = get_value($field, 'options_json');
$description = get_value($field, 'description');
$value = htmlentities(get_value($field, 'value'));

// Adjust label
$label .= stristr(get_value($field, 'validations'), 'required') ? '*' : '';

switch($type) {

	default:
	case 'text':
	case 'file':
	case 'password':

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
?>

<div>
	<label>
		<?php echo $label ?>
		<?php if($description != '') { ?>
		<small class="text-muted">// <?php echo $description ?></small>
		<?php } ?>
	</label>

	<?php echo $html_field ?>

</div>
