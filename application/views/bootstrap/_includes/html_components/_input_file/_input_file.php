<?php
/**
* _input_file()
* Monta um input tipo file que seja cross browser, ou seja, que funcione e possua as mesmas 
* características em todos os browsers.
* @param string id
* @param string name
* @param string class
* @param string value
* @param string javascript
* @return string html_input
*/
function _input_file($id = '', $name = '', $class = '', $value = '', $javascript = '')
{
	$html = '';
	
	// ID da instancia do input que contem o nome do arquivo atual
	$id_button_instance = uniqid();
	
	// HTML do input
	$html .= '<span id="" class="file_container_input_file"><input id="' . $id . '" name="' . $name . '" size="1" type="file" value="' . $value . '" class="' . $class . '" /></span>';
	$html .= '<input id="' . $id_button_instance . '" class="file_fake_input" type="text" readonly="true" value="' . lang('Selecionar arquivo do seu computador...') . '" onclick="$(\'#' . $id . '\').click();" />';
	$html .= '<button class="file_browse_button" onclick="$(\'#' . $id . '\').click();" type="button" ' . $javascript . '>' . lang('Procurar') . '</button>';
	
	// Javascript de simulação do click no input
	$html .= '
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			$("#' . $id . '").change(function(){
				var path = $("#' . $id . '").val();
				var delimiter = path.lastIndexOf("\\\");
				var file_name = path.substr(delimiter + 1);
				$("#' . $id_button_instance . '").val(file_name);
				$("#' . $id_button_instance . '").attr("title", file_name);
			});
		});
	</script>';

	return $html;
}