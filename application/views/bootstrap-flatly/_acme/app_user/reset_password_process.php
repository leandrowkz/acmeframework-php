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
	<div id="module_description" style="line-height:normal;">
	<?php
		if($sent_email)
			echo message('success', lang('Sucesso!'), lang('O email de solicitação de alteração de senha foi enviado com sucesso! A partir de agora, a alteração de senha está por conta do próprio usuário.'));
		else
			echo message('warning', lang('Ops!'), lang('Não foi possível enviar o email de solicitação de nova senha. Verifique as configurações do servidor de email ou seu estado atual funcionamento e tente novamente.'));
	?>
	</div>	
	
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_user')"><?php echo lang('OK')?></button></div>
	</div>
</div>