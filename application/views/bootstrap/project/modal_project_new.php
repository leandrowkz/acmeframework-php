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
		<?php echo message('info', '', '<span class="font_11">' . lang('Utilize o formulário abaixo para criar um novo projeto. Em seguida, na tela dashboard de projetos defina atividades e tarefas para este projeto. Campos com (*) são obrigatórios') . '</span>') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/project/modal_project_new_process" method="post">
			<input type="hidden" name="id_user" id="id_user" value="<?php echo $this->session->userdata('id_user'); ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Projeto') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Título do Projeto')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="text" name="title" id="title" value="" class="validate[required]" style="width:300px;" />
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição do Projeto')?></div>
				<div class="form_field" style="width:400px">
					<textarea name="description" id="description" style="width:300px;height:100px"></textarea>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Valor da Hora')?>*</div>
				<div class="form_field" style="width:550px">
					<input type="text" name="hour_value" id="hour_value" value="" alt="decimal" class="validate[required]" style="width:70px;" maxlength="10" />
					<div class="font_11 comment" style="margin-top:10px;line-height:18px"><?php echo lang('O valor da hora influencia no custo de desenvolvimento total do projeto, que pode ser visualizado na área de estatísticas do projeto. Ou seja, o total de horas utilizadas nas tarefas de um projeto é multiplicado pelo valor/hora, resultando na estimativa de gasto de desenvolvimento do projeto, até o momento.')?></div>
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
