<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<?php if($permission && $editable) { ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			enable_form_validations();
			enable_masks();
		});		
	</script>
	<?php } ?>
</head>
<body>
	<div id="modal_content">
		<?php if($permission && $editable) { ?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('warning', lang('ATENÇÃO!'), lang('Utilize o formulário abaixo para copiar as permissões de um determinado usuário para o usuário selecionado. O conjunto de permissões aplicadas anteriormente ao usuário') . ' <h6 class="inline">' . get_value($user, 'login') . '</h6> ' . lang('será descartado e as permissões do usuário escolhido na caixa de seleção será o seu novo conjunto de permissões. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/ajax_copy_permissions_process" method="post">
			<input type="hidden" name="id_user_to" id="id_user_to" value="<?php echo get_value($user, 'id_user') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados dos Usuários para Cópia (DE-PARA)') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Copiar permissões do usuário')?>*</div>
				<div class="form_field" style="width:auto;">
					<select name="id_user_from" id="id_user_to" style="width:250px" class="validate[required]">
						<?php echo $user_options; ?>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Para o Usuário')?></div>
				<div class="form_field" style="width:auto;padding-top:5px">
					<div class="bold"><?php echo get_value($user, 'name'); ?></div>
					<div class="font_11"><?php echo lang('Login') . ' ' .get_value($user, 'login'); ?></div>
					<div class="font_11"><?php echo lang('Grupo') . ' ' . get_value($user, 'group_name'); ?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
		<?php } else if(!$permission) { ?>
		<?php echo message('warning', lang('ATENÇÃO!'), lang('Você não possui permissão para realizar esta ação (COPY_PERMISSIONS).')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('Fechar')?></button></div>
		</div>
		<?php } else { ?>
		<?php echo message('warning', lang('ATENÇÃO!'), lang('O usuário que você está tentando realizar a ação de cópia de permissões pertence ao grupo ROOT. Usuários deste grupo só podem ser manipulados por outros usuários do mesmo grupo.')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('Fechar')?></button></div>
		</div>
		<?php } ?>
	</div>
</body>
</html>
