<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
		$("input:text").setMask();
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<?php if(count($this->menus) > 0){ ?>
		<div id="module_menus" class="inline top">
			<?php foreach($this->menus as $menu) { ?>
			<div class="inline top module_menu_item" title="<?php echo get_value($menu, 'description')?>">
				<?php if(get_value($menu, 'url_img') != '') { ?>
				<img class="inline top" src="<?php echo $this->tag->eval_replace(get_value($menu, 'url_img'))?>" />
				<?php } ?>
				<h6 class="inline top"><a href="<?php echo $this->tag->eval_replace(get_value($menu, 'link'))?>" <?php echo(get_value($menu, 'target') != '' ? 'target="' . get_value($menu, 'target') . '"' : '')?> <?php echo(get_value($menu, 'javascript') != '' ? get_value($menu, 'javascript') : '')?>><?php echo lang(get_value($menu, 'lang_key_rotule'))?></a></h6>
			</div>
			<?php } ?>
		</div>
		<?php } ?>		
	</div>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description"><?php echo nl2br($this->description); ?></div>
	
	<!-- FILTROS E LISTAGEM DE DADOS -->
	<table width="100%" id="module_table">
	<tr>
		<td colspan="2">
			<?php if($module_form_filter != ''){ ?>
			<div id="line_filter">
				<img id="column_filter_img" src="<?php echo URL_IMG ?>/icon_bullet_minus.png" />
				<a href="javascript:void(0)" onclick="show_area('column_filter', 'column_filter_img')" class="black inline top font_shadow_gray"><h5 id="form_filter_title"><?php echo lang('Filtros da Consulta')?></h5></a>
			</div>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $module_table; ?></td>
		<td id="column_filter" width="200" nowrap style="padding-left:50px;<?php echo(($module_form_filter == '') ? 'display:none;' : ''); ?>"><?php echo $module_form_filter ?></td>
	</tr>
	</table>
</div>