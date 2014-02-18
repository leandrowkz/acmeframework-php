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
		<?php echo message('info', '', lang('Utilize o formulário abaixo para alterar o favorito que está sendo visualizado. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/ajax_modal_bookmark_update_process" method="post">
			<input type="hidden" name="id_user_bookmark" id="id_user_bookmark" value="<?php echo get_value($bookmark, 'id_user_bookmark') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Favorito') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo do Favorito')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="text" name="name" id="name" value="<?php echo get_value($bookmark, 'name')?>" class="validate[required]" style="width:200px;" />
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('O rótulo aparecerá como nome do link') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Link')?>*</div>
				<div class="form_field" style="width:auto;">
					<input type="text" name="link" id="link" value="<?php echo htmlentities(get_value($bookmark, 'link'))?>" style="width:200px;" class="validate[required]" />
				</div>
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
