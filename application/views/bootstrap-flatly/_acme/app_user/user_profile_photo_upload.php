<script type="text/javascript" src="<?php echo URL_JS ?>/jquery.imgareaselect.min.js"></script>	
<div>	
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/acme_user/user_profile/' . $id_user; ?>"><?php echo lang("Perfil de Usuário"); ?></a></h2>		
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Alterar Minha Foto')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Alterar Minha Foto') ?></h4>			
			</div>
		</div>
	</div>

	<div id="module_description"><?php echo lang('Utilize o campo abaixo para fazer o envio(upload) de uma nova imagem de usuário. Após o envio você será direcionado para a página de miniatura.') ?></div>

	<h6 style="margin-top:20px" class="font_error" ><?php echo lang('ATENÇÃO! Envie somente um arquivo de imagem nos formatos JPG, PNG, ou GIF. O limite de tamanho máximo de arquivo é de 4MB')?></h6>

	<form style="margin-top: 30px" name="photo" enctype="multipart/form-data" action="<?php echo URL_ROOT; ?>/acme_user/user_profile_photo_upload_process" method="post">
		<div class="inline top"><?php echo input_file('image', 'image')?></div>		
		<div style="margin-top: 40px;">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" name="upload" value="<?php echo lang('Enviar Imagem'); ?>" /></div>
			<!--div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ."/acme_user/user_profile/" . $id_user; ?>"><?php echo lang('voltar')?></a></div-->
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="window.history.back();"><?php echo lang('voltar')?></a></div>
			
			<input type="hidden" id="id_user" name="id_user" value="<?php echo $id_user; ?>" />
			<!-- campos que guardam os nomes das antigas imagens (se existirem) para serem apagadas -->
			<input type="hidden" id="file_name_old"  name="file_name_old"  value="<?php echo $file_name_old; ?>"/> 
			<input type="hidden" id="thumb_name_old" name="thumb_name_old" value="<?php echo $thumb_name_old; ?>"/> 
		</div>
	</form>
</div>

