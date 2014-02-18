<?php
/**
* _start_box()
* Inicializa uma caixa html genérica, de um estilo padrão.
* @param string title
* @param string url_img
* @param string style
* @return string start_box
*/
function _start_box($title = '', $url_img = '', $style = '')
{
	$style = ($style != '') ? ' style="' . $style . '"' : '';
	$html  = '<div class="generic_box"' . $style . '>';
	
	// Header
	$html .= '<div id="header">';
	$html .= ($url_img != '') ? '<img id="img" src="' . $url_img . '" />' : '';
	$html .= '<h6 class="white font_shadow_black">' . $title . '</h6>';
	$html .= '</div>';
	
	// Conteúdo do box
	$html .= '<div id="content">';
	
	// Função de abertura, fechamento deve de fato fechar este box
	return $html;
}