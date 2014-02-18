<?php if($table != '') {?>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Tabela de campos
		ajax_load_box_config_form_fields('update', <?php echo $id_module ?>);
	});
</script>
<div>
	<h6 class="font_error"><?php echo lang('ATENÇÃO! Ações realizadas nas caixas de seleção (marcar/desmarcar) são executadas em tempo real.') ?></h6>
	<br />
	<br />
	<h5><?php echo lang('Formulário de Edição') ?></h5>
	<hr />
	<div style="line-height:20px;margin-top:5px;">
		<div id="box_group_view">
			<div>
				<div id="label_view"><?php echo lang('Instruções') ?></div>
				<div id="field_view" style="max-width:2000px;min-width:300px;">
					<div>
						<a href="javascript:void(0);" onclick="show_area('instrucoes_form_update')"><?php echo lang('Exibir Instruções') ?></a>
						<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" />
					</div>
					<div class="font_11" id="instrucoes_form_update" style="display:none;">					
						<div><?php echo lang('1) Marque ou desmarque a opção de uso deste formulário para ativá-lo ou não, utilizando o checkbox da coluna <strong>Situação Geral</strong>.') ?></div>
						<div><?php echo lang('2) Altere as propriedades do formulário clicando no link <strong>Exibir Detalhes</strong>, também na coluna <strong>Situação Geral</strong>.') ?> </div>
						<div><?php echo lang('3) Vincule uma ação de registro da listagem do módulo com este formulário, selecionando o checkbox de uso na coluna <strong>Ação de Registro Vinculada</strong>.') ?> </div>
						<div><?php echo lang('4) Altere os dados da ação de registro vinculada, caso seja necessário, clicando no link <strong>Exibir Detalhes</strong> também localizado na coluna <strong>Ação de Registro Vinculada</strong>.') ?> </div>
						<div><?php echo lang('5) Habilite os campos que este formulário possuirá. Estes campos estão localizados na seção <strong>Campos do Formulário</strong>.') ?> </div>
						<br />
						<div><?php echo lang('<strong>Observações e outras considerações:</strong>') ?></div>
						<div><?php echo lang('&bull;&nbsp;Este formulário é exibido quando uma ação de registro da listagem do módulo apontar seu link e sua chave primária para') . ' <strong>' . $controller . '/form/update/{VALOR_CHAVE_PRIMARIA_DO_REGISTRO}</strong>.'?></div>
						<div><?php echo lang('&bull;&nbsp;A ação básica deste formulário é permitir a edição de um registro da tabela do módulo selecionado (tabela: ') . ' <strong>' . $table . '</strong>).' ?></div>
						<div><?php echo lang('&bull;&nbsp;O processamento deste formulário é automático. O sistema automaticamente sabe como processar cada operação, portanto o <strong>action</strong> padrão do formulário sempre será vazio.') ?></div>
						<div><?php echo lang('&bull;&nbsp;Você pode customizar o processamento do formulário a seu bem entender. Para isso altere as propriedades do formulário, clicando no link <strong>Exibir Detalhes</strong> da coluna <strong>Situação Geral</strong>.');?></div>
						<div><?php echo lang('&bull;&nbsp;Para campos que sejam chave primária (PK), caso estejam com <strong>AUTO_INCREMENT</strong> habilitado recomendamos não ativá-lo nos formulários de inserção e edição. É para sua própria segurança.');?></div>
					</div>
				</div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Dados do Módulo') ?></div>
				<div id="field_view" class="font_11">
					<div><a href="javascript:void(0)" onclick="show_area('dados_modulo_form_update')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="dados_modulo_form_update" style="display:none;">
						<div><strong><?php echo lang('Nome') ?>: </strong><?php echo get_value($module, 'lang_key_rotule') ?></div>
						<div><strong><?php echo lang('Controlador') ?>: </strong><?php echo get_value($module, 'controller') ?> <span class="comment">(<?php echo get_value($module, 'controller') ?>.php)</span></div>
						<div><strong><?php echo lang('Tabela') ?>: </strong><?php echo get_value($module, 'table') ?></div>
					</div>
				</div>
			</div>
			<div>
				<div id="label_view" style="margin-top:3px;"><?php echo lang('Situação Geral') ?></div>
				<div id="field_view" class="top">
					<input type="hidden" id="lang_status_form_update_enable" value="<?php echo lang('Habilitado') ?>"/>
					<input type="hidden" id="lang_status_form_update_disable" value="<?php echo lang('Desabilitado') ?>"/>
					<div class="inline top" style="margin:4px 2px 0 0"><input type="checkbox" id="checkbox_form_update" onclick="ajax_set_config_form('update', <?php echo $id_module?>)" style="margin-top:2px;" <?php echo (get_value($form, 'dtt_inative') != '' || count($form) <= 0) ? '' : 'checked="checked"'; ?>  /></div>
					<?php if(get_value($form, 'dtt_inative') != '' || count($form) <= 0){?>
					<h6 id="status_form_update" class="inline top font_error"><?php echo lang('Desabilitado') ?></h6>
					<?php } else { ?>
					<h6 id="status_form_update" class="inline top font_success"><?php echo lang('Habilitado') ?></h6>
					<?php } ?>
					<div class="inline top font_11" style="margin:3px 0 0 5px;"><a href="javascript:void(0)" onclick="show_area('detalhes_form_update')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="detalhes_form_update" style="display:none">
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
				<div id="label_view" style="margin-top:3px;"><?php echo lang('Ação de Registro Vinculada') ?></div>
				<div id="field_view" class="top">
					<input type="hidden" id="lang_status_action_update_enable" value="<?php echo lang('Sim') ?>" />
					<input type="hidden" id="lang_status_action_update_disable" value="<?php echo lang('Não') ?>" />
					<div class="inline top" style="margin:4px 2px 0 0"><input type="checkbox" id="checkbox_action_update" onclick="ajax_set_config_action('update', <?php echo $id_module?>)" style="margin-top:2px;" <?php echo (get_value($action, 'dtt_inative') != '' || count($action) <= 0) ? '' : 'checked="checked"'; ?>  /></div>
					<?php if(get_value($action, 'dtt_inative') != '' || count($action) <= 0){?>
					<h6 id="status_action_update" class="font_error inline top"><?php echo lang('Não') ?></h6>
					<?php } else { ?>
					<h6 id="status_action_update" class="font_success inline top"><?php echo lang('Sim') ?></h6>
					<?php } ?>
					<div class="inline top font_11" style="margin:3px 0 0 5px;"><a href="javascript:void(0)" onclick="show_area('detalhes_action_update')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="detalhes_action_update" style="display:none">
						<div class="font_11">
							<div class="comment"><?php echo lang('(Uma ação de registro da lista do módulo é vinculada a este formulário, através do apontamento de seu link para a url deste).') ?></div>
							<div><strong><?php echo lang('nome') ?>:</strong> <?php echo get_value($action, 'lang_key_rotule') ?></div>
							<div><strong><?php echo lang('link') ?>:</strong> <?php echo (get_value($action, 'link') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : htmlentities(get_value($action, 'link')) ?></div>
							<div><strong><?php echo lang('url_img') ?>:</strong> <?php echo (get_value($action, 'url_img') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : htmlentities(get_value($action, 'url_img')) ?></div>
							<div><strong><?php echo lang('target') ?>:</strong> <?php echo (get_value($action, 'target') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($action, 'target') ?></div>
							<div><strong><?php echo lang('description') ?>:</strong> <?php echo (get_value($action, 'description') == '') ? '<span class="comment">' . lang('(Padrão)') . '</span>' : get_value($action, 'description') ?></div>
							<div><a href="javascript:void(0);" onclick="iframe_modal('<?php echo lang('Edição de dados da Ação')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_action/update/<?php echo get_value($module, 'id_module') ?>', '<?php echo URL_IMG ?>/icon_update.png', 700, 480)"><?php echo lang('Editar dados da Ação')?></a></div>
						</div>
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
	<div id="box_table_form_fields_update"></div>
	<br />

</div>
<?php } else { ?>
<div><?php echo message('warning', lang('Atenção!'), lang('O módulo selecionado não possui uma tabela ou a tabela informada não é válida. Altere as propriedades do módulo informando a tabela corretamente e tente novamente.')) ?></div>
<?php } ?>
