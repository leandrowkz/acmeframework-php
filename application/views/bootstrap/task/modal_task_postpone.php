<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<?php echo load_js_file('jquery.ui.1.10.3.custom/js/jquery-ui-1.10.3.custom.js');?>
	<link type="text/css" rel="stylesheet" href="<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			
			// Validação e máscaras
			enable_form_validations();
			enable_masks();
			
			// Data de início
			$("#ini_prev").datepicker({
				showOn: "button",
				buttonImage: "<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/images/calendar.png",
				buttonImageOnly: true,
				dateFormat: "dd/mm/yy"
			});
			
			// Data de fim
			$("#end_prev").datepicker({
				showOn: "button",
				buttonImage: "<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/images/calendar.png",
				buttonImageOnly: true,
				dateFormat: "dd/mm/yy"
			});
			
			// Focus no campo titulo
			$('#title').focus();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', '<span class="font_11">' . lang('Informe a nova data de início e término da tarefa selecionada. Campos com (*) são obrigatórios.') . '</span>') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/task/modal_task_edit_process" method="post">
			<input type="hidden" name="id_task" id="id_task" value="<?php echo get_value($task, 'id_task'); ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Previsão da Tarefa') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Projeto/Atividade/Tarefa')?></div>
				<div class="form_field font_blue" style="width:400px;padding-top:-1px"><h6><?php echo get_value($activity, 'project_title'); ?> > <?php echo get_value($activity, 'title'); ?> > <?php echo get_value($task, 'title'); ?></h6></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Previsão de Início')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="ini_prev" id="ini_prev" value="<?php echo to_human_date(get_value($task, 'ini_prev'))?>" alt="date" class="validate[required,custom[date]]" style="width:79px;" maxlength="10" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 26px"><?php echo lang('Data de início da tarefa.') . ' <strong>' . lang('Formato DD/MM/AAAA') . '</strong>'?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Previsão de Término')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="end_prev" id="end_prev" value="<?php echo to_human_date(get_value($task, 'end_prev'))?>" alt="date" class="validate[required,custom[date]]" style="width:79px;" maxlength="10" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 26px"><?php echo lang('Previsão de data em que tarefa termina.') . ' <strong>' . lang('Formato DD/MM/AAAA') . '</strong>'?></div>
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
