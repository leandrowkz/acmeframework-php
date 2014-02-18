<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			enable_form_validations();
			enable_masks();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
		<?php if(!stristr(get_value($module, 'controller'), 'acme_') || $manage_acme_modules_permission === true) {?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para adicionar uma nova permissão a este módulo. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_permission_new_process" method="post">
			<input type="hidden" name="id_module" id="id_module" value="<?php echo $id_module ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados da Permissão') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo da Permissão')?>*</div>
				<div class="form_field"><input type="text" name="lang_key_rotule" id="lang_key_rotule" value="" class="validate[required]" style="width:300px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Nome da Permissão')?>*</div>
				<div class="form_field">
					<input type="text" name="permission" id="permission" value="" style="width:120px;" class="validate[required,custom[onlyLetterNumberChrSpecials]]" />
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('Este nome será o utilizado para teste de permissão em código-fonte') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição da Permissão')?></div>
				<div class="form_field"><textarea name="description" id="description" style="width:400px;height:100px"></textarea></div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
		<?php } else { ?>
		<?php echo message('warning', lang('ATENÇÃO!'), lang('Este é um módulo interno (do ACME) e você não possui permissões de gerenciamento de módulos internos. Revise suas permissões para poder alterar estes dados.')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
		</div>
		<?php } ?>
	</div>
</body>
</html>
