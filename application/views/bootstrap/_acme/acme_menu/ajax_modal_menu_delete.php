<?php
	function custom_menu_tree($menus = array(), $data = array(), $children_forever = false) 
	{
		$html = '';
		
		// Varre os menus cadastrados no banco, ordenados em formato de árvore
		foreach($menus as $menu)
		{
			if(get_value($menu, 'id_menu') == get_value($data, 'id_menu') || $children_forever == true)
			{
				// Contagem de menus-filho
				$count_menu_children = count(get_value($menu, 'children'));
				
				// Monta o label conforme possui filho ou nao
				if($count_menu_children > 0)
				{
					$html .= '<li id="menu_li_' . get_value($menu, 'id_menu') . '" class="dd-item dd3-item" data-id="' . get_value($menu, 'id_menu') . '" order="' . get_value($menu, 'order_') . '">';
					$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' . lang(get_value($menu, 'lang_key_rotule'));
						$html .= '<div id="box_controls" style="float:right;display:none;">';
						$html .= '<img src="' . URL_IMG . '/icon_update.png" title="Editar Menu do Sistema" onclick="iframe_modal(\'' . lang('Editar Menu do Sistema') . '\', \'' . URL_ROOT . '/acme_menu/ajax_modal_menu_update/' . get_value($menu, 'id_menu') . '\', \'' . URL_IMG . '/icon_update.png\', 700, 600)" style="cursor:pointer;margin-right:10px" />';
						$html .= '<img src="' . URL_IMG . '/icon_delete.png" title="Deletar Menu" onclick="iframe_modal(\'' . lang('Deletar Menu') . '\', \'' . URL_ROOT . '/acme_menu/ajax_modal_menu_delete/' . get_value($menu, 'id_menu') . '\', \'' . URL_IMG . '/icon_delte.png\', 700, 600)" style="cursor:pointer" />';
						$html .= '</div>';
					$html .= '</div>';
					$html .= '<ol class="dd-list">' . custom_menu_tree(get_value($menu, 'children'), $data, true) . '</ol></li>';
				} else {
					$html .= '<li id="menu_li_' . get_value($menu, 'id_menu') . '" class="dd-item dd3-item" data-id="' . get_value($menu, 'id_menu') . '" order="' . get_value($menu, 'order_') . '">';
					$html .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' . lang(get_value($menu, 'lang_key_rotule'));
						$html .= '<div id="box_controls" style="float:right;display:none;">';
						$html .= '<img src="' . URL_IMG . '/icon_update.png" title="Editar Menu do Sistema" onclick="iframe_modal(\'' . lang('Editar Menu do Sistema') . '\', \'' . URL_ROOT . '/acme_menu/ajax_modal_menu_update/' . get_value($menu, 'id_menu') . '\', \'' . URL_IMG . '/icon_update.png\', 700, 600)" style="cursor:pointer;margin-right:10px" />';
						$html .= '<img src="' . URL_IMG . '/icon_delete.png" title="Deletar Menu" onclick="iframe_modal(\'' . lang('Deletar Menu') . '\', \'' . URL_ROOT . '/acme_menu/ajax_modal_menu_delete/' . get_value($menu, 'id_menu') . '\', \'' . URL_IMG . '/icon_delte.png\', 700, 600)" style="cursor:pointer" />';
						$html .= '</div>';
					$html .= '</div>';
					$html .= '</li>';
				}
			} elseif(count(get_value($menu, 'children')) > 0) {
				$html .= custom_menu_tree(get_value($menu, 'children'), $data);
			}
		}
		return $html;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_js_file('jquery.nestable.js'); ?>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			// Monta o nestable na lista de menus
			$('.dd').nestable();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('warning', lang('ATENÇÃO!'), lang('O menu que está sendo visualizado e todos os seus filhos serão deletados. Faça a deleção caso você tenha certeza desta ação. Para confirmar a deleção deste menu e seus filhos, clique em <strong>ok</strong>, caso contrário clique em <strong>cancelar</strong>.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_menu/ajax_modal_menu_delete_process" method="post">
			<input type="hidden" name="id_menu" id="id_menu" value="<?php echo get_value($data, 'id_menu') ?>" />
			<br />
			<h5 class="font_shadow_gray inline top"><?php echo lang('Dados do Menu') ?></h5>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div class="odd">
					<div id="label_view"><?php echo lang('ID (#)') ?></div>
					<div id="field_view"><?php echo get_value($data, 'id_menu') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Rótulo do Menu') ?></div>
					<div id="field_view"><?php echo lang(get_value($data, 'lang_key_rotule')) ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Link') ?></div>
					<div id="field_view"><?php echo htmlentities(get_value($data, 'link')) ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h5 class="font_shadow_gray inline top"><?php echo lang('Bloco de Menus que será Deletado') ?></h5>
			<hr style="margin-bottom:5px" />
			<div class="dd"><ol class="dd-list"><?php echo custom_menu_tree($menus, $data); ?></ol></div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
