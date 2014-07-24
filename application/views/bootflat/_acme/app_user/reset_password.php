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
			<div class="inline top module_menu_item" title="<?php echo lang('Solicitar Alteração de Senha')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Solicitar Alteração de Senha') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('warning', lang('ATENÇÃO!'), lang('Você está prestes a autorizar uma solicitação de alteração de senha de acesso para o usuário que está sendo visualizado. Um email será encaminhado para ') . '<h6 class="inline">' . get_value($user, 'email') . '</h6>' . lang(' contendo as instruções necessárias para alteração da senha atual. Clique em ok caso você tenha certeza desta ação, caso contrário clique em cancelar.')) ?></div>	
	
	<br />
	<h5><?php echo lang('Dados do Usuário') ?></h6>
	<hr style="margin-bottom:10px;" />
	<form name="form_default" id="form_default" action="<?php echo URL_ROOT ?>/acme_user/reset_password_process" method="post">
		<input type="hidden" name="id_user" id="id_user" value="<?php echo get_value($user, 'id_user') ?>" />
		<div id="box_group_view">
			<div class="odd">
				<div id="label_view" class="inline"><?php echo lang('Usuário') ?></div>
				<div id="field_view" class="inline"><?php echo get_value($user, 'name') ?></div>
			</div>
			<div class="">
				<div id="label_view" class="inline"><?php echo lang('Login') ?></div>
				<div id="field_view" class="inline"><?php echo get_value($user, 'login') ?></div>
			</div>
			<div class="odd">
				<div id="label_view" class="inline"><?php echo lang('Email') ?></div>
				<div id="field_view" class="inline"><?php echo get_value($user, 'email') ?></div>
			</div>
			<div class="">
				<div id="label_view" class="inline"><?php echo lang('Grupo') ?></div>
				<div id="field_view" class="inline"><?php echo get_value($user, 'grup') ?></div>
			</div>
		</div>
		
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('OK, Enviar email de Alteração')?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('cancelar') ?></a></div>
		</div>
	</form>
</div>