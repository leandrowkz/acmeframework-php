<?php
/**
*
* user_info()
*
* Função de montagem do bloco das informações do usuário, como imagem, nome, etc.
*
* @param string id_user
* @param string login
* @param string email
* @param string username
* @param string usergroup
* @param string url_img
* @return string user_info
*
*/
function user_info($id_user = 0, $login = '', $email = '', $username = '', $usergroup = '', $url_img = '')
{
	// Coleta instancia do CI
	$CI =& get_instance();
	
	// Primeiro nome do usuário
	$first_name = get_value(explode(' ', $username), '0');

	// Ajusta imagem (caso não exista)
	$url_img = ( ! file_exists(PATH_UPLOAD . '/user_photos/' . basename($url_img)) || basename($url_img) == '') ? URL_IMG . '/user-unknown.png' : $url_img;

	// Linha de informações do usuário (e alguns controles)
	$html  = '	<li class="dropdown">';
	$html .= '	<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding:10px 15px 0 15px;">
              		<img src="' . $url_img . '" class="img-circle user-photo" />
                    <span class="user-info">
                        <small>' . lang('Bem vindo') . '</small>
                        <br />' . $first_name . '
                    </span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user" style="margin-right:-1px">
                    <li><a href="' . URL_ROOT . '/app_user/profile/' . $id_user . '"><i class="fa fa-user fa-fw"></i> ' . lang('Perfil') . '</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-cogs fa-fw"></i> ' . lang('Configurações') . '</a></li>
                    <li class="divider"></li>
                    <li>
                    	<a href="javascript:void(0)" onclick="ajax_change_language(\'en_US\')">
                    	<i class="fa fa-check fa-fw ' . (($CI->session->userdata('language') != 'en_US') ? 'icon-invisible' : '' ) . '"></i> ' . lang('Inglês (EUA)') . '</a>
                    </li>
                    <li>
                    	<a href="javascript:void(0)" onclick="ajax_change_language(\'pt_BR\')">
                    	<i class="fa fa-check fa-fw ' . (($CI->session->userdata('language') != 'pt_BR') ? 'icon-invisible' : '' ) . '"></i> ' . lang('Português (Brasil)') . '</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="http://www.acmeengine.org" target="_blank"><i class="fa fa-question-circle fa-fw"></i> ' . lang ('Ajuda') . '</a></li>
                    <li><a href="' . URL_ROOT . '/app_access/logout"><i class="fa fa-sign-out fa-fw"></i> ' . lang ('Sair') . '</a></li>
                </ul>
                </li>';
	
	// Retorna linha
	return $html;
}