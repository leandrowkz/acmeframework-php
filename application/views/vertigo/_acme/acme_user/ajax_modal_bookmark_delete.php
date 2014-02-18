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
		<?php echo message('warning', lang('ATENÇÃO!'), lang('O favorito de usuário que está sendo visualizado será deletado. Para continuar clique em <strong>ok</strong>, para desistir clique em <strong>cancelar</strong>.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/ajax_modal_bookmark_delete_process" method="post">
			<input type="hidden" name="id_user_bookmark" id="id_user_bookmark" value="<?php echo get_value($bookmark, 'id_user_bookmark') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Favorito') ?></h6>
			<hr style="margin-bottom:5px;" />
			<div id="box_group_view">
				<div class="odd">
					<div id="label_view"><?php echo lang('ID (#)') ?></div>
					<div id="field_view"><?php echo get_value($bookmark, 'id_user_bookmark') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Usuário') ?></div>
					<div id="field_view"><?php echo lang(get_value($bookmark, 'login')) ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Link') ?></div>
					<div id="field_view"><?php echo htmlentities(get_value($bookmark, 'link')) ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Rótulo') ?></div>
					<div id="field_view"><?php echo lang(get_value($bookmark, 'name')) ?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	</div>
</body>
</html>
