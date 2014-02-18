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
		<?php if($user) { ?>
		<?php echo message('success', lang('Sucesso!'), lang('Senha de acesso alterada com sucesso! A partir do próximo login no sistema você deverá utilizar esta nova senha.')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('OK')?></button></div>
		</div>
		<?php } else { ?>
		<?php echo message('warning', lang('Não foi possível realizar esta ação'), lang('A senha atual informada está incorreta. tente novamente.')) ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_user/ajax_change_password/<?php echo $id_user; ?>')"><?php echo lang('Voltar')?></button></div>
		</div>
		<?php } ?>
	</div>
</body>
</html>
