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
		<?php if(!stristr(get_value($module, 'controller'), 'acme_') || $manage_acme_modules_permission === true) {?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para editar os dados do módulo. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_module_data_process" method="post">
			<input type="hidden" name="id_module" id="id_module" value="<?php echo get_value($module, 'id_module') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Módulo') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo do Módulo')?>*</div>
				<div class="form_field"><input type="text" name="lang_key_rotule" id="lang_key_rotule" value="<?php echo get_value($module, 'lang_key_rotule')?>" class="validate[required]" style="width:400px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Tabela')?></div>
				<div class="form_field"><input type="text" name="table" id="table" value="<?php echo get_value($module, 'table')?>" style="width:170px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Controlador')?>*</div>
				<div class="form_field" style="width:500px">
					<input type="text" name="controller" id="controller" value="<?php echo get_value($module, 'controller')?>" class="validate[required]" style="width:170px;" <?php echo (stristr(get_value($module, 'controller'), 'acme_')) ? 'disabled="disabled"' : ''; ?> />
					<?php if(stristr(get_value($module, 'controller'), 'acme_')) {?>
					<h6 class="font_error" style="margin-top:5px"><?php echo lang('ATENÇÃO! Você não pode alterar o controlador deste módulo pois este é um módulo interno essencial para o funcionamento do restante da aplicação.') ?></h6>
					<?php } else { ?>
					<div class="font_error font_11" style="margin-top:5px"><?php echo lang('ATENÇÃO! Alterar o nome do controlador faz com que você tenha que renomear os arquivos correspondentes ao módulo (MVC) manualmente, caso contrário o módulo não irá mais funcionar.') ?></div>
					<div class="font_11" style="margin-top:5px">
						<strong><?php echo lang('Arquivos deste Módulo (MVC)')?>:</strong>
						<br />
						<strong>controller:</strong>&nbsp;&nbsp;application/controllers/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ? 'acme/' : '';?><?php echo get_value($module, 'controller') ?>.php
						<br />
						<strong>model:</strong>&nbsp;&nbsp;application/models/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ? 'acme/' : '';?><?php echo get_value($module, 'controller') ?>_model.php
						<br />
						<strong>view:</strong>&nbsp;&nbsp;application/views/<?php echo TEMPLATE ?>/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ?  '_acme/' : '' ?><?php echo get_value($module, 'controller') ?>/<span class="comment">&nbsp;&nbsp;&nbsp;<?php echo lang('(Diretório)')?></span>
						<br />
					</div>
					<?php } ?>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Imagem do Módulo')?></div>
				<div class="form_field"><input type="text" name="url_img" id="url_img" value="<?php echo htmlentities(get_value($module, 'url_img'))?>" style="width:400px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('SQL de Listagem')?></div>
				<div class="form_field"><textarea name="sql_list" id="sql_list" class="script" style="width:400px;height:170px"><?php echo get_value($module, 'sql_list')?></textarea></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição do Módulo')?></div>
				<div class="form_field">
					<textarea name="description" id="description" style="width:400px;height:170px"><?php echo get_value($module, 'description')?></textarea>
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('A descrição do módulo se mantém presente na entrada do módulo.') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Qtde. de Itens por Página')?>*</div>
				<div class="form_field" style="width:500px">
					<input type="text" name="items_per_page" id="items_per_page" value="<?php echo get_value($module, 'items_per_page')?>" alt="integer" style="width:50px;" />
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('A quantidade de itens por página influencia na quantidade de registros que a consulta do módulo (<strong>SQL de Listagem</strong>) reproduz') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ativo')?>*</div>
				<div class="form_field" style="width:500px">
					<input type="radio" name="dtt_inative" id="dtt_inative" value="" style="margin:7px 5px 0 0" <?php echo (get_value($module, 'dtt_inative') == '') ? 'checked="checked"' : ''?> /><h6 class="font_success inline top"><?php echo lang('Sim') ?></h6>
					<br />
					<input type="radio" name="dtt_inative" id="dtt_inative" value="CURRENT_TIMESTAMP" style="margin:7px 5px 0 0" <?php echo (get_value($module, 'dtt_inative') != '') ? 'checked="checked"' : ''?> /><h6 class="font_error inline top"><?php echo lang('Não') ?></h6>
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('Estar ativo ou não influencia na visibilidade deste módulo em combos, listagens, acessos, etc.') ?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
		<?php } else { ?>
		<?php echo message('warning', lang('ATENÇÃO!'), lang('Este é um módulo interno (do ACME) e você não possui permissões de gerenciamento de módulos internos. Revise suas permissões para poder alterar estes dados.')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
		</div>
		<?php } ?>
	</div>
</body>
</html>
