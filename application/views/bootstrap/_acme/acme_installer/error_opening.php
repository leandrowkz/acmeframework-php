<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo lang('ACME Engine - Instalação')?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link type="text/css" rel="stylesheet" href="<?php echo URL_CSS_ACME ?>/style.css" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG_ACME ?>/favicon.ico">
</head>
<body>
<table style="height:100%;width:100%;">
<tr>
<td id="site-body-background">
<div id="site-body">
	<div id="site-shadow-left"></div>
	<div id="site-shadow-right"></div>
	<div id="site-body-content">
		<div id="site-header">
			<img src="<?php echo URL_IMG_ACME ?>/logo_acme_black.png" style="width:200px;margin-left:5px;" class="inline top" />
			<div id="site-menu" class="inline top font_shadow_gray">
				<div class="inline top right" style="float:right;margin:10px 0 0 30px">
					<h5 class="inline top"><a href="http://www.acmeengine.org/support" target="_blank" style="text-decoration:none"><?php echo lang('Suporte') ?></a></h5>
					<div class="inline top" style="margin:11px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				</div>
				<div class="inline top right" style="float:right;margin:10px 0 0 30px">
					<h5 class="inline top"><a href="http://www.acmeengine.org/documentation" target="_blank" style="text-decoration:none"><?php echo lang('Documentação') ?></a></h5>
					<div class="inline top" style="margin:11px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				</div>
				<div class="inline top right" style="float:right;margin:10px 0 0 00px">
					<h5 class="inline top no_decoration"><a href="http://www.acmeengine.org" target="_blank" style="text-decoration:none"><?php echo lang('Página do Projeto') ?></a></h5>
					<div class="inline top" style="margin:11px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				</div>
			</div>
		</div>
		<hr style="margin-bottom:30px;" />
		
		<?php echo message('warning', lang('ATENÇÃO!'), $msg)?>
	</div>
	<br />
</div>
</td>
</tr>
<tr>
<td id="site-footer-background">
	<div id="site-footer" class="font_11 center" style="height:40px;">
		<div><?php echo lang('ACME Engine') . ' ' . date('Y'); ?></div>
		<div><?php echo lang('De desenvolvedores para desenvolvedores :)') ?></div>
	</div>
</td>
</tr>
</table>
</body>
</html>
<?php die; ?>