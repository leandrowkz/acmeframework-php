<?php if($table != '') {?>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Tabela de campos
		ajax_load_box_config_form_fields('insert', <?php echo $id_module ?>);
	});
</script>
<div>
	<h6 class="font_error"><?php echo lang('ATENÇÃO! Ações realizadas nas caixas de seleção (marcar/desmarcar) são executadas em tempo real.') ?></h6>
	<br />
	<br />
	<h5><?php echo lang('Formulário de Inserção') ?></h5>
	<hr />
	<div style="line-height:20px;margin-top:5px;">
		<div id="box_group_view">
			<div>
				<div id="label_view"><?php echo lang('Instruções') ?></div>
				<div id="field_view" style="max-width:2000px;min-width:300px;">
					<div>
						<a href="javascript:void(0);" onclick="show_area('instrucoes_form_insert')"><?php echo lang('Exibir Instruções') ?></a>
						<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" />
					</div>
					<div class="font_11" id="instrucoes_form_insert" style="display:none;">					
						<div><?php echo lang('1) Marque ou desmarque a opção de uso deste formulário para ativá-lo ou não, utilizando o checkbox da coluna <strong>Situação Geral</strong>.') ?></div>
						<div><?php echo lang('2) Altere as propriedades do formulário clicando no link <strong>Exibir Detalhes</strong>, também na coluna <strong>Situação Geral</strong>.') ?> </div>
						<div><?php echo lang('3) Vincule um menu de módulo que aponta seu link para este formulário, selecionando o checkbox de uso na coluna <strong>Menu Vinculado</strong>.') ?> </div>
						<div><?php echo lang('4) Altere os dados do link, caso seja necessário, clicando no link <strong>Exibir Detalhes</strong> também localizado na coluna <strong>Menu Vinculado</strong>.') ?> </div>
						<div><?php echo lang('5) Habilite os campos que este formulário possuirá. Estes campos estão localizados na seção <strong>Campos do Formulário</strong>.') ?> </div>
						<br />
						<div><?php echo lang('<strong>Observações e outras considerações:</strong>') ?></div>
						<div><?php echo lang('&bull;&nbsp;Este formulário é exibido quando um menu do módulo apontar seu link para') . ' <strong>' . $controller . '/form/insert</strong>.'?></div>
						<div><?php echo lang('&bull;&nbsp;A ação básica deste formulário é inserir um registro na tabela do módulo selecionado (tabela: ') . ' <strong>' . $table . '</strong>).' ?></div>
						<div><?php echo lang('&bull;&nbsp;O processamento deste formulário é automático. O sistema automaticamente sabe como processar cada operação, portanto o <strong>action</strong> padrão do formulário sempre será vazio.') ?></div>
						<div><?php echo lang('&bull;&nbsp;Você pode customizar o processamento do formulário a seu bem entender. Para isso altere as propriedades do formulário, clicando no link <strong>Exibir Detalhes</strong> da coluna <strong>Situação Geral</strong>.');?></div>
						<div><?php echo lang('&bull;&nbsp;Para campos que sejam chave primária (PK), caso estejam com <strong>AUTO_INCREMENT</strong> habilitado recomendamos não ativá-lo nos formulários de inserção e edição. É para sua própria segurança.');?></div>
					</div>
				</div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Dados do Módulo') ?></div>
				<div id="field_view" class="font_11">
					<div><a href="javascript:void(0)" onclick="show_area('dados_modulo_form_insert')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="dados_modulo_form_insert" style="display:none;">
						<div><strong><?php echo lang('Nome') ?>: </strong><?php echo get_value($module, 'lang_key_rotule') ?></div>
						<div><strong><?php echo lang('Controlador') ?>: </strong><?php echo get_value($module, 'controller') ?> <span class="comment">(<?php echo get_value($module, 'controller') ?>.php)</span></div>
						<div><strong><?php echo lang('Tabela') ?>: </strong><?php echo get_value($module, 'table') ?></div>
					</div>
				</div>
			</div>
			<div>
				<div id="label_view" style="margin-top:3px;"><?php echo lang('Situação Geral') ?></div>
				<div id="field_view" class="top">
					<input type="hidden" id="lang_status_form_insert_enable" value="<?php echo lang('Habilitado') ?>"/>
					<input type="hidden" id="lang_status_form_insert_disable" value="<?php echo lang('Desabilitado') ?>"/>
					<div class="inline top" style="margin:4px 2px 0 0"><input type="checkbox" id="checkbox_form_insert" onclick="ajax_set_config_form('insert', <?php echo $id_module?>)" style="margin-top:2px;" <?php echo (get_value($form, 'dtt_inative') != '' || count($form) <= 0) ? '' : 'checked="checked"'; ?>  /></div>
					<?php if(get_value($form, 'dtt_inative') != '' || count($form) <= 0){?>
					<h6 id="status_form_insert" class="inline top font_error"><?php echo lang('Desabilitado') ?></h6>
					<?php } else { ?>
					<h6 id="status_form_insert" class="inline top font_success"><?php echo lang('Habilitado') ?></h6>
					<?php } ?>
					<div class="inline top font_11" style="margin:3px 0 0 5px;"><a href="javascript:void(0)" onclick="show_area('detalhes_form_insert')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="detalhes_form_insert" style="display:none">
						<div class="font_11">
							<div><strong><?php echo lang('operação') ?>:</strong> <?php echo get_value($form, 'operation') ?></div>
							<div><strong><?php echo lang('action') ?>:</strong> <?php echo (get_value($form, 'action') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : htmlentities(get_value($form, 'action')) ?></div>
							<div><strong><?php echo lang('method') ?>:</strong> <?php echo (get_value($form, 'method') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($form, 'method') ?></div>
							<div><strong><?php echo lang('enctype') ?>:</strong> <?php echo (get_value($form, 'enctype') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($form, 'enctype') ?></div>
							<div><a href="javascript:void(0);" onclick="iframe_modal('<?php echo lang('Edição de dados do Formulário')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_form_data/<?php echo get_value($form, 'id_module_form') ?>', '<?php echo URL_IMG ?>/icon_update.png', 700, 520)"><?php echo lang('Editar dados do Formulário')?></a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="odd">
				<div id="label_view" style="margin-top:3px;"><?php echo lang('Menu Vinculado') ?></div>
				<div id="field_view" class="top">
					<input type="hidden" id="lang_status_menu_insert_enable" value="<?php echo lang('Sim') ?>" />
					<input type="hidden" id="lang_status_menu_insert_disable" value="<?php echo lang('Não') ?>" />
					<div class="inline top" style="margin:4px 2px 0 0"><input type="checkbox" id="checkbox_menu_insert" onclick="ajax_set_config_menu_insert(<?php echo $id_module?>)" style="margin-top:2px;" <?php echo (get_value($menu, 'dtt_inative') != '' || count($menu) <= 0) ? '' : 'checked="checked"'; ?>  /></div>
					<?php if(get_value($menu, 'dtt_inative') != '' || count($menu) <= 0){?>
					<h6 id="status_menu_insert" class="font_error inline top"><?php echo lang('Não') ?></h6>
					<?php } else { ?>
					<h6 id="status_menu_insert" class="font_success inline top"><?php echo lang('Sim') ?></h6>
					<?php } ?>
					<div class="inline top font_11" style="margin:3px 0 0 5px;"><a href="javascript:void(0)" onclick="show_area('detalhes_menu_insert')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="detalhes_menu_insert" style="display:none">
						<div class="font_11">
							<div class="comment"><?php echo lang('(Um menu de módulo é vinculado a este formulário, através do apontamento de seu link para a url deste).') ?></div>
							<div><strong><?php echo lang('rótulo de exibição') ?>:</strong> <?php echo (get_value($menu, 'lang_key_rotule') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($menu, 'lang_key_rotule') ?></div>
							<div><strong><?php echo lang('link') ?>:</strong> <?php echo (get_value($menu, 'link') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : htmlentities(get_value($menu, 'link')) ?></div>
							<div><strong><?php echo lang('target') ?>:</strong> <?php echo (get_value($menu, 'target') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($menu, 'target') ?></div>
							<div><strong><?php echo lang('description') ?>:</strong> <?php echo (get_value($menu, 'description') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($menu, 'description') ?></div>
							<div><a href="javascript:void(0);" onclick="iframe_modal('<?php echo lang('Edição de dados do Menu')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_menu_insert/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_update.png', 700, 480)"><?php echo lang('Editar dados do Menu')?></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<br />
	<br />
	<br />
	<h5><?php echo lang('Campos do Formulário') ?></h5>
	<hr />
	<div id="box_table_form_fields_insert"></div>
	<br />

</div>
<?php } else { ?>
<div><?php echo message('warning', lang('Atenção!'), lang('O módulo selecionado não possui uma tabela ou a tabela informada não é válida. Altere as propriedades do módulo informando a tabela corretamente e tente novamente.')) ?></div>
<?php } ?>