<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Carrega tabelas de permissoes, actions e menus
		ajax_load_table_module_custom_data(<?php echo get_value($module, 'id_module'); ?>, 'permissions');
		ajax_load_table_module_custom_data(<?php echo get_value($module, 'id_module'); ?>, 'actions');
		ajax_load_table_module_custom_data(<?php echo get_value($module, 'id_module'); ?>, 'menus');
		
		// Carrega formulário de filtros
		ajax_load_box_config_form('filter', <?php echo get_value($module, 'id_module') ?>);
		
		// Atacha funcoes ao click das abas
		$('#aba_form_filter').click(function(){ ajax_load_box_config_form('filter', <?php echo get_value($module, 'id_module'); ?>) }); 
		$('#aba_form_insert').click(function(){ ajax_load_box_config_form('insert', <?php echo get_value($module, 'id_module'); ?>) }); 
		$('#aba_form_update').click(function(){ ajax_load_box_config_form('update', <?php echo get_value($module, 'id_module'); ?>) }); 
		$('#aba_form_delete').click(function(){ ajax_load_box_config_form('delete', <?php echo get_value($module, 'id_module'); ?>) }); 
		$('#aba_form_view').click(function(){ ajax_load_box_config_form('view', <?php echo get_value($module, 'id_module'); ?>) });
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
			<div class="inline top module_menu_item" title="<?php echo lang(get_value($module, 'lang_key_rotule'))?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang(get_value($module, 'lang_key_rotule'))?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description"><?php echo lang('Gerencie dados, configurações, preferências, permissões, ações e menus do módulo selecionado, nesta tela.') ?></div>
	
	<?php if(stristr(get_value($module, 'controller'), 'acme_')){?>
	<h5 class="font_error"><?php echo lang('ATENÇÃO! Prossiga com cautela. Este é um módulo interno e para o funcionamento do restante do sistema é importante que ele esteja íntegro, isto é, em sua versão original.')?></h5>
	<?php } ?>
	<?php if(stristr(get_value($module, 'controller'), 'acme_') && !$manage_acme_modules_permission){?>
	<h5 class="font_error"><?php echo lang('Atualmente você não possui permissões para alterar dados de um módulo interno. Para poder alterar dados deste módulo você deve ir até o módulo de usuários e aplicar a permissão <em>manage_acme_modules</em> para o seu usuário.')?></h5>
	<?php } ?>
	
	<br />
	<h5 class="font_shadow_gray inline top"><?php echo lang('Dados do Módulo') ?></h5>
	<div class="inline top font_11" style="margin:10px 0 0 10px"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Editar Dados do Módulo')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_module_data/<?php echo get_value($module, 'id_module') ?>', '', 800, 600)"><?php echo lang('Editar Dados') ?></a></div>
	<hr style="margin-bottom:5px" />
	<div id="box_group_view">
		<div>
			<div id="label_view"><?php echo lang('Imagem do Módulo') ?></div>
			<div id="field_view">
			<?php if(get_value($module, 'url_img') != ''){ ?>
			<img src="<?php echo eval_replace(get_value($module, 'url_img'));?>" style="max-width:48px;" />
			<?php } ?>			
			</div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('ID (#)') ?></div>
			<div id="field_view"><?php echo get_value($module, 'id_module') ?></div>
		</div>
		<div>
			<div id="label_view"><?php echo lang('Rótulo do Módulo') ?></div>
			<div id="field_view"><?php echo lang(get_value($module, 'lang_key_rotule')) ?></div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('Tabela') ?></div>
			<div id="field_view"><?php echo get_value($module, 'table') ?></div>
		</div>
		<div>
			<div id="label_view"><?php echo lang('Controlador') ?></div>
			<div id="field_view"><?php echo lang(get_value($module, 'controller')) ?></div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('SQL de Listagem') ?></div>
			<div id="field_view" style="max-width:2000px;min-width:300px;">
				<?php if(strlen(get_value($module, 'sql_list')) > 100) { ?>
				<div>
					<?php echo substr(get_value($module, 'sql_list'), 0, 50) . '...' ?>
					<a href="javascript:void(0);" onclick="show_area('sql_list_module')"><?php echo lang('Exibir SQL Completo') ?></a>
					<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" />
				</div>
				<div class="font_11" id="sql_list_module" style="margin-top:5px;display:none;"><pre><?php echo get_value($module, 'sql_list'); ?></pre></div>
				<?php } else { ?>
				<div class="font_11" style="margin-top:5px;"><pre><?php echo get_value($module, 'sql_list'); ?></pre></div>
				<?php } ?>
			</div>
		</div>
		<div>
			<div id="label_view"><?php echo lang('Qtde. de Itens por Página') ?></div>
			<div id="field_view" style="max-width:2000px;min-width:300px;"><?php echo lang(get_value($module, 'items_per_page')) ?><span class="font_11 comment">&nbsp;&nbsp;&nbsp;<?php echo lang('A quantidade de itens por página influencia na quantidade de registros que a consulta do módulo (<strong>SQL de Listagem</strong>) reproduz') ?></span></div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('Ativo') ?></div>
			<div id="field_view" style="padding-top:3px">
				<h6 class="inline top <?php echo (get_value($module, 'dtt_inative') == '') ? 'font_success' : 'font_error' ?>"><?php echo (get_value($module, 'dtt_inative') == '') ? lang('Sim') : lang('Não') ?></h6>
				<div class="inline top font_11 comment" style="margin-top:5px;">&nbsp;&nbsp;<?php echo lang('Estar ativo ou não influencia na visibilidade deste módulo em combos, listagens, acessos, etc.') ?></div>
			</div>
		</div>
		<div>
			<div id="label_view"><?php echo lang('Arquivos deste Módulo (MVC)') ?></div>
			<div id="field_view" class="font_11">
				<strong>controller:</strong>&nbsp;&nbsp;application/controllers/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ? 'acme/' : '';?><?php echo get_value($module, 'controller') ?>.php
				<br />
				<strong>model:</strong>&nbsp;&nbsp;application/models/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ? 'acme/' : '';?><?php echo get_value($module, 'controller') ?>_model.php
				<br />
				<strong>view:</strong>&nbsp;&nbsp;application/views/<?php echo TEMPLATE ?>/<?php echo (stristr(get_value($module, 'controller'), 'acme_')) ?  '_acme/' : '' ?><?php echo get_value($module, 'controller') ?>/<span class="comment">&nbsp;&nbsp;&nbsp;<?php echo lang('(Diretório)')?></span>
				<br />
				<br />
				<strong><?php echo lang('Arquivo de definição deste módulo (.ini)')?>:</strong>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Arquivo de Definição de Módulo')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_view_module_ini_file/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_view.png', 700, 600)"><?php echo lang('Visualizar') ?></a>
			</div>
		</div>
	</div>
	
	<br />
	<br />
	<br />
	<h5 class="font_shadow_gray inline top"><?php echo lang('Permissões Deste Módulo') ?></h5>
	<div class="inline top font_11" style="margin:10px 0 0 10px"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Adicionar Permissão')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_permission_new/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_insert.png', 700, 600)"><?php echo lang('Adicionar Permissão') ?></a></div>
	<hr />
	<div id="load_module_permissions"></div>
	
	<br />
	<br />
	<br />
	<h5 class="font_shadow_gray inline top"><?php echo lang('Ações de Registros Deste Módulo') ?></h5>
	<div class="inline top font_11" style="margin:10px 0 0 10px"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Adicionar Ação de Registro')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_action_new/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_insert.png', 700, 600)"><?php echo lang('Adicionar Ação de Registro') ?></a></div>
	<hr />
	<div id="load_module_actions"></div>
	
	<br />
	<br />
	<br />
	<h5 class="font_shadow_gray inline top"><?php echo lang('Menus Deste Módulo') ?></h5>
	<div class="inline top font_11" style="margin:10px 0 0 10px"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Adicionar Menu')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_module_menu_new/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_insert.png', 700, 600)"><?php echo lang('Adicionar Menu') ?></a></div>
	<hr />
	<div id="load_module_menus"></div>
	
	<br />
	<br />
	<br />
	<h5 class="font_shadow_gray inline top"><?php echo lang('Formulários Deste Módulo') ?></h5>
	<hr />
	<!-- ABAS DE FORMULARIOS -->
	<br />
	<br />
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_filter"><?php echo lang('Formulário de Filtros') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_insert"><?php echo lang('Formulário de Inserção') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_update"><?php echo lang('Formulário de Edição') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_delete"><?php echo lang('Formulário de Deleção') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_view"  ><?php echo lang('Formulário de Visualização') ?></div>
	
	<!-- BOX DE CONFIGS DE FORMS -->
	<div class="box_config_form" id="box_form_filter"></div>
	<div class="box_config_form" id="box_form_insert"></div>
	<div class="box_config_form" id="box_form_update"></div>
	<div class="box_config_form" id="box_form_delete"></div>
	<div class="box_config_form" id="box_form_view"  ></div>
	
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo URL_ROOT . '/' . $this->controller ?>'"><?php echo lang('ok')?></button></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>">voltar</a></div>
	</div>
</div>