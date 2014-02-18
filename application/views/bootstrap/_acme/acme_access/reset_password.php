<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
	<?php if($allow_update) { ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
			enable_form_validations();
			$('#password').focus();
		});
	</script>
	<?php } ?>
</head>
<body style="background-color:#f5f5f5;">
	<div style="width:500px;margin:0 auto;top:15%;position:relative;">
	<div class="generic_box">
		<div id="header"><h6 class="white font_shadow_black"><img src="<?php echo URL_IMG ?>/icon_help.png" style="margin-top:3px;" /><?php echo lang('Esqueceu sua senha ?')?></h6></div>	
		<div id="content">
			<img src="<?php echo URL_IMG ?>/logo.png" class="inline top" style="width:170px" />
			<div style="width:250px;margin-left:30px;" class="inline top">
				<?php if(!$allow_update) { ?>
				<?php echo message('warning', lang('Ops!'), '<span class="font_11">' . lang('O link que você está tentando acessar é inválido. Isto pode acontecer caso a senha já tenha sido atualizada por este mesmo link.') . '</span>'); ?>
				<div style="margin-top:35px">
					<hr />
					<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_access/login')"><?php echo lang('OK')?></button></div>
				</div>
				<?php } else { ?>
				<span class="font_11"><?php echo lang('Falta pouco para você alterar sua senha de acesso. Preencha a nova senha e clique em OK para continuar.');?></span>
				<form name="form_default" id="form_default" action="<?php echo URL_ROOT ?>/acme_access/reset_password_process" method="post">
					<input type="hidden" name="id_user" id="id_user" value="<?php echo get_value($reset_pass, 'id_user') ?>" />
					<input type="hidden" name="key_access" id="key_access" value="<?php echo get_value($reset_pass, 'key_access') ?>" />
					<div style="margin-top:20px;" class="bold"><h6><?php echo lang('Nova Senha');?></h6></div>
					<input type="password" name="password" id="password" value="" style="width:170px;" class="validate[required,minSize[6]]" />
					<div style="margin-top:5px;"class="font_11 comment"><?php echo lang('Mínimo 6 caracteres')?></div>
					<div style="margin-top:20px;" class="bold"><h6><?php echo lang('Repita a Nova Senha');?></h6></div>
					<input type="password" name="password_repeat" id="password_repeat" value="" class="validate[required,minSize[6],equals[password]]" style="width:170px;" />
					<div style="margin-top:35px">
						<hr />
						<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('OK, Alterar Senha!')?>" /></div>
						<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_access/login"><?php echo lang('cancelar')?></a></div>
					</div>
				</form>
				<br />
				<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>