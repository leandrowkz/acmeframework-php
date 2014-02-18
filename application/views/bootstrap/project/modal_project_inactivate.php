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
		<?php echo message('warning', '', '<span class="font_11">' . lang('Utilize as opções abaixo para ativar ou desativar o projeto selecionado.') . '</span>', false, 'margin-bottom:10px;') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/project/modal_project_edit_process" method="post">
			<input type="hidden" name="id_project" id="id_project" value="<?php echo get_value($project, 'id_project'); ?>" />
			<br />
			<div id="box_group_view">
				<div>
					<div id="label_view"><?php echo lang('Título do Projeto') ?></div>
					<div id="field_view" class="font_blue"><h6 style="margin-top:0px;"><?php echo get_value($project, 'title'); ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Descrição') ?></div>
					<div id="field_view"><?php echo character_limiter(get_value($project, 'description'), 100) ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Valor da Hora') ?></div>
					<div id="field_view"><?php echo get_value($project, 'hour_value') ?></div>
				</div>
			</div>
			
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Situação do Projeto')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="radio" name="dtt_inative" id="dtt_inative" value="" style="margin:7px 5px 0 0" <?php echo (get_value($project, 'dtt_inative') == '') ? 'checked="checked"' : ''?> /><h6 class="font_success inline top"><?php echo lang('Ativo') ?></h6>
					<br />
					<input type="radio" name="dtt_inative" id="dtt_inative" value="CURRENT_TIMESTAMP" style="margin:7px 5px 0 0" <?php echo (get_value($project, 'dtt_inative') != '') ? 'checked="checked"' : ''?> /><h6 class="font_error inline top"><?php echo lang('Inativo') ?></h6>
				</div>
			</div>
			
			<div style="margin-top:30px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Enviar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
