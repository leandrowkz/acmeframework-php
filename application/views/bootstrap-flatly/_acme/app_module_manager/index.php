<script type="text/javascript" language="javascript">
$(document).ready(function(){
	// Focus no inpu de pesquisa
	$("#search_mod").focus();
	
	// Ataccha evendo no input de pesquisa
	$("#search_mod").keyup(function() {
		var exist = false;
		if($("#search_mod").val().length > 2){			
			
			$('h5[id^="module_"]').each(function(){ 				
				$("#div_"+$(this).attr('id')).hide();								
			});
			
			var pesq = $("#search_mod").val().toLowerCase(); 		
			
			$('h5[id^="module_"]').each(function(index){ 
			
				var perm = $(this).text().toLowerCase();				
				
				if(perm.indexOf(pesq) != -1){					
					exist = true;
					$('#div_msg_no_module').hide();
					$("#div_"+$(this).attr('id')).show();	
				}
			});
			
			if(exist == false){
				$('#div_msg_no_module').show();
			}
		
		}else if(($("#search_mod").val().length <= 2)||($("#search_mod").val().length == '')){
			$('h5[id^="module_"]').each(function(index){ 
				$("#div_"+$(this).attr('id')).show();		
				$('#div_msg_no_module').hide();
			});
		}
	});
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
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description"><?php echo $this->description; ?></div>	
	
	<h4 class="inline top font_shadow_gray" style="margin-top:40px;"><?php echo lang('Módulos') ?> <?php echo ($show_acme_modules) ? lang('do ACME Engine') : lang('da Aplicação'); ?></h4>
	<div class="inline top" style="margin-top:50px;">
		<form id="form_modules" action="<?php echo URL_ROOT ?>/acme_module_manager/" method="post" class="inline top">
			<?php if($show_acme_modules) { ?>
			<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="N" />
			<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos da Aplicação')?></a>
			<?php } else { ?>
			<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="Y" />
			<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos do ACME Engine')?></a>
			<?php } ?>
		</form>
	</div>
	<?php if(count($modules) > 0) {?>
	<input type="text" id="search_mod" placeholder="<?php echo lang('Módulo...') ?>" style="width:105px;font-size:15px !important;font-family:'Open Sans Condensed' !important;font-weight:bold !important;float:right;margin-top:40px;background-color:FF0000;background-image: url('<?php echo URL_IMG ?>/icon_search.png' );background-repeat:no-repeat;background-position:right;padding-right:22px;" />
	<hr style="margin:5px 0 10px 0" />
	
	<?php 
	$i = 0;
	$modulo_anterior = '';
	foreach($modules as $module) { 
	?>
	<?php if(get_value($module, 'lang_key_rotule') != $modulo_anterior) { ?>
	<?php $cont_class = 0; ?>
	<?php if($i > 0) { ?>	</td></tr></table></div></div><?php } ?>
	
	<div id="div_module_<?php echo $i;?>">
		<div id="box_group_view" style="margin-bottom:50px; background-color: #f5f5f5; ">
			<table width="100%" >
			<tr>
			<td id="box_permission_left" style="width:30px !important; padding: 20px 0 0 20px;" > 
				<?php if(get_value($module, 'URL_IMG') != '') { ?>
				<img class="inline top" style="float:right;" src="<?php echo eval_replace(get_value($module, 'URL_IMG')) ?>"> 
				<?php } ?>
			</td>
			<td id="box_permission_center" style="width:120px !important; padding: 22px 10px; border-right: 1px solid #CCC;" > 
				<h5 id="module_<?php echo $i;?>" class="inline top"><?php echo lang(get_value($module, 'lang_key_rotule')) ?></h5>
			</td>
			<td id="box_permission_right" style="line-height:18px; background-color:#FFF;">
			<?php }  ?>
				<div style="padding:14px 10px 10px 10px" class="font_11">
					<a href="<?php echo URL_ROOT . '/' . get_value($module, 'controller') ?>"><?php echo lang('Ir para o módulo')?></a>
					&nbsp;&nbsp;&nbsp;
					<a href="<?php echo URL_ROOT ?>/acme_module_manager/administration/<?php echo get_value($module, 'id_module') ?>"><?php echo('Configurações do Módulo')?></a>
					<div class="font_11" style="margin-top:5px"><?php echo get_value($module, 'description')?></div>
					<div class="font_11 bold" style="margin-top:5px">
						<?php
							echo lang('Situação do módulo:');
							echo (get_value($module, 'dtt_inative') != '') ? '<span class="font_error"> Inativo</span>' : '<span class="font_green"> Ativo</span>';
						?>
					</div>
				</div>
			<?php 
				$i++;
				$cont_class++;
				$modulo_anterior = get_value($module, 'lang_key_rotule');
			} 
			?>
			</table>
		</div>
	</div>
	<div id="div_msg_no_module" style="display: none; line-height:normal;"><?php echo message('info', lang('Nenhum Módulo Encontrado'), lang('Sua pesquisa não contém resultados.')); ?></div>
	<?php } else { ?>
	<hr style="margin:5px 0 10px 0" />
	<?php echo message('info', lang('Nenhum Módulo'), lang('Nenhum módulo cadastrado até o momento para esta aplicação.')); } ?>
</div>