<?php
/**
* menu()
* Função de montagem do menu padrão do sistema. Quando invocada pelo objeto template do acme engine, 
* recebe automaticamente um array de menus em organizados em formato de árvore, para construção em
* níveis e subníveis, utilizando recursão.
* @param array menus
* @return string html
*/
function menu($menus = array())
{
	// Verifica se o level atual é raiz ou não (PARENT <= 0)
	$linha_atual = isset($menus[0]) ? $menus[0] : array();
	$bool_root_level = (get_value($linha_atual, 'id_menu_parent') <= 0) ? true : false;
	
	// Inicializa bloco de menu
	$html = '<ul class="' . (($bool_root_level) ? 'nav navbar-nav side-nav ' : 'dropdown-menu') . '">';
	
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
			$link = eval_replace(get_value($menu, 'link'));
			$target = (get_value($menu, 'target') != '') ? ' target="' . eval_replace(get_value($menu, 'target')) . '" ' : '';
			$img = (get_value($menu, 'url_img') != '') ? '<img src="' . eval_replace(get_value($menu, 'url_img')) . '" style="width:12px !important;margin:-2px 5px 0 0;" />' : '';
			$title = eval_replace(get_value($menu, 'description'));
			$javascript = " " . eval_replace(get_value($menu, 'javascript')) . " ";
			$label = lang(get_value($menu, 'lang_key_rotule'));
			
			// Monta o label conforme possui filho ou nao
			if($count_menu_children > 0)
			{
				$html .= '<li class="dropdown">
						  <a href="' . $link . '" class="dropdown-toggle" data-toggle="dropdown" ' . $target . $javascript . ' title="' . $title . '">' . $img . $label . '<b class="caret"></b></a>';
				$html .=  menu(get_value($menu, 'children')) . '</li>';
			} else {
				$html .= '<li><a href="' . $link . '" ' . $target . $javascript . ' title="' . $title . '">' . $img . $label . '</a></li>';
			}
		}
	} else {
		// Aviso de sem menus
		// $html .= '<li class="pureCssMenui"><a class="pureCssMenui" href="#" style="font-style:italic"><img src="' . URL_IMG . '/icon_warning.png" style="display:block" />' . lang('Nenhum menu cadastrado no banco de dados') . '</a></li>';
	}
	
	// Menu sair
	// $html .= (get_value($linha_atual, 'id_menu_parent') <= 0) ? '<li class="pureCssMenui" style="float:right;margin-right:35px;"><a class="pureCssMenui" href="' . URL_ROOT . '/acme_access/logout" title="' . lang('Sair do sistema') . '"><img src="' . URL_IMG . '/icon_logout.png" style="display:block" />Sair</a></li>' : '';
	
	$html .= '</ul>';
	
	return $html;
	
	/*
	ESTRUTURA PADRÃO DO MENU BOOSTRAP LATERAL
	  <ul class="nav navbar-nav side-nav">	
		<li class="active"><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="charts.html"><i class="fa fa-bar-chart-o"></i> Charts</a></li>
		<li><a href="tables.html"><i class="fa fa-table"></i> Tables</a></li>
		<li><a href="forms.html"><i class="fa fa-edit"></i> Forms</a></li>
		<li><a href="typography.html"><i class="fa fa-font"></i> Typography</a></li>
		<li><a href="bootstrap-elements.html"><i class="fa fa-desktop"></i> Bootstrap Elements</a></li>
		<li><a href="bootstrap-grid.html"><i class="fa fa-wrench"></i> Bootstrap Grid</a></li>
		<li><a href="blank-page.html"><i class="fa fa-file"></i> Blank Page</a></li>
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Dropdown <b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="#">Dropdown Item</a></li>
			<li><a href="#">Another Item</a></li>
			<li><a href="#">Third Item</a></li>
			<li><a href="#">Last Item</a></li>
		  </ul>
		</li>
	  </ul>
	*/
}