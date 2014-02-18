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
			$('#user').focus();
		});
	</script>
</head>
<body style="background-color:#f5f5f5;">
	<div style="width:500px;margin:0 auto;top:15%;position:relative;">
	<div class="generic_box">
		<div id="header"><h6 class="white font_shadow_black"><?php echo lang('Bem-vindo(a)!')?></h6></div>	
		<div id="content">
			<img src="<?php echo URL_IMG ?>/logo.png" class="inline top" style="width:170px" />
			<div style="width:250px;margin-left:30px;" class="inline top">
				<span><?php echo lang('Insira seu nome de usuário e senha para continuar.');?></span>
				<form action="<?php echo URL_ROOT ?>/acme_access/login_process" method="post">
					<div style="margin-top:12px;" class="bold"><h6><?php echo lang('Usuário');?></h6></div>
					<input type="text" name="user" id="user" value="<?php echo $login_user; ?>" style="width:195px;<?php echo ($bool_user_error === true) ? 'border:1px solid red' : ''; ?>" /><br />
					<?php echo ($login_msg_error != '') ? '<span class="font_error">' . $login_msg_error . '</span>' : ''; ?>
					<div style="margin-top:13px" class="bold"><h6><?php echo lang('Senha');?></h6></div>
					<input type="password" name="pass" id="pass" style="width:195px;" /><br />
					<div style="margin-top:5px;"><a href="<?php echo URL_ROOT ?>/acme_access/forgot_password"><?php echo lang('Esqueceu sua senha?');?></a></div>
					<div style="margin-top:25px">
						<input type="submit" value="<?php echo lang('Entrar');?>" class="inline top" />
						<!--
						<div class="inline top" style="margin:10px 0 0 10px;">
							<input type="checkbox" name="keep_connected" id="keep_connected" class="inline top" />
							<div class="inline top font_11" style="margin-top:-2px"><?php echo lang('Mantenha-me conectado');?></div>
						</div>
						-->
					</div>
				</form>
				<br />
			</div>
		</div>
	</div>
</body>
</html>