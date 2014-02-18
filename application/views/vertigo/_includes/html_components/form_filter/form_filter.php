<?php
/**
* form_filter()
* Esta função monta o formulario de filtros da listagem de um modulo padrão. Quando invocada pelo 
* objeto template do acme engine, recebe como parametro a lista de campos do form e o action a ser
* disparado. O id deste formulario obrigatóriamente deve ser 'form_filter'.
* @param array fields
* @param string action
* @return string html
*/
function form_filter($fields = array(), $action = '')
{
	$html = '';
	if(count($fields) > 0)
	{
		$html .= '<form id="form_filter" action="' . $action . '" method="post">';
		$html .= '<img src="' . URL_IMG . '/icon_filter_arrow.png" id="arrow" />';
		$html .= '<div id="content">';
		
		// Para cada campo
		foreach($fields as $label => $field)
		{
			$html .= '<div id="form_label" class="font_11">' . lang($label) . ':</div>';
			$html .= '<div id="form_field">' . $field . '</div>';
		}
		
		// Botão Enviar
		$html .= '<hr style="margin:5px 0" />';
		$html .= '<input type="submit" class="mini" value="' . lang('Enviar') . '">';
		
		// Finaliza form
		$html .= '</div>';
		$html .= '</form>';
	}
	return $html;
}