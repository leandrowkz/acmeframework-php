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
		
		<?php echo $this->template->start_box(lang('Andamento da Instalação'), URL_IMG . '/icon_help.png', 'width:315px;float:right;margin:13px 0 20px 40px');?>
		<div style="line-height:25px;">
			<h6 class="inline top comment">&bull;&nbsp;<?php echo lang('Passo 1: Verificação de Requisitos') ?></h6>
			<h6 class="inline top comment">&bull;&nbsp;<?php echo lang('Passo 2: Configurações da Nova Aplicação') ?></h6>
			<h6 class="inline top">&bull;&nbsp;<?php echo lang('Passo 3: Resumo da Instalação') ?></h6>
		</div>
		<?php echo $this->template->end_box();?>
		
		<h3 class="font_shadow_gray"><?php echo lang('Passo 3: Resumo da Instalação')?></h3>
		<hr style="margin-bottom:10px" />
		<?php echo message('success', lang('ACME Engine instalado com sucesso!'), lang('A instalação do ACME Engine foi concluída com sucesso. A partir de agora o sistema ACME estará disponível na forma de uma nova aplicação básica com as configurações informadas. Para maiores informações, visite a página do projeto.'), false, 'width:560px')?>
		
		<br />
		<br />
		<div class="inline top" style="margin-top:5px">&bull;&nbsp;</div>
		<h6 class="inline top"><?php echo lang('Sua nova aplicação se chama: ') . APP_NAME; ?></h6>
		<br />
		<div class="inline top" style="margin-top:5px">&bull;&nbsp;</div>
		<h6 class="inline top"><a href="<?php echo URL_ROOT ?>" target="_blank"><?php echo lang('Acessar a página de login da nova aplicação') ?></a></h6>
		<div class="inline top" style="margin:8px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
		
		<br />
		<br />
		<br />
		<div><?php echo lang('Começe já a customizar sua aplicação. Para isso:') ?></div>
		<div class="inline top" style="margin-top:5px">&bull;&nbsp;</div>
		<h6 class="inline top"><a href="http://www.acmeengine.org/documentation/tutorials/customizing-css-file-from-actual-template" target="_blank"><?php echo lang('Customize o arquivo css do template atual') ?></a></h6>
		<div class="inline top" style="margin:8px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
		<br />
		<div class="inline top" style="margin-top:5px">&bull;&nbsp;</div>
		<h6 class="inline top"><a href="http://www.acmeengine.org/documentation" target="_blank"><?php echo lang('Leia a documentação do ACME Engine e saiba como enriquecer sua aplicação') ?></a></h6>
		<div class="inline top" style="margin:8px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
		<br />
		<div class="inline top" style="margin-top:5px">&bull;&nbsp;</div>
		<h6 class="inline top"><a href="http://www.acmeengine.org/documentation/tutorials/changing-login-page" target="_blank"><?php echo lang('Altere o formato da tela de login') ?></a></h6>
		<div class="inline top" style="margin:8px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
		
		<br />
		<br />
		<br />
		<h5 class="font_error"><?php echo lang('ATENÇÃO! O acesso a esta página estará disponível apenas pelas próximas horas.')?></h5>
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