<?php
/**
*
* menu()
*
* This function builds the application menu, located at top bar application. It also receives
* automatically all menus for the current group user.
*
* Default structure menu:
*
* <ul class="nav navbar-nav">
*
* 	 <li><a href="#">Home</a></li>
*    <li><a href="#about">About</a></li>
*    <li><a href="#contact">Contact</a></li>
*   
*    <li class="dropdown">
*        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
*        <ul class="dropdown-menu" role="menu">
*            <li><a href="#">Action</a></li>
*            <li><a href="#">Another action</a></li>
*            <li><a href="#">Something else here</a></li>
*            <li class="divider"></li>
*            <li class="dropdown-header">Nav header</li>
*            <li><a href="#">Separated link</a></li>
*            <li><a href="#">One more separated link</a></li>
*        </ul>
*    </li>
*    <li class="dropdown">
*      	 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
*        <ul class="dropdown-menu">
*            <li><a href="#">Notifications <i class="fa fa-wrench"></i></a></li>
*            <li class="dropdown dropdown-submenu">
*                <a href="#">Edit Account </a>
*                <ul class="dropdown-menu">
*                    <li><a href="#">Page with comments</a></li>
*                    <li><a href="#">Page with comments disabled</a></li>
*                    <li class="dropdown-submenu">
*                        <a href="#">More</a>
*                        <ul class="dropdown-menu">
*                            <li><a href="#">3rd level link more options</a></li>
*                            <li><a href="#">3rd level link</a></li>
*                        </ul>
*                    </li>
*                </ul>
*           </li>
*           <li class="divider"></li>
*           <li><i class="fa"></i><a href="#" class="dropdown-toggle" data-toggle="dropdown">Logout <i class="fa fa-power-off padding-left-ten-px red-text"></i></a>
*           </li>
*        </ul>
*    </li>
*
* </ul>	
*
* @param array menus
* @return string html
*
*/
function menu ($menus = array())
{
	// Check if current level is parent
	$current_line = isset($menus[0]) ? $menus[0] : array();
	$root_level = (get_value($current_line, 'id_menu_parent') <= 0) ? true : false;
	
	$html = '';

	if(count($menus) > 0) {
		foreach($menus as $menu) {
			
			// DEBUG: 
			// print_r($menu);
			
			// Counting children menu
			$count_menu_children = count(get_value($menu, 'children'));
			
			// Build a link
			$link = tag_replace(get_value($menu, 'link'));
			$target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
			$label = lang(get_value($menu, 'label'));
			
			// Image also can be a font-awesome - know more on fontawesome.github.io/Font-Awesome/
			if(stristr(get_value($menu, 'url_img'), 'class="fa'))
				$img = get_value($menu, 'url_img');
			else
				$img = (file_exists(tag_replace(get_value($menu, 'url_img'))) && get_value($menu, 'url_img') != '') ? '<img src="' . tag_replace(get_value($menu, 'url_img')) . '" style="display:block !important;" />' : '';
			
			// Build a single line menu
			if($count_menu_children > 0) {

				$class = $root_level ? 'dropdown' : 'dropdown dropdown-submenu';
				$caret = $root_level ? '<span class="caret"></span>' : '';

				$html .= '<li class="' . $class . '">';
					$html .= '<a href="' . $link . '"' . $target . ' class="dropdown-toggle" data-toggle="dropdown">';
					$html .= $img . ' ' . $label . $caret;
					$html .= '</a>';
					$html .= '<ul class="dropdown-menu">' . menu(get_value($menu, 'children')) . '</ul>';
				$html .= '</li>';
			} else
				$html .=  '<li><a href="' . $link . '"' . $target . '>' . $img . ' ' . $label . '</a></li>';
		}
	}
	return $html;
}