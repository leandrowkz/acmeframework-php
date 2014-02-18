<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
</head>
<body>
	<div id="modal_content">
		<h5 class="font_shadow_gray inline top"><?php echo lang('Dados do Arquivo') ?></h5>
		<hr style="margin-bottom:5px" />
		<?php if(get_value($module, 'ini_file') != '') {?>
		<div class="font_11" style="background-color:#f5f5f5;border:1px dashed #ccc;padding:10px"><pre style="font-family:consolas, 'courier new' !important;"><?php echo htmlspecialchars(get_value($module, 'ini_file')) ?></pre></div>
		<?php } else { ?>
		<?php echo message('warning', '', lang('Este módulo não possui um arquivo de definição vinculado.')) ?>
		<?php } ?>
		<div style="margin-top:25px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
		</div>
	</div>
</body>
</html>
