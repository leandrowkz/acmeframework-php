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
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para alterar a senha de acesso atual. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/ajax_change_password_process" method="post">
			<input type="hidden" name="id_user" id="id_user" value="<?php echo get_value($user, 'id_user') ?>" />
			<input type="hidden" name="login" id="login" value="<?php echo get_value($user, 'login') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados da Senha de Acesso') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Senha Atual')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="password" name="actual_password" id="actual_password" class="validate[required]" maxlength="250" style="width:150px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Mínimo 6 caracteres')?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Nova Senha')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="password" name="new_password" id="new_password" class="validate[required,minSize[6]]]" maxlength="250" style="width:150px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Mínimo 6 caracteres')?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Repita Nova Senha')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="password" name="repeat_password" id="repeat_password" class="validate[required,minSize[6],equals[new_password]]]" maxlength="250" style="width:150px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Repita a nova senha')?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
