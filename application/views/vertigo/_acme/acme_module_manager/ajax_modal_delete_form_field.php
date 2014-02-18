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
	<?php if($error || get_value($field, 'dtt_inative') != '' || count($field) <= 0) {?>
		<?php echo message('warning', 'Atenção!', lang('O campo que você está tentando deletar ainda não foi marcado para uso. Selecione o checkbox correspondente ao campo e tente novamente.')); ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
		</div>
	<?php } else if(get_value($field, 'form_inative') == 'S' || get_value($field, 'form_inative') == '') { ?>
		<?php echo message('warning', 'Atenção!', lang('O formulário deste campo está inativo. Habilite o uso deste formulário selecionando o checkbox e tente novamente.')); ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
		</div>
	<?php } else { ?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('warning', 'Atenção!', lang('O campo que está sendo visualizado será deletado. Ele deixará de aparecer no formulário vinculado, e, caso você queira poderá habilitá-lo posteriormente.')) ?>
		
		<!-- FORMULARIO -->
		<br />
		<br />
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_delete_form_field_process" method="post">
			<input type="hidden" name="id_module_form_field" id="id_module_form_field" value="<?php echo $id_module_form_field ?>" />
			<div id="box_group_view">
				<div class="odd">
					<div id="label_view"><?php echo lang('Coluna (Tabela)') ?></div>
					<div id="field_view"><?php echo get_value($field, 'table_column') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('Tipo') ?></div>
					<div id="field_view"><?php echo get_value($field, 'type') ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Rótulo de Exibição') ?></div>
					<div id="field_view"><?php echo get_value($field, 'lang_key_label') ?></div>
				</div>
				<div>
					<div id="label_view"><?php echo lang('ID HTML') ?></div>
					<div id="field_view"><?php echo get_value($field, 'id_html') ?></div>
				</div>
				<div class="odd">
					<div id="label_view"><?php echo lang('Ordenação') ?></div>
					<div id="field_view"><?php echo get_value($field, 'order') ?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();">cancelar</a></div>
			</div>
		</form>
	<?php } ?>
	</div>
</body>
</html>
