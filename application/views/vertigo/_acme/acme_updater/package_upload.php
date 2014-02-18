<div>	
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_updater/"><?php echo lang("Atualizações"); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_updater.png" />
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Instalar Pacote de Atualização')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Instalar Pacote de Atualização') ?></h4>			
			</div>
		</div>
	</div>

	<div id="module_description"><?php echo lang('Utilize o campo abaixo para fazer o envio(upload) de um novo pacote de atualização. Após o envio você será direcionado para a página de revisão do conteúdo do pacote.') ?></div>

	<h6 style="margin-top:20px" class="font_error" ><?php echo lang('ATENÇÃO! São aceitos somente arquivos compactados no formato zip. O limite de tamanho máximo de arquivo é de 4MB')?></h6>

	<form style="margin-top: 30px" name="photo" enctype="multipart/form-data" action="<?php echo URL_ROOT; ?>/acme_updater/package_review" method="post">
		<div class="inline top"><?php echo input_file('package', 'package'); ?></div>
		<div style="margin-top: 40px;">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" name="upload" value="<?php echo lang('Enviar Pacote'); ?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_updater/"><?php echo lang('voltar')?></a></div>
		</div>
	</form>
</div>

