<?php
/**
*
* menu()
*
* Função de montagem do menu padrão do sistema. Quando invocada pelo objeto template do acme engine, 
* recebe automaticamente um array de menus em organizados em formato de árvore, para construção em
* níveis e subníveis, utilizando recursão.
*
* Estrutura padrão do nav:
*	<ul class="nav" id="side-menu">
*	    <li>
*	        <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
*	    </li>
*	    <li>
*	        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
*	        <ul class="nav">
*	            <li>
*	                <a href="flot.html">Flot Charts</a>
*	            </li>
*	            <li>
*	                <a href="morris.html">Morris.js Charts</a>
*	            </li>
*	        </ul>
*	    </li>
*	</ul>
*
* @param array menus
* @return string html
*
*/
function menu ($menus = array())
{
	// Verifica se o level atual é raiz ou não (PARENT <= 0)
	$linha_atual = isset($menus[0]) ? $menus[0] : array();
	$bool_root_level = (get_value($linha_atual, 'id_menu_parent') <= 0) ? true : false;

	// Inicializa bloco de menu
	$html = '<ul class="nav" ' . (($bool_root_level) ? 'id="side-menu"' : '') . '>';
	
	if(count($menus) > 0)
	{
		// Varre os menus cadastrados no banco, ordenados em formato de árvore
		foreach($menus as $menu)
		{
			// DEBUG: 
			// print_r($menu);
			
			// Contagem de menus-filho
			$count_menu_children = count(get_value($menu, 'children'));
			
			// Monta link
			$link = tag_replace(get_value($menu, 'link'));
			$target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
			$label = lang(get_value($menu, 'label'));
			
			// Img pode ser font-awesome saiba mais em http://fortawesome.github.io/Font-Awesome/
			if(stristr(get_value($menu, 'url_img'), '<i class="')) {
				$img = get_value($menu, 'url_img');
			} else {
				$img = (file_exists() && get_value($menu, 'url_img') != '') ? '<img src="' . tag_replace(get_value($menu, 'url_img')) . '" style="display:block !important;" />' : '';
			}
			
			// Monta o label conforme possui filho ou nao
			if($count_menu_children > 0)
			{
				$html .=  '<li><a href="' . $link . '"' . $target . '>' . $img . ' ' . $label . '<span class="fa arrow"></span></a>';
				$html .=  menu(get_value($menu, 'children')) . '</li>';
			} else {
				$html .=  '<li><a href="' . $link . '"' . $target . '>' . $img . ' ' . $label . '</a></li>';
			}
		}
	} else {
		// Aviso sem menus
		// $html .= '';
	}
	
	// Fecha bloco de menu	
	$html .= '</ul>';

	// Inicializa menu
	$html .= '<script src="' . URL_JS . '/plugins/metisMenu/jquery.metisMenu.js"></script>';
	$html .= "<script> $(function() { $('#side-menu').metisMenu(); }); </script>";
	
	return $html;
}