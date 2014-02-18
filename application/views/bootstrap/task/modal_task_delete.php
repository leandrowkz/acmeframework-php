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
		<?php echo message('warning', lang('ATENÇÃO!'), '<span class="font_11">' . lang('A tarefa que está sendo visualizada será deletada. Para confirmar esta ação clique em ok, para desistir clique em cancelar.') . '</span>', false, 'margin-bottom:10px;') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/task/modal_task_delete_process" method="post">
			<input type="hidden" name="id_task" id="id_task" value="<?php echo get_value($task, 'id_task'); ?>" />
			<br />
			<div id="box_group_view">
				<img src="<?php echo URL_IMG ?>/icon_bullet_priority_<?php echo get_value($task, 'priority')?>.png" style="float:right;margin:7px 7px 0 0" title="<?php echo lang('Prioridade') . ': ' . get_value($task, 'priority'); ?>" />
				<div>
					<div id="label_view"><?php echo lang('Projeto/Atividade') ?></div>
					<div id="field_view" class="font_blue"><h6 style="margin-top:0px;"><?php echo get_value($activity, 'project_title'); ?> > <?php echo get_value($activity, 'title'); ?></h6></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Título da tarefa') ?></div>
					<div id="field_view"><?php echo lang(get_value($task, 'title')) ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Descrição') ?></div>
					<div id="field_view"><?php echo character_limiter(get_value($task, 'description'), 100) ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Usuário responsável') ?></div>
					<div id="field_view"><?php echo get_value($task, 'login_responsible') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Usuário executor') ?></div>
					<div id="field_view"><?php echo get_value($task, 'login_executor') ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Criada em') ?></div>
					<div id="field_view"><?php echo to_human_date(get_value($task, 'log_dtt_ins')) ?></div>
				</div>
			</div>
			
			<div style="margin:30px 0 0 1px">
				<div class="inline top font_11 bold" style="width:15px !important"><input type="checkbox" name="confirm" id="confirm" class="validate[required]" /></div>
				<div class="inline top font_11" style="width:400px"><label for="confirm"><?php echo lang('OK, quero deletar esta tarefa e todo seu histórico vinculado.')?></label></div>
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
