<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
			$("input:text").setMask();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
	<?php if($error || get_value($form, 'dtt_inative') != '' || count($module) <= 0) {?>
		<?php echo message('warning', lang('Atenção!'), lang('O formulário que você está tentando editar ainda não foi marcado para uso. Selecione o checkbox correspondente ao formulário e tente novamente.')); ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
		</div>
	<?php } else { ?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para editar os dados do formulário. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_form_data_process" method="post">
			<input type="hidden" name="id_module" id="id_module" value="<?php echo get_value($module, 'id_module') ?>" />
			<input type="hidden" name="id_module_form" id="id_module_form" value="<?php echo get_value($form, 'id_module_form') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Propriedades do Formulário') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Módulo')?></div>
				<div class="form_field"><div style="margin-top:5px"><?php echo lang(get_value($module, 'lang_key_rotule')) ?></div></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Operação')?></div>
				<div class="form_field"><div style="margin-top:5px"><?php echo get_value($form, 'operation') ?></div></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Action')?></div>
				<div class="form_field"><input type="text" name="action" id="action" value="<?php echo htmlentities(get_value($form, 'action')) ?>" style="width:300px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Method')?></div>
				<div class="form_field"><input type="text" name="method" id="method" value="<?php echo get_value($form, 'method') ?>" style="width:150px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Enctype')?></div>
				<div class="form_field"><input type="text" name="enctype" id="enctype" value="<?php echo get_value($form, 'enctype') ?>" style="width:150px" /></div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
			</div>
		</form>
	<?php } ?>
	</div>
</body>
</html>
