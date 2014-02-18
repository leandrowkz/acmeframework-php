<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			enable_form_validations();
			enable_masks();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para editar os dados básicos do seu usuário. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/ajax_modal_data_edit_process" method="post">
			<input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Usuário') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Nome')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="text" name="name" id="name" value="<?php echo $name;?>" maxlength="250" class="validate[required]" style="width:250px;" />
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Email')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="text" name="email" id="email" value="<?php echo $email?>" maxlength="250" class="validate[required]" style="width:250px;" />				
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Grupo')?></div>
				<div class="form_field" style="width:auto;padding-top:5px"><?php echo $group ?></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Idioma Padrão')?></div>
				<div class="form_field" style="width:auto;padding-top:5px">
				<?php 
					switch($lang_default)
					{
						case 'pt_BR':
							echo lang('Português (Brasil)');
						break;
						
						case 'en_US':
							echo lang('Inglês (Estados Unidos)');
						break;
						
						default:
							echo lang('Português (Brasil)');
						break;
					} 
				?>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Pagina Inicial')?></div>
				<div class="font_11 form_field" style="width:auto;padding-top:6px"><?php echo eval_replace($url_default);?></div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
