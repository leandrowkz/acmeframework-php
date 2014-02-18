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
		<?php echo message('info', '', lang('Utilize o formulário abaixo para adicionar um novo menu de sistema. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_menu/ajax_modal_menu_new_process" method="post">
			<input type="hidden" name="id_user_group" id="id_user_group" value="<?php echo get_value($group, 'id_user_group'); ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Dados do Menu') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Grupo')?>*</div>
				<div class="form_field" style="width:400px;padding-top:5px"><?php echo get_value($group, 'name'); ?></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Menu Pai')?></div>
				<div class="form_field" style="width:400px">
					<select name="id_menu_parent" id="id_menu_parent" style="width:312px">
						<option value=""><?php echo lang('Não possuirá um menu pai')?></option>
						<?php echo $options_menus; ?>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo do Menu')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="text" name="lang_key_rotule" id="lang_key_rotule" value="" class="validate[required]" style="width:300px;" />
					<div class="comment font_11" style="margin-top:5px"><?php echo lang('O rótulo será o nome do link informado') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Link')?></div>
				<div class="form_field" style="width:400px;"><input type="text" name="link" id="link" value="" style="width:300px;" /></div>
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
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ordenação')?></div>
				<div class="form_field" style="width:400px">
					<input type="text" name="order_" id="order_" value="" alt="integer" style="width:50px;" />
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('Ordenação em que aparecerá em listagens') ?></div>
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
