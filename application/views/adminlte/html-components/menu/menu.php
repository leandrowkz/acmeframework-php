<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component menu.php
 *
 * This HTML component build the application menu.
 *
 * It is loaded by the call $this->template->load_menu();
 *
 * The menu structure is:
 *
 * $menus[0] = array(
 * 		[id_menu] => 2
 * 		[id_menu_parent] => 0
 * 		[id_user_group] => 1
 * 		[label] =>
 * 		[link] => {URL_ROOT}/app-dashboard
 * 		[target] =>
 * 		[url_img] => <i class="fa fa-fw fa-home"></i>
 * 		[order_] => 10
 * 		[children] => Array ( . . . )
 * )
 *
 * @param    array $menus
 * @since    28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
?>

<?php

function build_menu ($menus = array()) {

	// Check if current level is parent
	$current_line = isset($menus[0]) ? $menus[0] : array();
	$root_level = (get_value($current_line, 'id_menu_parent') <= 0) ? true : false;

	if( count($menus) > 0 ) {
		foreach($menus as $menu) {

			// DEBUG:
			// print_r($menu);

			// Counting children menu
			$count_menu_children = count(get_value($menu, 'children'));

			// Build a link
			$link = tag_replace(get_value($menu, 'link'));
			$target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
			$label = lang(get_value($menu, 'label'));
			$img = image(get_value($menu, 'url_img'));

			// Build a single line menu
			if($count_menu_children > 0) {

				$class = $root_level ? 'treeview' : '';
				$caret = $root_level ? '<span class="caret"></span>' : '';

			?>
				<li class="<?php echo $class ?>">
					<a href="<?php echo $link ?>" <?php echo $target ?> class="dropdown-toggle" data-toggle="dropdown">
						<?php echo $img ?>
						<span><?php echo $label ?></span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu"><?php build_menu(get_value($menu, 'children')) ?></ul>
				</li>
			<?php
			} else {
			?>
				<li>
					<a href="<?php echo $link ?>" <?php echo $target ?> >
						<?php echo $img ?>
						<span><?php echo $label ?></span>
					</a>
				</li>
			<?php
			}
		}
	}
}

	// <li class="treeview">
 //                    <a href="#">
 //                    <i class="fa fa-share"></i> <span>Multilevel</span>
 //                    <i class="fa fa-angle-left pull-right"></i>
 //                    </a>
 //                    <ul class="treeview-menu">
 //                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
 //                    <li>
 //                    <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
 //                    <ul class="treeview-menu">
 //                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
 //                    <li>
 //                      <a href="#"><i class="fa fa-circle-o"></i> Level Two </a>
 //                      <ul class="treeview-menu">
 //                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
 //                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
 //                      </ul>
 //                    </li>
 //                    </ul>
 //                    </li>
 //                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
 //                    </ul>
 //                    </li>

build_menu($menus);
?>
