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
		<?php echo message('info', '', '<span class="font_11">' . lang('Utilize o formulário abaixo para editar a tarefa selecionada. Campos com (*) são obrigatórios.') . '</span>') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/task/modal_task_edit_process" method="post">
			<input type="hidden" name="id_task" id="id_task" value="<?php echo get_value($task, 'id_task'); ?>" />
			<input type="hidden" name="id_user" id="id_user" value="<?php echo $this->session->userdata('id_user'); ?>" />
			<br />
			<div class="font_11" style="float:right;width:150px;margin:6px 0px 0 0" onclick="show_area('msg-saiba-mais')">
				<img src="<?php echo URL_IMG ?>/icon_help.png" style="float:left;width:13px;margin:1px 4px 0 0" />
				<a href="javascript:void(0)"><?php echo lang('Saiba mais sobre tarefas')?></a>
			</div>
			<h6 class="font_shadow_gray"><?php echo lang('Dados da Tarefa') ?></h6>
			<hr />
			<div id="msg-saiba-mais" class="font_11" style="position:absolute;margin:-4px 0 0 0;padding:10px 15px 10px 10px;background-color:#000;color:#fff;line-height:18px;display:none">
				<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-up.png" style="float:right;margin:-18px 50px 0 0" />
				<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:10px;cursor:pointer;float:right;margin:0px 0px 0 0" onclick="show_area('msg-saiba-mais')" />
				<div><?php echo lang('Uma tarefa é um trabalho a ser executado. Além disso uma tarefa possui um responsável e um executor, isto é, alguém que responde pela tarefa e outro que a executa (ambos podem ser a mesma pessoa).<br /><br />Tarefas possuem uma data de previsão de início e uma estimativa de tempo de execução, a soma das estimativas de todas as tarefas compõem a estimativa geral do projeto.<br /><br />Os envolvidos podem inserir registros de andamento ou histórico na tarefa. Estes registros de andamento possuem marcação de tempo e é neste ponto que se obtém o tempo total de execução da tarefa.')?></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Projeto/Atividade')?></div>
				<div class="form_field font_blue" style="width:400px;padding-top:-1px"><h6><?php echo get_value($activity, 'project_title'); ?> > <?php echo get_value($activity, 'title'); ?></h6></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Título da Tarefa')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="text" name="title" id="title" value="<?php echo get_value($task, 'title')?>" class="validate[required]" style="width:350px;" />
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição')?></div>
				<div class="form_field" style="width:400px">
					<textarea name="description" id="description" style="width:350px;height:120px"><?php echo get_value($task, 'description')?></textarea>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Usuário Responsável')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="id_user_responsible" id="id_user_responsible" style="width:300px;" class="validate[required]"><?php echo $options_user_responsible; ?></select>
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Usuário que será responsável pela tarefa')?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Usuário Executor')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="id_user_executor" id="id_user_executor" style="width:300px;" class="validate[required]"><?php echo $options_user_executor; ?></select>
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Usuário que irá executar a tarefa')?></div>
				</div>
			</div>
			
			<br />
			<br />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Definições e Estimativas da Tarefa') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Situação da Tarefa')?></div>
				<div class="form_field font_blue" style="width:400px;padding-top:-1px"><h6><?php echo lang(get_value($task, 'situation'))?></h6></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Prioridade')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="priority" id="priority" style="width:91px;" class="validate[required]">
						<option value="baixa"  <?php echo (strtolower(get_value($task, 'priority')) == 'baixa')  ? 'selected="selected"' : ''; ?>><?php echo lang('Baixa')?></option>
						<option value="normal" <?php echo (strtolower(get_value($task, 'priority')) == 'normal') ? 'selected="selected"' : ''; ?>><?php echo lang('Normal')?></option>
						<option value="alta"   <?php echo (strtolower(get_value($task, 'priority')) == 'alta')   ? 'selected="selected"' : ''; ?>><?php echo lang('Alta')?></option>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Estimativa')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="estimate" id="estimate" value="<?php echo get_value($task, 'estimate')?>" alt="time" class="validate[required]" style="width:79px;" maxlength="5" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Estimativa em horas da tarefa.') . ' <strong>' . lang('Formato HH:MM') . '</strong>'?></div>
				</div>
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
