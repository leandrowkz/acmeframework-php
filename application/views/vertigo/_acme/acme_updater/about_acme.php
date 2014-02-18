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
		<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/logo_acme_black.png" style="width:200px" />
		<div class="inline top" style="width:290px;border-left:1px solid #ccc;margin-left:25px;padding-left:15px">
			<h3 class="inline top font_shadow_gray" style="margin-top:-9px">ACME Engine</h3>
			<!--div class="inline top comment" style="margin-top:7px"> | <?php echo date('Y'); ?></div-->
			<h6 class="comment"><?php echo lang('Versão') . ' ' . ACME_VERSION ;?> </h6>
			<div class="font_11" style="margin:20px 0 10px 0"><?php echo lang('ACME Engine, um framework para construção de aplicações web escritas em PHP.')?></div>
			<div class="font_11" style="margin:20px 0 10px 0">
				<h6><?php echo lang('Idealização e Construção:') ?></h6>
				<div class="inline top" style="line-height:18px;margin-top:0px;width:130px">Leandro Mangini Antunes</div>
				<div class="inline top bold" style="line-height:18px;margin:0px 0 0 0px">
					<a href="http://www.facebook.com/leanndro.antunes" target="_blank">Facebook</a>
					<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/icon_bullet_external_link.gif" />
					<br />
					<a href="http://www.twitter.com/leanndro" target="_blank">Twitter</a>
					<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/icon_bullet_external_link.gif" />
					<br />
					<a href="http://www.linkedin.com/pub/leandro-mangini-antunes/61/b05/847" target="_blank">Linkedin</a>
					<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/icon_bullet_external_link.gif" />
					<br />
					<a href="http://www.facebook.com/leanndro.antunes" target="_blank">Code Complex</a>
					<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/icon_bullet_external_link.gif" />
				</div>
			</div>
			<div class="font_11 bold" style="margin:20px 0 10px 0">
				<h6><?php echo lang('Licença de Utilização:') ?></h6>
				<div style="margin-top:5px;line-height:18px">
					<div style="float:left;margin:3px 10px 0 0"><a rel="license" href="http://creativecommons.org/licenses/by/3.0/deed.pt_BR" target="_blank"><img alt="Licença Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/88x31.png" /></a></div>
					<div><a href="http://creativecommons.org/licenses/by/3.0/legalcode" target="_blank"><?php echo lang('Creative Commons Atribuição 3.0 Não Adaptada') ?></a></div>
				</div>
			</div>
		</div>
		<div style="margin-top:20px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('Fechar')?></button></div>
		</div>
	</div>
</body>
</html>