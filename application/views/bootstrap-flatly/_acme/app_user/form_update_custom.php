<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		<?php if($editable) { ?>
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
		<?php } ?>
		$("input:text").setMask();
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Edição')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Editar Usuário') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;">
		<?php if(!$editable) {?>
		<?php echo message('error', lang('ATENÇÃO!'), lang('Você não pode editar os dados deste usuário pois ele pertence ao grupo ROOT. Usuários deste grupo só podem ser editados por usuários do mesmo grupo.')) ?>
		<?php } else { ?>
		<?php echo message('info', '', lang('Utilize o formulário abaixo para editar os dados do usuário selecionado. Campos com (*) são obrigatórios.')) ?>
		<?php } ?>
	</div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:30px">
		<?php if($editable) { ?>
		<form id="form_default" name="form_default" action="<?php echo (!$editable) ? URL_ROOT . '/acme_user' : URL_ROOT . '/acme_user/form_update_custom_process';?>" method="post" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?>>
		<?php } ?>
			<input type="hidden" name="id_user" id="id_user" value="<?php echo get_value($user, 'id_user') ?>" />
			<h5><?php echo lang('Dados da Pessoa')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Nome')?>*</div>
				<div class="form_field"><input type="text" name="name" id="name" class="validate[required]" maxlength="250" style="width:300px" value="<?php echo get_value($user, 'name') ?>" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?> /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Email')?>*</div>
				<div class="form_field"><input type="text" name="email" id="email" class="validate[required,custom[email]]" maxlength="250" style="width:300px" value="<?php echo get_value($user, 'email') ?>" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?> /></div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Observações')?></div>
				<div class="form_field"><textarea name="observation" id="observation" style="width:300px;height:100px;" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?>><?php echo get_value($user, 'observation') ?></textarea></div>
			</div>
			<?php if(get_value($user, 'group_name') != 'ROOT') { ?>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ativo')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="radio" name="dtt_inative" id="dtt_inative" value="" style="margin:7px 5px 0 0" <?php echo (get_value($user, 'dtt_inative') == '') ? 'checked="checked"' : ''?> <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?> /><h6 class="font_success inline top"><?php echo lang('Sim') ?></h6>
					<br />
					<input type="radio" name="dtt_inative" id="dtt_inative" value="CURRENT_TIMESTAMP" style="margin:7px 5px 0 0" <?php echo (get_value($user, 'dtt_inative') != '') ? 'checked="checked"' : ''?> <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?> /><h6 class="font_error inline top"><?php echo lang('Não') ?></h6>
					<div class="font_11 font_red" style="margin-top:5px;"><?php echo lang('<strong>ATENÇÃO!</strong> Usuários inativos não podem logar no sistema. Em uma tentativa de login no sistema estando inativo, estes usuários recebem a mensagem de usuário ou senha inválidos.') ?></div>
					<div class="font_11 comment" style="margin-top:5px;"><?php echo lang('Estar ativo ou não também influencia na visibilidade deste módulo em combos, listagens, acessos, etc.') ?></div>
				</div>
			</div>
			<?php } ?>
			
			<br />
			<br />
			<h5><?php echo lang('Dados do Usuário')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Grupo')?>*</div>
				<div class="form_field">
					<select name="id_user_group" id="id_user_group" style="width:212px" class="validate[required]" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?>>
						<option value=""></option>
						<?php foreach($groups as $group) {?>
							<?php if(get_value($group, 'name') == 'ROOT') {?>
								<?php if($is_root) {?>
									<option value="<?php echo get_value($group, 'id_user_group') ?>" <?php echo (get_value($group, 'name') == get_value($user, 'group_name')) ? 'selected="selected"' : ''; ?>><?php echo get_value($group, 'name') ?></option>
								<?php } ?>
							<?php } else { ?>
							<option value="<?php echo get_value($group, 'id_user_group') ?>" <?php echo (get_value($group, 'name') == get_value($user, 'group_name')) ? 'selected="selected"' : ''; ?>><?php echo get_value($group, 'name') ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Login')?>*</div>
				<div class="form_field" style="width:400px">
					<input type="hidden" name="login_previous" id="login_previous" class="" maxlength="250" value="<?php echo get_value($user, 'login') ?>" />
					<input type="text" name="login" id="login" class="" maxlength="250" style="width:200px" value="<?php echo get_value($user, 'login') ?>" disabled="disabled" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Apenas letras, números, pontos ou underscores são permitidos') ?></div>
					<div class="font_red font_11 comment" style="padding-top:5px"><?php echo lang('<strong>ATENÇÃO!</strong> Recomenda-se que este campo não seja alterado após a criação do usuário. Caso ainda assim você queiram alterá-lo, clique <a href="javascript:void(0);" onclick="$(\'#login\').attr(\'disabled\', false);$(\'#login\').attr(\'class\', \'validate[required,custom[onlyLetterNumberChrSpecials,funcCall[verify_login_custom]]]\');$(\'#login\').focus();" class="black">aqui</a>.') ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Configurações Padrão do Usuário')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Idioma Padrão')?>*</div>
				<div class="form_field">
					<select name="lang_default" id="lang_default" class="validate[required]" style="width:252px;" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?>>
						<option value=""></option>
						<option value="pt_BR" <?php echo (get_value($user, 'lang_default') == 'pt_BR') ? 'selected="selected"' : ''; ?>><?php echo lang('Português (Brasil)')?></option>
						<option value="en_US" <?php echo (get_value($user, 'lang_default') == 'en_US') ? 'selected="selected"' : ''; ?>><?php echo lang('Inglês (Estados Unidos)')?></option>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Página Inicial')?>*</div>
				<div class="form_field">
					<input type="text" name="url_default" id="url_default" class="validate[required]" maxlength="250" style="width:240px" value="<?php echo htmlentities(get_value($user, 'url_default')) ?>" <?php echo (!$editable) ? 'disabled="disabled"' : ''; ?> />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Quando o usuário efetuar login no sistema, será redirecionado para esta URL. Para isto faça uso das tags do ACME Engine, que são substituídas pelo seu respectivo valor aqui.')?></div>
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('<strong>Exemplo de tag ACME: </strong> &lt;acme eval="URL_ROOT"/&gt; no momento da leitura do valor deste campo, a tag é substituída pelo respectivo valor da constante URL_ROOT, do php.')?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top">
					<?php if(!$editable){ ?>
					<button onclick="redirect('<?php echo URL_ROOT ?>/acme_user/')"><?php echo lang('ok')?></button>
					<?php } else { ?>
					<input type="submit" value="<?php echo lang('ok')?>" />
					<?php } ?>
				</div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar')?></a></div>
			</div>
		<?php if(!$editable){ ?>
		</form>
		<?php } ?>
	</div>
</div>