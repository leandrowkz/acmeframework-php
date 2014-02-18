<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo lang('ACME Engine - Instalação')?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link type="text/css" rel="stylesheet" href="<?php echo URL_CSS_ACME ?>/style.css" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG_ACME ?>/favicon.ico">
	<script type="text/javascript" language="javascript">
		$(document).ready(function(){
			// Validação de form
			enable_form_validations();
		});
	</script>
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
			<h6 class="inline top">&bull;&nbsp;<?php echo lang('Passo 2: Configurações da Nova Aplicação') ?></h6>
			<h6 class="inline top comment">&bull;&nbsp;<?php echo lang('Passo 3: Resumo da Instalação') ?></h6>
		</div>
		<?php echo $this->template->end_box();?>
		
		<form name="form_default" id="form_default" action="<?php echo URL_ROOT ?>/acme_installer/step_two_process" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo get_value($form_data, 'db_mysql_exists') ?>" name="db_mysql_exists" id="db_mysql_exists" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_database') ?>" name="db_database" id="db_database" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_host') ?>" name="db_host" id="db_host" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_port') ?>" name="db_port" id="db_port" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_user') ?>" name="db_user" id="db_user" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_pass') ?>" name="db_pass" id="db_pass" />
			<h3 class="font_shadow_gray"><?php echo lang('Passo 2: Configurações da Nova Aplicação')?></h3>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('Você está a um passo da nova aplicação! Preencha nesta tela as informações referentes ao novo sistema.');?></p>
			<p><h6 class="font_error"><?php echo lang('ATENÇÃO! O caracter') . ' <span class="font_error">*</span> ' . lang('representa obrigatoriedade no campo.') ?></h6></p> 
			<p><?php echo lang('Após preencher todos os campos necessários desta tela, clique em <strong>Instalar</strong> no término da página. Seu novo sistema estará instalado e pronto para uso!') ?></p>
			
			<?php if(is_array($validation)) {?>
			<br />
			<h5 class="font_error"><?php echo lang('ATENÇÃO! A instalação detectou os seguintes problemas abaixo. Analise e corrija-os para poder prosseguir.') ?></h5>
			<?php foreach($validation as $index => $msg) { ?>
			<h6 class="font_error"><span>&bull;&nbsp;</span><?php echo $msg ?></h6>
			<?php } ?>
			<?php } ?>
			
			<br />
			<h5 class="inline top font_shadow_gray"><?php echo lang('Banco de Dados')?></h5>
			<div class="font_11 top inline font_success" style="margin-top:11px;">&nbsp;&nbsp;<?php echo lang('(Já Validado)') ?></div>
			<hr style="margin-bottom:10px;" />
			<div class="font_11" style="border:1px dashed #ccc;background-color:#f5f5f5;padding:5px 20px 0px 20px;">
				<div id="label"><?php echo lang('Tipo de Banco') ?></div>
				<div id="field" class="bold" style="padding-top:4px;width:450px">MYSQL</div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Servidor/Porta')?></div>
				<div id="field" style="width:auto"><?php echo get_value($form_data, 'db_host') ?></div>
				<div id="field" style="width:100px"> : <?php echo get_value($form_data, 'db_port') ?></div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Database/Schema')?></div>
				<div id="field" style="width:450px"><?php echo get_value($form_data, 'db_database') ?><span class="comment font_11" style="margin-left:15px;"><?php echo lang('Nome do schema/banco de dados que será criado') ?></span></div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Usuário')?></div>
				<div id="field" style="width:450px"><?php echo get_value($form_data, 'db_user') ?></div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Senha')?></div>
				<div id="field" style="width:450px" class="bold">&bull;&bull;&bull;&bull;&bull;&bull;</div>
			</div>
			
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Linguagem Padrão') ?></h5>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('Esta configuração é alterável via interface e não se limita apenas ao Português (Brasil). Através dos recursos de internacionalização presentes no interior do ACME Engine é possível traduzir sua nova aplicação para um idioma customizado. Leia na documentação do ACME Engine a seção sobre internacionalização.') ?></p>
			<div id="label"><?php echo lang('DEFAULT_LANGUAGE') ?></div>
			<div id="field" style="padding-top:4px;"><h6 class="font_success inline top" style="margin-top:-3px"><?php echo DEFAULT_LANGUAGE ?></h6></div>
			
			
			<br />
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Template') ?></h5>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('O template é um diretório que abriga todos os arquivos de visualização (view), além de outros arquivos e recursos de interação com o lado cliente, como imagens, estilos e scripts. Dentro do sistema, o nome do template está disponível através da constante global <strong>TEMPLATE</strong>. Após a instalação, você poderá customizar a aparência geral do template padrão utilizado para a nova aplicação, alterando o arquivo css utilizado por ele.') ?></p>
			<div id="label"><?php echo lang('TEMPLATE') ?></div>
			<div id="field" style="padding-top:4px;"><h6 class="font_success inline top" style="margin-top:-5px"><?php echo TEMPLATE?></h6><span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Template padrão do sistema. Arquivos de visualização, imagens e estilos estarão localizados aqui.')?></span></div>
			
			
			<br />
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Paths e URLS da Aplicação (Diretórios)') ?></h5>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('Os paths e URLs abaixo representam as diretórios e suas constantes utilizadas pelo ACME Engine. Após a instalação, estas constantes estarão disponível para toda a aplicação. Você poderá consultá-las posteriormente no arquivo <strong>config/application_settings.php</strong> ou então via interface.') ?></p>
			<div id="label"><?php echo lang('URL_ROOT') ?></div>
			<div id="field" style="padding-top:4px;">
				<h6 class="font_success inline top" style="margin-top:-5px"><?php echo $URL_ROOT ?></h6>
				<br /><span class="comment font_11"><?php echo lang('URL Base do sistema. Esta URL é mapeada conforme o host atual, então este valor pode e deve mudar dependendo do ambiente atual, como por exemplo, desenvolvimento e produção.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_UPLOAD') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_ROOT/<h6 class="font_success inline top" style="margin-top:-3px">uploads</h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório de uploads do sistema. É bastante indicada para uso quando há necessidade de leitura externa deste diretório.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_TEMPLATE') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_ROOT/application/views/<h6 class="font_success inline top" style="margin-top:-3px"><?php echo TEMPLATE ?></h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório do template padrão do sistema. Utilizada na composição da URL de includes ou referência externa ao template.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_INCLUDE') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_TEMPLATE/<h6 class="font_success inline top" style="margin-top:-3px">_includes</h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório de includes do sistema. Este diretório concentra outros diretórios como o de imagens, estilos, fontes, scripts e bibliotecas de lado cliente.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_IMG') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_INCLUDE/<h6 class="font_success inline top" style="margin-top:-3px">img</h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório de imagens do template atual.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_CSS') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_INCLUDE/<h6 class="font_success inline top" style="margin-top:-3px">css</h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório de arquivos de folha de estilo (css) do template atual.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('URL_JS') ?></div>
			<div id="field" style="padding-top:4px;">
				URL_INCLUDE/<h6 class="font_success inline top" style="margin-top:-3px">js</h6>
				<br /><span class="comment font_11"><?php echo lang('URL absoluta para diretório de scripts e bibliotecas de lado cliente do template atual.')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('PATH_TEMP')?></div>
			<div id="field" style="padding-top:4px;">
				application/<h6 class="font_success inline top" style="margin-top:-3px">temp</h6>
				<br /><span class="comment font_11"><?php echo lang('Path relativo para o diretório temp do sistema. Indicado o uso da constante deste diretório para manipulação interna (via código).')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('PATH_UPLOAD')?></div>
			<div id="field" style="padding-top:4px;">
				application/<h6 class="font_success inline top" style="margin-top:-3px">uploads</h6>
				<br /><span class="comment font_11"><?php echo lang('Path relativo para o diretório uploads do sistema. Indicado o uso da constante deste diretório para manipulação interna (via código).')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('PATH_INCLUDE')?></div>
			<div id="field" style="padding-top:4px;">
				application/views/TEMPLATE/<h6 class="font_success inline top" style="margin-top:-3px">_includes</h6>
				<br /><span class="comment font_11"><?php echo lang('Path relativo para o diretório includes do sistema. Indicado o uso da constante deste diretório para manipulação interna (via código).')?></span>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('PATH_HTML_COMPONENTS')?></div>
			<div id="field" style="padding-top:4px;">
				PATH_INCLUDE/<h6 class="font_success inline top" style="margin-top:-3px">html_components</h6>
				<br /><span class="comment font_11"><?php echo lang('Path relativo para o diretório de componentes html do sistema. Indicado o uso da constante deste diretório para manipulação interna (via código).')?></span>
			</div>
			
			
			<br />
			<br />
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Configurações Para Envio de Email') ?></h5>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('Você poderá fazer envio de emails de uma maneira simplificada dentro da nova aplicação através da biblioteca <strong>App_Email</strong>. Entretanto, para utilizá-la é necessário que o conjunto de configurações abaixo esteja preenchido. Estas configurações são a respeito do servidor SMTP e informações do remetente das mensagens. Você poderá alterar estas configurações posteriormente, editando o arquivo <strong>config/application_settings.php</strong>.') ?></p>
			<div id="label"><?php echo lang('EMAIL_PROTOCOL')?></div>
			<div id="field" style="padding-top:4px;">
				<input type="hidden" value="smtp" name="email_protocol" id="email_protocol" />
				<span>SMTP</span>
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Até o momento, somente suporte de envio de emails via SMTP.')?></span>
			</div>
			<br />
			<div id="label"><?php echo lang('EMAIL_SMTP_HOST')?></div>
			<div id="field"><input type="text" value="<?php echo get_value($form_data, 'email_smtp_host') ?>" name="email_smtp_host" id="email_smtp_host" style="width:200px;" /></div>
			<br />
			<div id="label"><?php echo lang('EMAIL_SMTP_PORT')?></div>
			<div id="field"><input type="text" value="<?php echo get_value($form_data, 'email_smtp_port') ?>" name="email_smtp_port" id="email_smtp_port" style="width:100px;" /></div>
			<br />
			<div id="label"><?php echo lang('EMAIL_SMTP_USER')?></div>
			<div id="field"><input type="text" value="<?php echo get_value($form_data, 'email_smtp_user') ?>" name="email_smtp_user" id="email_smtp_user" style="width:200px;" /></div>
			<br />
			<div id="label"><?php echo lang('EMAIL_SMTP_PASS')?></div>
			<div id="field"><input type="password" value="<?php echo get_value($form_data, 'email_smtp_pass') ?>" name="email_smtp_pass" id="email_smtp_pass" style="width:200px;" /></div>
			<br />
			<div id="label"><?php echo lang('EMAIL_SMTP_TIMEOUT')?></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'email_smtp_timeout') ?>" name="email_smtp_timeout" id="email_smtp_timeout" style="width:100px;" />
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Valor em segundos.')?></span>
			</div>
			<br />
			<div id="label" class="break_word"><?php echo lang('EMAIL_GLOBAL_NAME_FROM')?></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'email_global_name_from') ?>" name="email_global_name_from" id="email_global_name_from" style="width:200px;" />
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Nome que aparecerá como remetente das mensagens de email enviadas.')?></span>
			</div>
			<br />
			<div id="label" class="break_word"><?php echo lang('EMAIL_GLOBAL_ADDRESS_FROM')?></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'email_global_address_from') ?>" name="email_global_address_from" id="email_global_address_from" style="width:200px;" />
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Endereço de email que aparecerá como remetente das mensagens enviadas.')?></span>
			</div>
		
			
			<br />
			<br />
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Informações da Nova Aplicação') ?></h5>
			<hr style="margin-bottom:10px" />
			<div id="label"><?php echo lang('Nome da Aplicação')?><span class="font_error">*</span></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'info_app_name') ?>" name="info_app_name" id="info_app_name" style="width:200px;" class="validate[required,custom[onlyLetterNumberChrSpecials]]" />
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;<?php echo lang('Deve conter apenas letras, números e caracter \'_\'; ')?>Ex.: TASKOPEN</span>
			</div>
			<br />
			<div id="label"><?php echo lang('Título de Páginas') ?><span class="font_error">*</span></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'info_app_title') ?>" name="info_app_title" id="info_app_title" style="width:200px;" class="validate[required]" />
				<span class="comment font_11">&nbsp;&nbsp;&nbsp;Ex.: Taskopen - <?php echo lang('Gerenciador de tarefas para pequenos projetos') ?></span>
			</div>
			<br />
			<div id="label"><?php echo lang('Logotipo da Aplicação') ?><span class="font_error">*</span></div>
			<div id="field">
				<?php echo input_file('info_app_logo', 'info_app_logo', 'validate[required]')?>
				<br /><div class="inline top font_error bold font_11" style="margin:5px 0 0 0px;"><?php echo lang('Imagens até 2MB, nos formatos de imagens (PNG, JPG, JPEG, GIF, BMP). Para o template padrão do novo sistema recomenda-se o uso de logotipos nas dimensões máximas: 170 x 170 (largura x altura)') ?></div>
			</div>
			<br />
			<br />
			<div id="label"><?php echo lang('Favicon da Aplicação') ?></div>
			<div id="field">
				<?php echo input_file('info_app_favicon', 'info_app_favicon')?>
				<br /><div class="inline top font_error bold font_11" style="margin:5px 0 0 0px;"><?php echo lang('Imagen até 200KB, no formato ICO. Dimensões máximas: 16 x 16 (largura x altura)') ?></div>
			</div>
			
			
			<br />
			<br />
			<br />
			<br />
			<h5 class="font_shadow_gray"><?php echo lang('Informações do Usuário-mestre')?></h5>
			<hr style="margin-bottom:10px" />
			<p><?php echo lang('Este usuário é utilizado para o acesso principal a nova aplicação. A partir dele será possível criar outros usuários.') ?></p>
			<div id="label"><?php echo lang('Grupo')?></div>
			<div id="field" class="bold" style="padding-top:4px;">ROOT</div>
			<br />
			<div id="label"><?php echo lang('Nome do Usuário')?><span class="font_error">*</span></div>
			<div id="field">
				<input type="text" value="<?php echo get_value($form_data, 'usr_name') ?>" name="usr_name" id="usr_name" style="width:200px;" class="validate[required]" />
				<span class="font_11 comment">&nbsp;&nbsp;&nbsp;<?php echo lang('Ex.: Fulano da Silva (Super Usuário)') ?></span>
			</div>
			<br />
			<div id="label"><?php echo lang('Email do Usuário')?><span class="font_error">*</span></div>
			<div id="field"><input type="text" value="<?php echo get_value($form_data, 'usr_email') ?>" name="usr_email" id="usr_email" style="width:200px;" class="validate[required,custom[email]]" /></div>
			<br />
			<div id="label"><?php echo lang('Login')?><span class="font_error">*</span></div>
			<div id="field"><input type="text" value="<?php echo get_value($form_data, 'usr_login') ?>" name="usr_login" id="usr_login" style="width:120px;" class="validate[required]" /></div>
			<br />
			<div id="label"><?php echo lang('Senha') ?><span class="font_error">*</span></div>
			<div id="field">
				<input type="password" name="usr_pass" id="usr_pass" style="width:120px;" class="validate[required,minSize[6]]" />
				<span class="font_11 comment">&nbsp;&nbsp;&nbsp;<?php echo lang('Mínimo 6 caracteres') ?></span>
			</div>
			<br />
			<div id="label"><?php echo lang('Confirme a Senha')?><span class="font_error">*</span></div>
			<div id="field">
				<input type="password" name="usr_pass_confirm" id="usr_pass_confirm" style="width:120px;" class="validate[required,equals[usr_pass],minSize[6]]" />
				<span class="font_11 comment">&nbsp;&nbsp;&nbsp;<?php echo lang('Mínimo 6 caracteres') ?></span>
			</div>
			
			
			<div style="margin-top:30px">
				<hr style="margin-bottom:5px;" />
				<input type="submit" value="<?php echo lang('Continuar >') ?>" />
				<div class="inline top" style="margin:8px 0 0 5px">ou <a href="javascript:void(0)" onclick="if(window.confirm('Deseja realmente voltar? Os dados preenchidos neste formulário serão perdidos.')){ redirect('<?php echo URL_ROOT ?>/acme_installer') } else { return false; }"><?php echo lang('Voltar') ?></a></div>
			</div>
		</form>
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