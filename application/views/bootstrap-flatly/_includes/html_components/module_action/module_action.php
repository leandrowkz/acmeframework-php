<?php
/**
*
* module_action()
*
* Monta o conteúdo da coluna de ação de listagem de SQL do módulo.
*
* @param array $action
* @return string html
*
*/
function module_action($action = array())
{
	$html  = '<a href="' . tag_replace(get_value($action, 'link')) . '"';
	$html .= (get_value($action, 'target') != '') ? ' target="' . get_value($action, 'target') . '"' : '';
	$html .= ">";
	$html .= (get_value($action, 'url_img') != '') ? '<img src="' . tag_replace(get_value($action, 'url_img')) . '" />' : '';
	$html .= (get_value($action, 'url_img') == '') ? get_value($action, 'lang_key_rotule') : '';
	$html .= '</a>';

	return $html;
}