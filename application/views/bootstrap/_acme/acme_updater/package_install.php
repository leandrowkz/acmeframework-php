<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
	<style type="text/css">
		#loading_layer_custom {
			background-color:#888;
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=10)";
			opacity:.1;
			z-index:200000 !important;
			width:100% !important;
			height:100% !important;
			position:absolute;
			top:0;
			left:0;
		}
	</style>
</head>
<body>
	<div id="loading_layer_custom"></div>
	<?php echo $this->template->load_menu() ?>
	<?php echo $this->app_config->get_input_configurations(); ?>
	<div class="ui-layout-west" style="background-color:#f5f5f5">
		<div style="margin:60px 5px 20px 5px">
			<?php echo $this->template->load_logo_area(); ?>
			<?php echo $this->template->load_user_info(); ?>
		</div>
	</div>
	<div class="ui-layout-center">
		<div style="margin:65px 20px 20px 20px;">
			<div>	
				<div id="module_header">
					<div id="module_rotule" class="inline top">
						<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_updater/"><?php echo lang("Atualizações"); ?></a></h2>
						<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_updater.png" />
					</div>
					<div id="module_menus" class="inline top">
						<div class="inline top module_menu_item" title="<?php echo lang('Instalar Pacote de Atualização')?>" style="margin:-7px 0 0 -15px">
							<h4 class="inline top font_shadow_gray"> > <?php echo lang('Instalar Pacote de Atualização') ?></h4>			
						</div>
					</div>
				</div>

				<div id="module_description" style="line-height:normal;">
					<h5 id="msg_installing"><?php echo lang('Executando pacote de atualização. Por favor aguarde...')?></h5>
					<hr style="margin-bottom:10px" />
					<div style="height:70px;background-color:#e9e9e9;width:100%">
						<div style="text-align:center;float:left;width:100%;margin:14px 0 0 -50px"><h4 id="progress_value">0%</h4></div>
						<div id="percentage_install" style="border-left:3px solid green;background-color:#698B22;height:100%;">&nbsp;</div>
					</div>
					<br />
					<div id="msg_install_success" style="display:none;">
						<h4 class="inline top" style="margin-top:20px;"><?php echo lang('ACME Engine atualizado para a versão') . '<span class="font_success"> ' . get_value($package, 'package-version') . '</span>.'; ?></h4>
						<h6 style="margin-top:20px;color:#777"><?php echo lang('Pacote de atualização') . ' <span style="color:black">' . basename($file_name) . '</span> ' . lang('executado com sucesso.') ?></h6>
						<h6 style="margin-top:20px;color:#777"><?php echo lang('Você poderá revisar o conteúdo deste pacote através das ações de visualização na listagem de entrada deste módulo. Para ir para a entrada deste módulo clique no botão') . '<span style="color:black">Ir para a Entrada do Módulo</span>, ' . lang('abaixo.'); ?></h6>
					</div>
					<div id="box_errors_details" style="display:none;margin-top:30px">
						<h5 class="inline font_error"><?php echo lang('ATENÇÃO!') ?></h5> 
						<h6 class="inline"><?php echo lang('A execução do pacote de atualização encontrou')?> <span id="errors_count"></span> <?php echo lang('problemas. Ainda assim, o pacote foi marcado como instalado e você poderá visualizar os detalhes destes problemas posteriormente, na visualização dos detalhes do pacote na listagem do módulo.')?></h6>
						<h6 style="margin-top:30px">
							<a href="javascript:void(0)" onclick="show_area('errors_details')"><?php echo lang('Problemas encontrados')?></a>
							<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" />
						</h6>
						<div id="errors_details" style="display:none;"></div>
					</div>
				</div>
				
				<div style="margin-top: 40px;">
					<hr />
					<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_updater');"><?php echo lang('Ir para a Entrada do Módulo'); ?></button></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" language="javascript">
	$('body').layout({ applyDemoStyles: true, enableCursorHotkey: false  });
</script>
<?php $return = $CI->_install_package_update($file_name);  print_r($return);  ?>