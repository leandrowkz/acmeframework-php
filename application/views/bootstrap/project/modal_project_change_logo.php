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
		<span class="font_11"><?php echo message('info', '', lang('Utilize o campo abaixo para enviar uma nova imagem de logotipo para o projeto selecionado. Envie somente um arquivo de imagem nos formatos JPG, PNG, ou GIF. O limite de tamanho máximo de arquivo é de 4MB.<br /><br />Tamanho máximo: 400 X 400.')) ?></span>
		<?php if($upload_errors != ''){ ?>
		<div class="font_11" style="margin-top:20px"><?php echo message('warning', lang('ATENÇÃO!'), lang('Não foi possível enviar a imagem selecionada. Visualize as mensagens de erro abaixo, corrija-os e tente novamente.<br /><br />') . $upload_errors); ?></div>
		<?php } ?>
		<form style="margin-top: 30px" name="photo" enctype="multipart/form-data" action="<?php echo URL_ROOT; ?>/project/modal_project_change_logo_process" method="post">
			<input type="hidden" id="id_project" name="id_project" value="<?php echo get_value($project, 'id_project'); ?>"/> 
			<h6><?php echo lang('Imagem de logotipo:')?></h6>
			<div class="inline top"><?php echo input_file('image', 'image', 'validate[required]')?></div>
			<div style="margin-top: 40px;">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" name="upload" value="<?php echo lang('Enviar Imagem'); ?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar')?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
