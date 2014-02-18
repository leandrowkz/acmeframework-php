<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
			$("input:text").setMask();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
	<?php if(get_value($action, 'dtt_inative') != '' || count($action) <= 0 || $error) {?>
		<?php echo message('warning', lang('Atenção!'), lang('A ação de registro que você está tentando editar está inativa. Habilite o uso selecionando o checkbox correspondente e tente novamente.')); ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
		</div>
	<?php } else { ?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para editar os dados do menu. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_action_process" method="post">
			<input type="hidden" name="id_module" id="id_module" value="<?php echo get_value($action, 'id_module') ?>" />
			<input type="hidden" name="operation" id="operation" value="<?php echo $operation ?>" />
			<input type="hidden" name="id_module_action" id="id_module_action" value="<?php echo get_value($action, 'id_module_action') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Propriedades da Ação') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Módulo')?></div>
				<div class="form_field"><div style="margin-top:5px"><?php echo lang(get_value($module, 'lang_key_rotule')) ?></div></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Link')?>*</div>
				<div class="form_field"><input type="text" name="link" id="link" class="validate[required]" value="<?php echo htmlentities(get_value($action, 'link')) ?>" style="width:300px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('URL Imagem')?></div>
				<div class="form_field"><input type="text" name="url_img" id="url_img" value="<?php echo htmlentities(get_value($action, 'url_img')) ?>" style="width:300px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Target')?></div>
				<div class="form_field"><input type="text" name="target" id="target" value="<?php echo get_value($action, 'target') ?>" style="width:200px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição')?></div>
				<div class="form_field">
					<input type="text" name="description" id="description" value="<?php echo get_value($action, 'description') ?>" style="width:200px" />
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('A descrição da ação aparecerá quando o mouse estiver sobre o ícone/link da ação.') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ordenação')?></div>
				<div class="form_field"><input type="text" name="order" id="order" value="<?php echo get_value($action, 'order') ?>" style="width:200px" /></div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
			</div>
		</form>
	<?php } ?>
	</div>
</body>
</html>
