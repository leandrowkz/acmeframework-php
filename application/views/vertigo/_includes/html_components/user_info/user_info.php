<?php
/**
* user_info()
* Função de montagem do bloco das informações do usuário, como imagem, nome, favoritos, etc.
* @param string id_user
* @param string login
* @param string email
* @param string username
* @param string usergroup
* @param string url_img
* @param array bookmarks
* @return string user_info
*/
function user_info($id_user = 0, $login = '', $email = '', $username = '', $usergroup = '', $url_img = '', $bookmarks = array())
{
	// Coleta instancia do CI
	$CI =& get_instance();
	
	// Inicializa a var de retorno
	$html  = '<div style="margin-top:30px">';
	
	// Img do usuário
	$url_img = (!file_exists(PATH_UPLOAD . '/user_photos/' . basename($url_img)) || $url_img == '') ? URL_IMG . '/avatar_user_unknown.png' : $url_img;
	$html .= '<div class="inline top" style="margin-right:10px"><img src="' . $url_img . '" style="max-width:60px;float:left;" /></div>';
	
	// Informações básicas
	$html .= '<div class="inline top font_11" style="margin:-2px 0 0 0px;width:90px;style="overflow-y:hidden;">';
	$html .= '<span class="font_12 bold">' . $login . '</span><br />';
	$html .= '<span class="comment">' . $usergroup . '</span><br />';
	$html .= '<a href="' . URL_ROOT . '/acme_user/user_profile/' . $id_user . '">' . lang('Perfil completo') . '</a>';
	$html .= '</div>';
	
	// Bloco de idioma padrão
	$html .= '<div style="margin-top:30px">';
	$html .= '<h6>' . lang('Idioma'). '</h6>';
	$html .= '<div style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc"></div>';
	$html .= '<select id="combo_language" style="background-color:white;background-image:none;width:100%;margin-top:5px" class="mini" onchange="ajax_change_language();">';
		$html .= '<option value="pt_BR" ' . (($CI->session->userdata('language') == 'pt_BR') ? 'selected="selected"' : '') . '>' . lang('Português (Brasil)') . '</option>';
		$html .= '<option value="en_US" ' . (($CI->session->userdata('language') == 'en_US') ? 'selected="selected"' : '') . '>' . lang('Inglês (Estados Unidos)') . '</option>';
	$html .= '</select>';
	$html .= '</div>';
	
	// Laço de favoritos
	$html .= '<div style="margin-top:30px;">';
	$html .= '<div style="float:right;margin-top:5px" class="font_11"><a href="javascript:void(0)" onclick="iframe_modal(\'' . lang('Adicionar Favorito') . '\', \'' . URL_ROOT . '/acme_user/ajax_modal_bookmark_insert/' . $id_user . '\', \'' . URL_IMG . '/icon_insert.png\', 600, 450)">' . lang('Adicionar') . '</a></div>';
	$html .= '<h6>' . lang('Favoritos'). '</h6>';
	$html .= '</div>';
	$html .= '<div style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc">';
	if(count($bookmarks) > 0)
	{
		$i = 1;
		foreach($bookmarks as $link)
		{
			$html .= '<div class="user_bookmark" onmouseover="show_bullet_update_bookmark(' . $i . ')" onmouseout="clear_bullet_update_bookmark(' . $i . ')">';
			$html .= '<div style="float:right;cursor:pointer;display:none;" id="img_user_bookmark_' . $i . '" onclick="show_form_options_update_bookmark(' . $i . ', ' . get_value($link, 'id_user_bookmark') . ')"><img src="' . URL_IMG . '/icon_bullet_edit.png" style="right:16px;background-color:#e9e9e9;border:4px solid #e9e9e9;position:absolute;width:10px;margin:-2px 0px 0 0 !important;" /></div>';
			
			// Adiciona form de edição/deleção dos bookmarks
			$html .= '<div class="font_11 form_user_bookmark" id="form_user_bookmark_' . $i . '">';
				$html .= '<img src="' . URL_IMG . '/icon_arrow_balloon_up.png" style="float:right;width:14px;margin:-9px 15px 0 0;" />';
				$html .= '<img src="' . URL_IMG . '/icon_bullet_close.png" title="' . lang('Fechar') . '" style="float:right;width:13px;margin:3px 2px 0 0;cursor:pointer" onclick="close_form_options_update_bookmark(' . $i . ')" />';
				$html .= '<div style="margin-top:17px;" onclick="ajax_modal_bookmark_update(\'' . lang('Editar Favorito') . '\', ' . $i . ', ' . get_value($link, 'id_user_bookmark') . ')">' . lang('Editar') . '...</div>';
				$html .= '<div style="margin-bottom:5px;" onclick="ajax_modal_bookmark_delete(\'' . lang('Deletar Favorito') . '\', ' . $i . ', ' . get_value($link, 'id_user_bookmark') . ')">' . lang('Deletar') . '...</div>';
			$html .= '</div>';
			
			$html .= '<div class="inline top"><img src="' . URL_IMG . '/icon_bullet_external_link.gif" /></div>';
			$html .= '<div class="inline top" style="max-width:150px;margin:-2px 0 0 3px"><a href="' . eval_replace(get_value($link, 'link')) . '" target="_blank">' . get_value($link, 'name') . '</a></div>';
			$html .= '</div>';
			$i++;
		}
	} else {
		$html .= '<div class="font_11 comment" style="margin:8px 0px 8px 2px">' . lang('Nenhum favorito cadastrado.') . '</div>';
	}
	$html .= '</div>';
	// $html .= '<div style="margin-bottom:3px" class="font_11"><a href="javascript:void(0);">Adicionar página atual</a></div>';
	
	// Fecha box geral
	$html .= '</div>';
	
	return $html;
}