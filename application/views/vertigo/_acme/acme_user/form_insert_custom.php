<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
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
			<div class="inline top module_menu_item" title="<?php echo lang('Inserção')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Novo Usuário') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Utilize o formulário abaixo para inserir um novo usuário no sistema. Campos com (*) são obrigatórios.')) ?></div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:30px">
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_user/form_insert_custom_process" method="post">
			<h5><?php echo lang('Dados da Pessoa')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Nome')?>*</div>
				<div class="form_field"><input type="text" name="name" id="name" class="validate[required]" maxlength="250" style="width:300px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Email')?>*</div>
				<div class="form_field"><input type="text" name="email" id="email" class="validate[required,custom[email]]" maxlength="250" style="width:300px" /></div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Observações')?></div>
				<div class="form_field"><textarea name="observation" id="observation" style="width:300px;height:100px;"></textarea></div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Dados do Usuário')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Grupo')?>*</div>
				<div class="form_field">
					<select name="id_user_group" id="id_user_group" style="width:212px" class="validate[required]">
						<option value=""></option>
						<?php foreach($groups as $group) {?>
							<?php if(get_value($group, 'name') == 'ROOT') {?>
								<?php if($is_root) {?>
									<option value="<?php echo get_value($group, 'id_user_group') ?>"><?php echo get_value($group, 'name') ?></option>
								<?php } ?>
							<?php } else { ?>
							<option value="<?php echo get_value($group, 'id_user_group') ?>"><?php echo get_value($group, 'name') ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Login')?>*</div>
				<div class="form_field">
					<input type="text" name="login" id="login" class="validate[required,custom[onlyLetterNumberChrSpecials,funcCall[verify_login]]]" maxlength="250" style="width:200px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Apenas letras, números, pontos ou underscores são permitidos')?></div>
				</div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Senha')?>*</div>
				<div class="form_field">
					<input type="password" name="password" id="password" class="validate[required,minSize[6]]]" maxlength="250" style="width:150px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Mínimo 6 caracteres')?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Repita Senha')?>*</div>
				<div class="form_field">
					<input type="password" name="repeat_password" id="repeat_password" class="validate[required,minSize[6],equals[password]]]" maxlength="250" style="width:150px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Repita a senha anterior')?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Configurações Padrão do Usuário')?></h5>
			<hr style="margin-bottom:10px;" />
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Idioma Padrão')?>*</div>
				<div class="form_field">
					<select name="lang_default" id="lang_default" class="validate[required]" style="width:252px;">
						<option value=""></option>
						<option value="pt_BR"><?php echo lang('Português (Brasil)')?></option>
						<option value="en_US"><?php echo lang('Inglês (Estados Unidos)')?></option>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Página Inicial')?>*</div>
				<div class="form_field">
					<input type="text" name="url_default" id="url_default" class="validate[required]" maxlength="250" style="width:240px" />
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('Quando o usuário efetuar login no sistema, será redirecionado para esta URL. Para isto faça uso das tags do ACME Engine, que são substituídas pelo seu respectivo valor aqui.')?></div>
					<div class="font_11 comment" style="padding-top:5px"><?php echo lang('<strong>Exemplo de tag ACME: </strong> &lt;acme eval="URL_ROOT"/&gt; no momento da leitura do valor deste campo, a tag é substituída pelo respectivo valor da constante URL_ROOT, do php.')?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('ok')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar')?></a></div>
			</div>
		</form>
	</div>
</div>