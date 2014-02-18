<div>
	<script type="text/javascript" src="<?php echo URL_JS ?>/jquery.imgareaselect.min.js"></script>
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/acme_user/user_profile/' .$id_user; ?>"><?php echo lang("Perfil de Usuário"); ?></a></h2>		
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Editar Foto')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Editar Foto') ?></h4>			
			</div>
		</div>
	</div>
	<?php if($error === false) { ?>
	<script type="text/javascript">
		function preview(img, selection) { 
			var scaleX = <?php echo $thumb_width;?> / selection.width; 
			var scaleY = <?php echo $thumb_height;?> / selection.height; 
			
			// $('#thumbnail + div > img').css({ 
			$('#thumbpreview img').css({ 
				width: Math.round(scaleX * <?php echo $file_width;?>) + 'px', 
				height: Math.round(scaleY * <?php echo $file_height;?>) + 'px',
				marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
				marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
			});
			$('#x1').val(selection.x1);
			$('#y1').val(selection.y1);
			$('#x2').val(selection.x2);
			$('#y2').val(selection.y2);
			$('#w').val(selection.width);
			$('#h').val(selection.height);
		} 

		$(document).ready(function () { 

			//Faz miniatura flutuar com o scroll
			$("#imagens").scroll(function () {	
				$("#thumbpreview").animate({
					top: $("#imagens").scrollTop()+"px"
					},{duration:100,queue:false}
				);
			});

		$('div[class^="ui-layout-center"]').css('z-index','0');
			
			$('#save_thumb').click(function() {
				var x1 = $('#x1').val();
				var y1 = $('#y1').val();
				var x2 = $('#x2').val();
				var y2 = $('#y2').val();
				var w = $('#w').val();
				var h = $('#h').val();
				if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
					alert("You must make a selection first");
					return false;
				}else{
					return true;
				}
			});
		}); 

		$(window).load(function () { 
			//Construtor do seletor de miniatura.
			$('#thumbnail').imgAreaSelect({  x1: 20 , y1: 20, x2: 120, y2:120, aspectRatio: '1:<?php  echo $thumb_height/$thumb_width;?>', height: 350, onSelectChange: preview }); 
		});
	</script>
	<div id="module_description"><?php echo lang('Utilize os controles abaixo para atualizar sua miniatura de usuário. Você pode também alterar sua foto atual clicando em Alterar minha Foto, abaixo da Miniatura.')?></div>
	<div style="margin-top: 20px;">   
		<form name="thumbnail" action="<?php echo URL_ROOT; ?>/acme_user/user_profile_photo_save_thumb" method="post">
			<img src="<?php echo URL_UPLOAD."/user_photos/".$file_name;?>" style="margin-right: 10px; margin-top: 10px; clear:both;" id="thumbnail" title="<?php echo lang('Foto Original')?>" />
			<div style="margin-top: -<?php echo $file_height + 2?>px; position:fixed; height: 0; width: 100px; left: <?php echo $file_width + 280; ?>px;">
				<div id="thumbpreview" style="border:1px #777 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
					<img src="<?php echo URL_UPLOAD . "/user_photos/" . $file_name; ?>" title="<?php echo lang('Preview da Miniatura')?>" />	
				</div>
				<div style="margin:0 3px 0 0; position:relative; float:left; top: 10px;" > 
					<input style="width:82px;" type="submit" name="upload_thumbnail" value="<?php echo lang('Salvar') ?>" id="save_thumb" /> 
				</div>
			</div>
			
			<?php echo $this->template->start_box(lang('Mais Ações'), URL_IMG . '/icon_help.png', 'width:250px;position:fixed;padding-bottom:10px;clear:both;margin-left:' . ($file_width + 200) . 'px;margin-top:-' . ($file_height + 2) . 'px')?>
				<h6>&bull;&nbsp;<a href="<?php echo URL_ROOT; ?>/acme_user/user_profile_photo_upload/<?php echo $id_user ."/". str_replace( '.' , '/' ,  $file_name); ?>" ><?php echo lang('Alterar Minha Foto') ?></a></h6>
				<h6>&bull;&nbsp;<a href="<?php echo URL_ROOT . '/acme_user/user_profile/' .$id_user; ?>" ><?php echo lang('Voltar para o Perfil de Usuário') ?></a></h6>			
				<h6>&bull;&nbsp;<a href="<?php echo $this->session->userdata('url_default'); ?>" ><?php echo lang('Ir para a página inicial') ?></a></h6>			
			<?php echo $this->template->end_box(); ?>
			<!--
			<div style="position:fixed; height:150px; width:240px; margin-top:10px; left:920px" class="generic_box">
			<div id="header" style="height:30px">
				<img src="<?php echo URL_IMG ?>/icon_info.png" id="img">
				<h6 style="margin-left:20px !important; position:absolute;" class="white font_shadow_black"><div ><?php echo lang('Mais Ações')?></div></h6>
			</div>
			<div id="content">			
			</div>
			</div>
			-->
			
			<br style="clear:both;"/>
			
			<input type="hidden" name="file_name" value="<?php echo basename(eval_replace($file_name)); ?>" id="file_name" />				
			<input type="hidden" name="thumb_name" value="<?php echo basename(eval_replace($thumb_name)); ?>" id="thumb_name" />				
			<input type="hidden" name="id_user" value="<?php echo $id_user; ?>" id="id_user" />				
			<input type="hidden" name="edit" value="<?php echo (!isset($edit)) ? '0' : $edit; ?>" id="edit" />				
			
			<input type="hidden" name="x1" value="" id="x1" />
			<input type="hidden" name="y1" value="" id="y1" />
			<input type="hidden" name="x2" value="" id="x2" />
			<input type="hidden" name="y2" value="" id="y2" />
			<input type="hidden" name="w" value="" id="w" />
			<input type="hidden" name="h" value="" id="h" />
			
			<!-- Variavel com o nome do antigo arquivo, para ser apagado -->
			<input type="hidden" name="file_name_old"  value="<?php echo $file_name_old;  ?>" id="file_name_old" /> 
			<input type="hidden" name="thumb_name_old" value="<?php echo $thumb_name_old; ?>" id="thumb_name_old" /> 
			
			<hr style="margin-top:20px" />
		</form>
	</div>
	<?php } else { ?>
	<div id="module_description" style="line-height:normal;"><?php echo message('warning', lang('Ops!'), lang('Não foi possível fazer o upload do arquivo selecionado. Verifique a mensagem de erro abaixo e tente novamente:') . '<br /><br /><h6>&bull;&nbsp;<span class="inline">' . lang($error) . '</span></h6>', false, 'margin-top:0px;')?></div>
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.history.back();"><?php echo lang('Voltar')?></button></div>
	</div>
	<?php } ?>
</div>

