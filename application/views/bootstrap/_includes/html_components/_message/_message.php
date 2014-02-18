<?php
/**
* _message()
* Retorna html do componente mensagem. Quando invocado pelo template da aplicação, recebe 
* automaticamente um conjunto de parametros que definem a mensagem.
* @param string tipo
* @param string titulo
* @param string descricao
* @param boolean close
* @param string style
* @return string html_message
*/
function _message($type = 'info', $title = '', $description = '', $close = false, $style = '')
{
	$id = uniqid();
	$type = ($type != 'info' && $type != 'warning' && $type != 'error' && $type != 'success' && $type != 'note') ? 'info' : $type;
	$html  = '<div id="message_general_' . $id . '">';
	$html .= '<div class="msg_general ' . $type . '" ' . (($style != '') ? 'style="' . $style . '"' : '') . '>';
	$html .= '<div>';
	$html .= ($close) ? '<img src="' . URL_IMG . '/icon_close.png" class="close" title="Fechar" onclick="javascript:$(\'#message_general_' . $id . '\').hide();" />' : '';
	$html .= '<img src="' . URL_IMG . '/icon_' . $type . '.png" />';
	$html .= ($title != '') ? '<h5>' . $title . '</h5>' : '';
	$html .= '<div>' . $description . '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}