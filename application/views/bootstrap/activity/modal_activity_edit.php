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
		<?php echo message('info', '', '<span class="font_11">' . lang('Utilize o formulário abaixo para editar os dados da atividade selecionada. Campos com (*) são obrigatórios.') . '</span>') ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/activity/modal_activity_edit_process" method="post">
			<input type="hidden" name="id_project" id="id_project" value="<?php echo get_value($activity, 'id_project'); ?>" />
			<input type="hidden" name="id_activity" id="id_activity" value="<?php echo get_value($activity, 'id_activity'); ?>" />
			<br />
			<div class="font_11" style="float:right;width:150px;margin:6px 0px 0 0" onclick="show_area('msg-saiba-mais')">
				<img src="<?php echo URL_IMG ?>/icon_help.png" style="float:left;width:13px;margin:1px 4px 0 0" />
				<a href="javascript:void(0)"><?php echo lang('Saiba mais sobre atividades')?></a>
			</div>
			<h6 class="font_shadow_gray"><?php echo lang('Dados da Atividade') ?></h6>
			<hr />
			<div id="msg-saiba-mais" class="font_11" style="position:absolute;margin:-4px 0 0 0;padding:10px;background-color:#000;color:#fff;line-height:18px;display:none">
				<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-up.png" style="float:right;margin:-18px 50px 0 0" />
				<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:10px;cursor:pointer;float:right;margin:0px 0px 0 0" onclick="show_area('msg-saiba-mais')" />
				<div><?php echo lang('Uma atividade de projeto é um grupo de tarefas a serem executadas. As projeções de estimativas de tempo, bem como as porcentagens de uma atividade são baseadas no seu grupo de tarefas.')?></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Projeto')?></div>
				<div class="form_field font_blue" style="width:400px;padding-top:-1px"><h6><?php echo get_value($activity, 'project_title'); ?></h6></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Título da Atividade')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="text" name="title" id="title" value="<?php echo get_value($activity, 'title')?>" class="validate[required]" style="width:300px;" />
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição da Atividade')?></div>
				<div class="form_field" style="width:400px">
					<textarea name="description" id="description" style="width:300px;height:100px"><?php echo get_value($activity, 'description') ?></textarea>
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
