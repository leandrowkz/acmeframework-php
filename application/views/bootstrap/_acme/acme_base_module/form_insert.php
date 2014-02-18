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
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Inserção')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Inserção de Registro') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Utilize o formulário abaixo para inserir um novo registro em ') . lang($this->lang_key_rotule) . lang('. Campos com (*) são obrigatórios.')) ?></div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:30px">
		<h5><?php echo lang('Formulário de Inserção')?></h5>
		<hr style="margin-bottom:10px;" />
		<?php
		$action = (get_value($form, 'action') != '') ? eval_replace(get_value($form, 'action')) : URL_ROOT . '/' . $this->controller . '/form_process';
		$enctype = (get_value($form, 'enctype') != '') ? 'enctype="' . get_value($form, 'enctype') . '"' : '';
		$method = (get_value($form, 'method') != '') ? get_value($form, 'method') : 'post';
		?>
		<form id="form_default" name="form_default" action="<?php echo $action ?>" method="<?php echo $method ?>" <?php echo $enctype ?>>
			<input type="hidden" name="operation" id="operation" value="<?php echo $operation ?>" />
			<?php 
			$i = 1;
			foreach($html_fields as $label => $field) {
			$class = ($i % 2 == 0) ? '' : 'class="odd"';
			?>
			<div id="form_line" <?php echo $class ?>>
				<div class="form_label font_11 bold" style="width:150px"><?php echo $label?></div>
				<div class="form_field"><?php echo $field?></div>
			</div>
			<?php $i++; } ?>
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar')?></a></div>
			</div>
		</form>
	</div>
</div>