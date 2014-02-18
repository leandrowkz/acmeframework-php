<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : false });
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
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('warning', lang('Atenção!'), lang('O formulário que você está tentando acessar não existe ou está configurado incorretamente. Tente novamente.')) ?></div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo URL_ROOT . '/' . $this->controller ?>'"><?php echo lang('ok')?></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar')?></a></div>
	</div>
</div>