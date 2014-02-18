<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
</head>
<body style="background-color:#f5f5f5">
	<div style="width:700px;margin:0 auto;top:15%;position:relative;">
		<div class="center inline top" style="width:200px;margin-right:15px;">
			<a href="<?php echo URL_ROOT ?>"><img src="<?php echo URL_IMG ?>/logo.png" class="inline top" style="width:170px" /></a>
		</div>
		<div class="inline top" style="width:400px;border-left:2px solid #ccc;padding:2px 0px 5px 15px;">
			<h1 class="font_shadow_gray" style="padding:0;margin:-22px 0 20px 0"><?php echo lang('Ops!')?></h1>
			<h3 class="font_shadow_gray" style="margin-bottom:25px"><?php echo lang('Página não encontrada.')?></h3>
			<div style="margin:20px 0"><?php echo lang('A página que você está tentando acessar não está mais disponível ou não existe. Verifique o endereço digitado e tente novamente.') ?></div>
			<div style="margin:20px 0"><?php echo lang('Página solicitada: ') . '<h6>' . $this->input->get_post('page') . '</h6>' ?></div>
			<a href="<?php echo $url_default ?>"><?php echo lang('Ir para página inicial')?></a>
		</div>
	</div>
</body>
</html>