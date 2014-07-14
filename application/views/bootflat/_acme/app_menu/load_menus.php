<?php
	function custom_menu_tree($menus = array()) 
	{
		$html = '';
		
		// Varre os menus cadastrados no banco, ordenados em formato de árvore
		foreach($menus as $menu)
		{
			// Contagem de menus-filho
			$count_menu_children = count(get_value($menu, 'children'));
			
			// Monta o label conforme possui filho ou nao
			if($count_menu_children > 0)
			{
				$html .= '<li id="menu_li_' . get_value($menu, 'id_menu') . '" class="dd-item dd3-item" data-id="' . get_value($menu, 'id_menu') . '" order="' . get_value($menu, 'order_') . '">';
				$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">';
					$html .= (get_value($menu, 'dtt_inative') != '') ? '<span class="font_red">' . lang(get_value($menu, 'label')) . '</span>' : lang(get_value($menu, 'label'));
					$html .= '<div id="box_controls" style="float:right;display:none;">';
						$html .= '</div>';
				$html .= '</div>';
				$html .= '<ol class="dd-list">' . custom_menu_tree(get_value($menu, 'children')) . '</ol></li>';
			} else {
				$html .= '<li id="menu_li_' . get_value($menu, 'id_menu') . '" class="dd-item dd3-item" data-id="' . get_value($menu, 'id_menu') . '" order="' . get_value($menu, 'order_') . '">';
				$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">';
					$html .= (get_value($menu, 'dtt_inative') != '') ? '<span class="font_red">' . lang(get_value($menu, 'label')) . '</span>' : lang(get_value($menu, 'label'));
					$html .= '<div id="box_controls" style="float:right;display:none;">';
					$html .= '</div>';
				$html .= '</div>';
				$html .= '</li>';
			}
		}
		return $html;
	}
?>

<link href="<?php echo URL_CSS ?>/plugins/nestable/nestable.css" rel="stylesheet" type="text/css" />

<script src="<?php echo URL_JS ?>/plugins/nestable/jquery.nestable.js"></script>

<div class="dd"><ol class="dd-list"><?php echo custom_menu_tree($menus); ?></ol></div>

<script>
	
	$('.dd').nestable({
		dropCallback: function(details) {
			// alert(details.destId);
			// ajax_reorder_menu(details.sourceId, details.destId);
		}
	});
		
	$('.dd3-content').on('mouseover', function() {
		$(this).find('#box_controls').show();
	});
		
	$('.dd3-content').on('mouseout', function() {
		$(this).find('#box_controls').hide();
	});

</script>