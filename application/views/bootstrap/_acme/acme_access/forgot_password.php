<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
			enable_form_validations();
			$('#login').focus();
		});
	</script>
</head>
<body style="background-color:#f5f5f5;">
	<div style="width:500px;margin:0 auto;top:15%;position:relative;">
	<div class="generic_box">
		<div id="header"><h6 class="white font_shadow_black"><img src="<?php echo URL_IMG ?>/icon_help.png" style="margin-top:3px;" /><?php echo lang('Esqueceu sua senha ?')?></h6></div>	
		<div id="content">
			<img src="<?php echo URL_IMG ?>/logo.png" class="inline top" style="width:170px" />
			<div style="width:250px;margin-left:30px;" class="inline top">
				<span class="font_11"><?php echo lang('Você deve inserir seu login de acesso para continuar.');?></span>
				<form name="form_default" id="form_default" action="<?php echo URL_ROOT ?>/acme_access/forgot_password_process" method="post">
					<div style="margin-top:12px;" class="bold"><h6><?php echo lang('Seu login');?></h6></div>
					<input type="text" name="login" id="login" value="" style="width:195px;" class="validate[required]" />
					<br />
					<br />
					<input type="checkbox" name="validate_human" id="validate_human" value="OHYEAH" class="validate[required]" />
					<div class="inline top font_11"><label for="validate_human"><?php echo lang('Clique para confirmar que você não é um robô') ?></label></div>
					<div style="margin-top:35px">
						<hr />
						<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Enviar')?>" /></div>
						<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_access/login"><?php echo lang('voltar')?></a></div>
					</div>
				</form>
				<br />
			</div>
		</div>
	</div>
</body>
</html>