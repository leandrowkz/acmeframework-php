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
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Gerenciamento de Permissões')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Gerenciamento de Permissões') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Utilize esta página para gerenciar as permissões do usuário que está sendo visualizado. ATENÇÃO! As ações realizadas nas caixas de seleção (marcar/desmarcar) são executadas em tempo real.')) ?></div>	
	
	<div id="box_group_view" style="margin: 50px 0 50px;">
		<div class="odd">
			<div id="label_view" class="inline"><?php echo lang('Usuário') ?></div>
			<div id="field_view" class="inline">
				<div class="inline top"><?php echo get_value($user_data, 'name') ?></div>
				<br />
				<h6 class="inline top" style="margin-top:0px;"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Copiar Permissões de Outro Usuário')?>', '<?php echo URL_ROOT ?>/acme_user/ajax_copy_permissions/<?php echo get_value($user_data, 'id_user') ?>', '', 600, 500)"><?php echo lang('Copiar Permissões de Outro Usuário')?></a></h6>
			</div>
		</div>
		<div class="">
			<div id="label_view" class="inline"><?php echo lang('Login') ?></div>
			<div id="field_view" class="inline"><?php echo get_value($user_data, 'login') ?></div>
		</div>
		<div class="odd">
			<div id="label_view" class="inline"><?php echo lang('Email') ?></div>
			<div id="field_view" class="inline"><?php echo get_value($user_data, 'email') ?></div>
		</div>
		<div class="">
			<div id="label_view" class="inline"><?php echo lang('Grupo') ?></div>
			<div id="field_view" class="inline"><?php echo get_value($user_data, 'grup') ?></div>
		</div>
	</div>
	
	
	<input type="text" id="search_mod" placeholder="<?php echo lang('Módulo...') ?>" style="width: 100px; font-size: 18px !important; font-family: 'Open Sans Condensed' !important; font-weight: bold !important; float:right; margin-top:-5px; background-color: FF0000; background-image: url('<?php echo URL_IMG ?>/icon_search.png' ); background-repeat: no-repeat; background-position: right; padding-right: 22px;"  />
	<h4 class="inline" style="margin-bottom: 5px;"><?php echo lang("Permissões")?> <?php echo lang('dos Módulos') ?> <?php echo ($show_acme_modules) ? lang('do ACME Engine') : lang('da Aplicação'); ?></h4>
	<!--<h5 class="inline comment"><?php echo lang(" (para o usuário "). get_value($user_data, 'login').")"?></h5>-->
	<div class="inline top" style="margin-top:13px;">
		<form id="form_modules" action="<?php echo URL_ROOT ?>/acme_user/permission_manager/<?php echo get_value($user_data, 'id_user');?>" method="post" class="inline top">
			<?php if($show_acme_modules) { ?>
			<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="N" />
			<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos da Aplicação')?></a>
			<?php } else { ?>
			<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="Y" />
			<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos do ACME Engine')?></a>
			<?php } ?>
		</form>
	</div>
	<hr style="margin-bottom: 10px;">
	<?php if(count($lista) > 0) {?>
	<?php 
	$i = 0;
	$modulo_anterior = '';
	foreach($lista as $module) { 
	?>
	<?php if(get_value($module, 'mod_lang_key_rotule') != $modulo_anterior) { ?>
	<?php $cont_class = 0; ?>
	<?php if($i > 0) { ?>	</td></tr></table></div></div><?php } ?>
	
	<div id="div_module_<?php echo $i;?>">
	
	<div id="box_group_view" style="margin-bottom:50px; background-color: #f5f5f5; ">
	<table width="100%" >
	<tr>
	<td id="box_permission_left" style="width:30px !important; padding: 20px 0 0 20px;" > 	
		<img class="inline top" style="float:right;" src="<?php echo eval_replace(get_value($module, 'URL_IMG')) ?>"> 
	</td>
	<td id="box_permission_center" style="width:170px !important; padding: 20px; border-right: 1px solid #CCC;" > 
		<h5 id="module_<?php echo $i;?>" class="inline top"><?php echo lang(get_value($module, 'mod_lang_key_rotule')) ?></h5>	
		<!-- <div class="font_11 comment"><?php echo get_value($module, 'description')?></div> -->
	</td>
	<td id="box_permission_right" style="line-height: 30px; background-color:#FFF;">
	<?php }  ?>
		<div <?php echo ($cont_class % 2 == 0) ? '' : ' class="odd"'?> style="padding: 10px; ">
			<input type="hidden" id="lang_permission_enable_<?php echo get_value($module, 'id_module_permission') ?>"  value="<?php echo get_value($module, 'permission'). " (". get_value($module, 'perm_lang_key_rotule') .")"; //TIRAR O SIM E NÃO - COLOCAR O LANG NO LUGAR ?>" />  
			<input type="hidden" id="lang_permission_disable_<?php echo get_value($module, 'id_module_permission') ?>" value="<?php echo get_value($module, 'permission'). " (". get_value($module, 'perm_lang_key_rotule') .")"; ?>" />
			<input type="checkbox" id="checkbox_action_<?php echo get_value($module, 'id_module_permission') ?>" class="inline top" onclick="ajax_set_user_permission(<?php echo get_value($user_data, 'id_user')?>,<?php echo get_value($module, 'id_module_permission') ?>  )" style="margin-top:15px;" <?php echo (get_value($module, 'TEM_PERMISSAO') == 'N' ) ? '' : 'checked="checked"'; ?>  />
			<h6 id="status_action_<?php echo get_value($module, 'id_module_permission') ?>" class="<?php echo get_value($module, 'TEM_PERMISSAO') == 'N' ? 'font_error inline top' : 'font_success inline top' ?>"   style="margin: 6px 0 3px 0" ><?php echo get_value($module, 'permission'). " (". get_value($module, 'perm_lang_key_rotule') .")"; ?></h6> 
			<br />
			<div class="inline font_11 comment" style="line-height: 18px; margin-left: 16px; margin-top: -8px;" ><?php echo get_value($module, 'perm_description')?></div>
		</div>
	<?php 
		$i++;
		$cont_class++;
		$modulo_anterior = get_value($module, 'mod_lang_key_rotule');
	} 
	?>
	</table>	
	</div>
	</div>
	
	<div id="div_msg_no_module" style="display: none; line-height:normal;"><?php echo message('info', lang('Nenhum Módulo Encontrado'), lang('Sua pesquisa não contém resultados.')); ?></div>	
	<?php } else { ?>
	<?php echo message('info', lang('Nenhum Módulo'), lang('Nenhum módulo cadastrado até o momento para esta aplicação.')); } ?>
	
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo URL_ROOT . '/' . $this->controller ?>'"><?php echo lang('ok')?></button></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('voltar') ?></a></div>
	</div>
</div>