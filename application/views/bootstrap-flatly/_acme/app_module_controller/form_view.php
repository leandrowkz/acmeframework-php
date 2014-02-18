<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Visualização')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Visualização de Registro') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('note', '', lang('Visualize nesta página os dados do registro selecionado.')) ?></div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:30px">
		<h5><?php echo lang('Dados do Registro')?></h5>
		<hr style="margin-bottom:10px;" />
		<?php
		$action = (get_value($form, 'action') != '') ? eval_replace(get_value($form, 'action')) : URL_ROOT . '/' . $this->controller . '/form_process';
		$enctype = (get_value($form, 'enctype') != '') ? 'enctype="' . get_value($form, 'enctype') . '"' : '';
		$method = (get_value($form, 'method') != '') ? get_value($form, 'method') : 'post';
		?>
		<form id="form_default" name="form_default" action="<?php echo $action ?>" method="<?php echo $method ?>" <?php echo $enctype ?>>
			<input type="hidden" name="operation" id="operation" value="<?php echo $operation ?>" />
			<input type="hidden" name="primary_key_value" id="primary_key_value" value="<?php echo $pk_value ?>" />
			<div id="box_group_view">
				<?php 
				$i = 1;
				foreach($fields as $field) {
				$class = ($i % 2 == 0) ? '' : 'class="odd"';
				?>
				<div <?php echo $class ?>>
					<div id="label_view"><?php echo lang(get_value($field, 'lang_key_label')) ?></div>
					<div id="field_view"><?php echo nl2br(htmlspecialchars(get_value($values, get_value($field, 'table_column'))))?></div>
				</div>
				<?php $i++; } ?>
			</div>
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar')?></a></div>
			</div>
		</form>
	</div>
</div>