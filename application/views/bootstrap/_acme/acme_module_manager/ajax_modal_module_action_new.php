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
		<?php echo message('info', '', lang('Utilize o formulário abaixo para adicionar uma nova ação de registro para este módulo. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_action_new_process" method="post">
			<input type="hidden" name="id_module" id="id_module" value="<?php echo $id_module ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados da Ação de Registro') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo da Ação')?>*</div>
				<div class="form_field" style="width:400px;">
					<input type="text" name="lang_key_rotule" id="lang_key_rotule" value="" class="validate[required]" style="width:300px;" />
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('O rótulo aparecerá caso um ícone não seja definido para a ação. Caso o ícone seja definido então o rótulo aqui definido aparecerá como title="" deste ícone') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Link')?>*</div>
				<div class="form_field" style="width:400px;">
					<input type="text" name="link" id="link" value="" style="width:300px;" class="validate[required]" />
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('Link da ação. Você pode informar a posição da coluna que será aplicada no link para cada registro da consulta do módulo.<br /><br />Por exemplo:<br />No link controlador/action/{0}, a expressão "{0}" será substituída pelo valor da coluna zero (primeira coluna) da consulta do módulo, para cada registro.') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Target do Link')?></div>
				<div class="form_field"><input type="text" name="target" id="target" value="" style="width:120px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Imagem (Ícone)')?></div>
				<div class="form_field"><input type="text" name="url_img" id="url_img" value="" style="width:300px;" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Javascript')?></div>
				<div class="form_field" style="width:400px">
					<textarea name="javascript" id="javascript" style="width:400px;height:100px"></textarea>
					<div class="font_11 comment" style="margin-top:5px"><?php echo lang('Insira chamadas de funções e eventos javascript neste campo, como por exemplo:<br />onclick="do_something(this.value)"<br />onchange="free_me_please(this.value)"') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição')?></div>
				<div class="form_field" style="width:400px">
					<textarea name="description" id="description" style="width:400px;height:100px"></textarea>
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('Descrição da ação para uso informativo interno') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ordenação')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="text" name="order" id="order" value="" class="validate[required]" alt="integer" style="width:50px;" />
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('Ordenação em que aparecerá em listagens') ?></div>
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
