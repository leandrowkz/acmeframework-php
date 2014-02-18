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
	$html = '<ul class="' . (($bool_root_level) ? 'pureCssMenu ' : '') . 'pureCssMenum">';
	
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
			$img = (get_value($menu, 'url_img') != '') ? '<img src="' . eval_replace(get_value($menu, 'url_img')) . '" syle="display:block !important;" />' : '';
			$title = eval_replace(get_value($menu, 'description'));
			$javascript = " " . eval_replace(get_value($menu, 'javascript')) . " ";
			$label = lang(get_value($menu, 'lang_key_rotule'));
			
			// Monta o label conforme possui filho ou nao
			if($count_menu_children > 0)
			{
				$html .=  '<li class="pureCssMenui"><a class="pureCssMenui" href="' . $link . '"' . $target . $javascript . ' title="' . $title . '"><span>' . $img . $label . '</span></a>';
				$html .=  menu(get_value($menu, 'children')) . '</li>';
			} else {
				$html .=  '<li class="pureCssMenui"><a class="pureCssMenui" href="' . $link . '"' . $target . $javascript . ' title="' . $title . '"><div>' . $img . $label . '</div></a></li>';
			}
		}
	} else {
		// Aviso de sem menus
		// $html .= '<li class="pureCssMenui"><a class="pureCssMenui" href="#" style="font-style:italic"><img src="' . URL_IMG . '/icon_warning.png" style="display:block" />' . lang('Nenhum menu cadastrado no banco de dados') . '</a></li>';
	}
	
	// Menu sair
	$html .= (get_value($linha_atual, 'id_menu_parent') <= 0) ? '<li class="pureCssMenui" style="float:right;margin-right:35px;"><a class="pureCssMenui" href="' . URL_ROOT . '/acme_access/logout" title="' . lang('Sair do sistema') . '"><img src="' . URL_IMG . '/icon_logout.png" style="display:block" />Sair</a></li>' : '';
	
	$html .= '</ul>';
	
	return $html;
	
	/*
	ESTRUTURA PADRÃO DO PURECSSMENU
	<ul class="pureCssMenu pureCssMenum">
		<li class="pureCssMenui"><a class="pureCssMenui" href="#">PureCSSMenu.com</a></li>
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Product Info</span></a>
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="#">What is New?</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Menu Features</span></a>
			<ul class="pureCssMenum">
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">Free Online Generator</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">100% Pure CSS Menu</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">No Javascript Required</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">Multi Level Submenus</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">Search-Engine Friendly</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">Advanced Styling</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">Horizontal & Vertical</a></li>
			</ul>
			</li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>How To Use</span></a>
			<ul class="pureCssMenum">
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">1. Select Template</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">2. Customize Items</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="#">3. Download Zip</a></li>
			</ul>
			</li>
		</ul>
		</li>
	</ul>
	*/
}