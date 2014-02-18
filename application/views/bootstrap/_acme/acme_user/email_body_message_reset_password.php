<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
</head>
<body style="padding:20px">
	<div id="modal_content">
		<img src="<?php echo eval_replace($this->app_config->app_logo); ?>" style="max-width:130px" />
		<br />
		<hr style="margin:5px 0 10px 0" />
		<div class="font_11" style="line-height:18px;">
			<div><?php echo lang('Olá') . ' <strong>' . get_value($user, 'name'); ?></strong>!</div>
			<div style="margin-top:10px"><?php echo lang('Utilize este email para atualizar sua senha de acesso ao sistema. Verifique abaixo seus dados de acesso e caso existam divergências, descarte esta mensagem e solicite o reenvio novamente.')?></div>
			<div style="margin-top:10px"><?php echo lang('Seu login')?>: <strong><?php echo get_value($user, 'login') ?></strong></div>
			<div><?php echo lang('Seu email')?>: <strong><?php echo get_value($user, 'email') ?></strong></div>
			<div style="margin-top:10px"><?php echo lang('Para atualizar sua senha de acesso, clique')?> <a href="<?php echo URL_ROOT ?>/acme_access/reset_password/<?php echo get_value($user, 'id_user') ?>/<?php echo $key_access; ?>" target="_blank">aqui</a>.</div>
			<div style="margin-top:10px"><?php echo lang('Caso você tenha problemas de acesso com o link acima, copie a URL abaixo e cole em uma nova aba do seu navegador:')?></div>
			<div><?php echo URL_ROOT ?>/acme_access/reset_password/<?php echo get_value($user, 'id_user') ?>/<?php echo $key_access; ?></div>
		</div>
		<br />
		<hr />
	</div>
</body>
</html>
