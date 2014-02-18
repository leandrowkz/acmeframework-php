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
		<?php echo message('warning', lang('ATENÇÃO!'), lang('A ação de registro que está sendo visualizada será deletada. Para confirmar a deleção, clique em <strong>ok</strong>, caso contrário clique em <strong>cancelar</strong>.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_action_delete_process" method="post">
			<input type="hidden" name="id_module_action" id="id_module_action" value="<?php echo get_value($data, 'id_module_action') ?>" />
			<input type="hidden" name="id_module" id="id_module" value="<?php echo get_value($data, 'id_module') ?>" />
			<br />
			<h5 class="font_shadow_gray inline top"><?php echo lang('Dados da Ação de Registro') ?></h5>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div class="odd">
					<div id="label_view"><?php echo lang('ID (#)') ?></div>
					<div id="field_view"><?php echo get_value($data, 'id_module_action') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Rótulo da Ação') ?></div>
					<div id="field_view"><?php echo lang(get_value($data, 'lang_key_rotule')) ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Link') ?></div>
					<div id="field_view"><?php echo htmlentities(get_value($data, 'link')) ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Descrição') ?></div>
					<div id="field_view"><?php echo lang(get_value($data, 'description')) ?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
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
