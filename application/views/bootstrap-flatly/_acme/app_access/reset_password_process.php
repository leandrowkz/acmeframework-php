<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
</head>
<body style="background-color:#f5f5f5;">
	<div style="width:500px;margin:0 auto;top:15%;position:relative;">
	<div class="generic_box">
		<div id="header"><h6 class="white font_shadow_black"><img src="<?php echo URL_IMG ?>/icon_help.png" style="margin-top:3px;" /><?php echo lang('Esqueceu sua senha ?')?></h6></div>	
		<div id="content">
			<img src="<?php echo URL_IMG ?>/logo.png" class="inline top" style="width:170px" />
			<div style="width:250px;margin-left:30px;" class="inline top">
				<?php echo message('success', lang('Pronto!'), '<span class="font_11">' . lang('Senha de acesso alterada com sucesso. Utilize a nova senha no próximo acesso ao sistema.') . '</span>'); ?>
				<div style="margin-top:35px">
					<hr />
					<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_access/login')"><?php echo lang('OK')?></button></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>