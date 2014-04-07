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
		// Confirma a existência de um servidor mysql instalado
		function confirm_mysql_exists() 
		{
			if($('#check_mysql_exists').is(':checked'))
			{
				$('#db_mysql_exists').val('Y');
				$('#form_db_requirements').submit();
			} else {
				alert("<?php echo lang('ATENÇÃO!')?>\n\n<?php echo lang('Você deve selecionar o checkbox de confirmação.')?>");
				return;
			}
		}
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
		
		<?php echo $this->template->start_box(lang('Andamento da Instalação'), URL_IMG . '/icon_help.png', 'width:315px;float:right;margin:13px 0 20px 40px;clear:both');?>
		<div style="line-height:25px;">
			<h6 class="inline top">&bull;&nbsp;<?php echo lang('Passo 1: Verificação de Requisitos') ?></h6>
			<h6 class="inline top comment">&bull;&nbsp;<?php echo lang('Passo 2: Configurações da Nova Aplicação') ?></h6>
			<h6 class="inline top comment">&bull;&nbsp;<?php echo lang('Passo 3: Resumo da Instalação') ?></h6>
		</div>
		<?php echo $this->template->end_box();?>
		
		<h3 class="font_shadow_gray"><?php echo lang('Bem-vindo a instalação do ACME Engine!')?></h3>
		<hr style="margin-bottom:10px" />
		<p><?php echo lang('Obrigado por utilizar este criador de sistemas. O objetivo do ACME Engine é oferecer um subsistema básico com um conjunto de componentes comuns que vão de usuários à menus de uma aplicação. A partir destes componentes básicos uma nova aplicação poderá ser construída em um tempo muito menor.') ?></p>
		<p><?php echo lang('Se você quer saber mais sobre a proposta, acesse a') . ' <a href="http://www.acmeengine.org/documentation" target="_blank">' . lang('documentação do projeto' ) . '</a>' ?><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" style="margin:11px 0 0 3px" />.</p>
		<p><?php echo lang('Verifique nesta página a validação dos requisitos necessários para instalação do mecanismo ACME. Caso os requisitos estejam em conformidade, prossiga na instalação, preenchendo as configurações que a nova aplicação possuirá, como configurações de banco de dados, logotipo e diretórios.') ?></p>
		
		<br />
		<h5 class="font_shadow_gray"><?php echo lang('Requisitos do Sistema')?></h5>
		<hr style="margin-bottom:10px;" />
		<div style="line-height:25px;">
			<?php $form_connection = false; ?>
			<p><?php echo lang('O conjunto de requisitos abaixo é necessário para que a instalação do sistema ACME Engine ocorra com sucesso. Verifique a situação de cada item e em caso de problemas, qual a mensagem de erro.') ?></p>
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/<?php echo (isset($system_requirements['php_version'])) ? 'icon_error.png' : 'icon_success.png'; ?>" />
			<h6 class="inline top <?php echo (isset($system_requirements['php_version'])) ? 'font_error' : 'font_success'; ?>"><?php echo lang('PHP 5.3.5 ou superior') ?></h6>
			
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/<?php echo (isset($system_requirements['mysql_version'])) ? 'icon_error.png' : 'icon_success.png'; ?>" />
			<h6 class="inline top <?php echo (isset($system_requirements['mysql_version'])) ? 'font_error' : 'font_success'; ?>"><?php echo lang('MySQL 5.0 ou superior') ?></h6>
			<?php if(isset($system_requirements['mysql_version'])) {?>
			<div style="min-height:30px;background-color:#f5f5f5;border:2px dashed #bbb;border-radius:3px 3px 3px 3px;padding:10px;margin-top:10px">
				<img src="<?php echo URL_IMG ?>/icon_arrow_balloon_up.png" style="float:left;margin:-21px 0 0 60px;" />
				<h6><?php echo lang('O instalador do ACME Engine não conseguiu detectar a presença de um servidor MySQL 5.0 ou superior. Isso pode ocorrer caso você esteja utilizando um pacote de instalação fechado que contenha o servidor em seu interior, como por exemplo XAMPP ou EasyPHP. É possível que a variável de ambiente que define o diretório do MySQL não esteja definida também.')?></h6>
				<h6 class="font_error"><?php echo lang('Não se preocupe, isso não é um problema. Se você garante que possui um servidor MySQL 5.0 ou superior instalado, basta confirmar abaixo.')?></h6>
				<div style="margin-top:10px">
					<div class="inline top" style="margin:8px 3px 0 0;"><input type="checkbox" name="check_mysql_exists" id="check_mysql_exists" /></div>
					<div class="inline top font_11" style="margin:2px 5px 0 0;"><label for="check_mysql_exists"><?php echo lang('Sim, existe um servidor MySQL 5.0 ou superior instalado.')?></label></div>
					<button class="mini" type="button" onclick="confirm_mysql_exists();"><?php echo lang('Confirmar') ?></button>
				</div>
			</div>
			<?php } ?>
			
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/<?php echo (isset($system_requirements['php_mysql_extension'])) ? 'icon_error.png' : 'icon_success.png'; ?>" />
			<h6 class="inline top <?php echo (isset($system_requirements['php_mysql_extension'])) ? 'font_error' : 'font_success'; ?>"><?php echo lang('Extensão <u>mysql</u> ativada no PHP') ?></h6>
			
			<?php if(isset($system_requirements['mysql_connection'])) {?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_error.png" />
			<h6 class="inline top font_error"><?php echo lang('Acesso ao banco de dados: ') . $system_requirements['mysql_connection']; ?></h6>
			<?php } ?>
			
			<?php if(isset($system_requirements['mysql_user_permission_select'])) {?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_error.png" />
			<h6 class="inline top font_error"><?php echo lang('Acesso ao banco de dados: usuário sem permissão para realização de consultas - SELECT'); ?></h6>
			<?php } ?>
			
			<?php if(isset($system_requirements['mysql_user_permission_insert'])) {?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_error.png" />
			<h6 class="inline top font_error"><?php echo lang('Acesso ao banco de dados: usuário sem permissão para realização de inserções - INSERT'); ?></h6>
			<?php } ?>
			
			<?php if(isset($system_requirements['mysql_user_permission_create'])) {?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_error.png" />
			<h6 class="inline top font_error"><?php echo lang('Acesso ao banco de dados: usuário sem permissão para criação de tabelas e schemas - CREATE'); ?></h6>
			<?php } ?>
			
			<?php if(isset($system_requirements['mysql_connection_information'])) { ?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_help.png" />
			<h6 class="inline top"><?php echo lang('Acesso ao banco de dados: dados não informados') ?></h6>
			<div class="font_error font_11 top inline" style="margin-top:3px;"><?php echo lang('(Você deve preencher as configurações abaixo para continuar)') ?></div>
			<?php } ?>
			
			<?php if(isset($system_requirements['mysql_database_exists'])) { ?>
			<?php $form_connection = true; ?>
			<br />
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_error.png" />
			<h6 class="inline top font_error"><?php echo lang('Acesso ao banco de dados: schema') . ' <u>' . get_value($form_data, 'db_database') . '</u> ' . lang('já existe'); ?></h6>
			<?php } ?>
			
			<?php if($form_connection) { ?>
			<div class="font_11" style="border:1px dashed #ccc;background-color:#f5f5f5;padding:5px 20px 15px 20px;">
			<form name="form_db_requirements" id="form_db_requirements" action="<?php echo URL_ROOT ?>/acme_installer" method="post">
				<input type="hidden" id="db_mysql_exists" name="db_mysql_exists" value="<?php echo get_value($form_data, 'db_mysql_exists')?>" />
				<div id="label"><?php echo lang('Tipo de Banco') ?></div>
				<div id="field" class="bold" style="padding-top:4px;width:450px">MYSQL</div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Servidor/Porta')?></div>
				<div id="field" style="width:100px"><input type="text" value="<?php echo (get_value($form_data, 'db_host') == '') ? 'localhost' : get_value($form_data, 'db_host'); ?>" name="db_host" id="db_host" style="width:130px;" /></div>
				<div id="field" style="width:100px;margin-left:40px"><input type="text" value="<?php echo (get_value($form_data, 'db_port') == '') ? '3306' : get_value($form_data, 'db_port'); ?>" name="db_port" id="db_port" style="width:60px;margin-left:15px" /></div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Database/Schema')?></div>
				<div id="field" style="width:450px">
					<input type="text" value="<?php echo get_value($form_data, 'db_database') ?>" name="db_database" id="db_database" style="width:130px;" />
					<span class="comment font_11" style="margin-left:15px;"><?php echo lang('Nome do schema/banco de dados que será criado') ?></span>
				</div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Usuário')?></div>
				<div id="field" style="width:450px"><input type="text" value="<?php echo get_value($form_data, 'db_user') ?>" name="db_user" id="db_user" style="width:130px;" /></div>
				<br />
				<div id="label" style="padding-top:0px;"><?php echo lang('Senha')?></div>
				<div id="field" style="width:450px"><input type="password" value="<?php echo get_value($form_data, 'db_pass') ?>" name="db_pass" id="db_pass" style="width:130px;" /></div>
				
				<div style="margin-top:0px">
					<hr style="margin-bottom:5px;" />
					<input type="submit" class="mini" value="<?php echo lang('Testar Conexão')?>" />
				</div>
			</form>
			</div>
			<?php } else { ?>
			<br />
			<form name="form_db_requirements" id="form_db_requirements" action="<?php echo URL_ROOT ?>/acme_installer" method="post">
				<input type="hidden" id="db_mysql_exists" name="db_mysql_exists" value="<?php echo get_value($form_data, 'db_mysql_exists')?>" />
				<input type="hidden" value="<?php echo get_value($form_data, 'db_database') ?>" name="db_database" id="db_database" />
				<input type="hidden" value="<?php echo get_value($form_data, 'db_host') ?>" name="db_host" id="db_host" />
				<input type="hidden" value="<?php echo get_value($form_data, 'db_port') ?>" name="db_port" id="db_port" />
				<input type="hidden" value="<?php echo get_value($form_data, 'db_user') ?>" name="db_user" id="db_user" />
				<input type="hidden" value="<?php echo get_value($form_data, 'db_pass') ?>" name="db_pass" id="db_pass" />
			</form>
			<img style="margin-top:7px" src="<?php echo URL_IMG ?>/icon_success.png" />
			<h6 class="inline top font_success"><?php echo lang('Acesso ao banco de dados (OK)') ?></h6>
			<div class="font_11 top inline" style="margin-top:3px;">&nbsp;&nbsp;<a href="<?php echo URL_ROOT ?>"><?php echo lang('Limpar configurações') ?></a></div>
			<div class="font_11" style="border:1px dashed #5d9d49;background-color:#b6dbaa;padding:5px 20px 0px 20px;">
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
			<?php } ?>
		</div>
		
		<?php if($system_requirements === true) {?>
		<form action="<?php echo URL_ROOT ?>/acme_installer/step_two" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo get_value($form_data, 'db_mysql_exists')?>" id="db_mysql_exists" name="db_mysql_exists" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_database') ?>" name="db_database" id="db_database" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_host') ?>" name="db_host" id="db_host" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_port') ?>" name="db_port" id="db_port" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_user') ?>" name="db_user" id="db_user" />
			<input type="hidden" value="<?php echo get_value($form_data, 'db_pass') ?>" name="db_pass" id="db_pass" />
			<div style="margin-top:30px">
				<hr style="margin-bottom:5px;" />
				<input type="submit" value="<?php echo lang('Continuar >') ?>" />
			</div>
		</form>
		<?php } else { ?>
		<div style="margin-top:30px">
			<hr style="margin-bottom:5px;" />
			<button disabled="disabled"><?php echo lang('Continuar >') ?></button>
			<div class="inline top comment font_11" style="margin:10px 0 0 5px"><?php echo lang('(Você deve preencher as configurações de banco de dados para continuar)') ?></div>
		</div>
		<?php } ?>
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