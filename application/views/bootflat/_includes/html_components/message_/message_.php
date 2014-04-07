<?php
/**
*
* message_()
*
* Retorna html do componente mensagem. Quando invocado pelo template da aplicação, recebe 
* automaticamente um conjunto de parametros que definem a mensagem.
*
* @param string tipo
* @param string titulo
* @param string descricao
* @param boolean close
* @param string style
* @return string html_message
*
*/
function message_($type = 'info', $title = '', $description = '', $close = false, $style = '')
{
	$type = ($type != 'info' && $type != 'warning' && $type != 'error' && $type != 'success' && $type != 'note') ? 'info' : $type;
	$type = ($type == 'error') ? 'danger' : $type;

	$style = $style != '' ? ' style="' . $style . '"' : '';
	$html  = '<div class="alert alert-' . $type . (($close) ? ' alert-dismissable' : '') . '"' . $style . '>';
	$html .= ($close) ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' : '';
	$html .= ($title != '') ? '<strong>' . $title . '</strong> ' : '';
	$html .= $description;
	$html .= '</div>';
	
	return $html;
}