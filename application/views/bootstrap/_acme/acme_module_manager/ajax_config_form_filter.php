<?php if(get_value($module, 'sql_list') != '') {?>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Tabela de campos
		ajax_load_box_config_form_fields('filter', <?php echo $id_module ?>);
	});
</script>
<div>
	<h6 class="font_error"><?php echo lang('ATENÇÃO! Ações realizadas nas caixas de seleção (marcar/desmarcar) são executadas em tempo real.') ?></h6>
	<br />
	<br />
	<h5><?php echo lang('Formulário de Filtros') ?></h5>
	<hr />
	<div style="line-height:20px;margin-top:5px;">
		<div id="box_group_view">
			<div>
				<div id="label_view"><?php echo lang('Instruções') ?></div>
				<div id="field_view" style="max-width:2000px;min-width:300px;">
					<div>
						<a href="javascript:void(0);" onclick="show_area('instrucoes_form_filter')"><?php echo lang('Exibir Instruções') ?></a>
						<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" />
					</div>
					<div class="font_11" id="instrucoes_form_filter" style="display:none;">					
						<div><?php echo lang('1) Marque ou desmarque a opção de uso deste formulário para ativá-lo ou não, utilizando o checkbox da coluna <strong>Situação Geral</strong>.') ?></div>
						<div><?php echo lang('2) Altere as propriedades do formulário clicando no link <strong>Exibir Detalhes</strong>, também na coluna <strong>Situação Geral</strong>.') ?> </div>
						<div><?php echo lang('3) Habilite os campos que este formulário possuirá. Estes campos estão localizados na seção <strong>Campos do Formulário</strong> e referenciam a tabela do módulo (tabela: ') . ' <strong>' . $table . '</strong>).' ?> </div>
						<div><?php echo lang('4) Crie novos campos para este formulário caso seja necessário. A consulta do módulo pode possuir mais de uma tabela, necessitando a criação manual. Para isso utilize o link <strong>Novo Campo</strong>, ao lado do título da seção <strong>Campos do Formulário</strong>.') ?> </div>
						<br />
						<div><?php echo lang('<strong>Observações e outras considerações:</strong>') ?></div>
						<div><?php echo lang('&bull;&nbsp;Este formulário é exibido na listagem de entrada de um módulo.') ?></div>
						<div><?php echo lang('&bull;&nbsp;A ação básica deste formulário é filtrar a consulta de listagem do módulo selecionado.') ?></div>
						<div><?php echo lang('&bull;&nbsp;O processamento deste formulário é automático. O sistema automaticamente sabe como processar cada operação, portanto o <strong>action</strong> padrão do formulário sempre será vazio.') ?></div>
						<div><?php echo lang('&bull;&nbsp;Você pode customizar o processamento do formulário a seu bem entender. Para isso altere as propriedades do formulário, clicando no link <strong>Exibir Detalhes</strong> da coluna <strong>Situação Geral</strong>.');?></div>
						<div><?php echo lang('&bull;&nbsp;Para campos que sejam chave primária (PK), caso estejam com <strong>AUTO_INCREMENT</strong> habilitado recomendamos não ativá-lo nos formulários de inserção e edição. É para sua própria segurança.');?></div>
					</div>
				</div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Dados do Módulo') ?></div>
				<div id="field_view" class="font_11">
					<div><a href="javascript:void(0)" onclick="show_area('dados_modulo_form_filter')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="dados_modulo_form_filter" style="display:none;">
						<div><strong><?php echo lang('Nome') ?>: </strong><?php echo get_value($module, 'lang_key_rotule') ?></div>
						<div><strong><?php echo lang('Controlador') ?>: </strong><?php echo get_value($module, 'controller') ?> <span class="comment">(<?php echo get_value($module, 'controller') ?>.php)</span></div>
						<div><strong><?php echo lang('Tabela') ?>: </strong><?php echo get_value($module, 'table') ?></div>
					</div>
				</div>
			</div>
			<div>
				<div id="label_view" style="margin-top:3px;"><?php echo lang('Situação Geral') ?></div>
				<div id="field_view" class="top">
					<input type="hidden" id="lang_status_form_filter_enable" value="<?php echo lang('Habilitado') ?>"/>
					<input type="hidden" id="lang_status_form_filter_disable" value="<?php echo lang('Desabilitado') ?>"/>
					<div class="inline top" style="margin:4px 2px 0 0"><input type="checkbox" id="checkbox_form_filter" onclick="ajax_set_config_form('filter', <?php echo $id_module?>)" style="margin-top:2px;" <?php echo (get_value($form, 'dtt_inative') != '' || count($form) <= 0) ? '' : 'checked="checked"'; ?>  /></div>
					<?php if(get_value($form, 'dtt_inative') != '' || count($form) <= 0){?>
					<h6 id="status_form_filter" class="inline top font_error"><?php echo lang('Desabilitado') ?></h6>
					<?php } else { ?>
					<h6 id="status_form_filter" class="inline top font_success"><?php echo lang('Habilitado') ?></h6>
					<?php } ?>
					<div class="inline top font_11" style="margin:3px 0 0 5px;"><a href="javascript:void(0)" onclick="show_area('detalhes_form_filter')"><?php echo lang('Exibir Detalhes')?></a></div>
					<div id="detalhes_form_filter" style="display:none">
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
		</div>
	</div>
	
	
	<br />
	<br />
	<br />
	<h5 class="inline top"><?php echo lang('Campos do Formulário') ?></h5>
	<div class="inline top" style="margin:9px 0 0 5px;"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Novo Campo de Filtro')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_insert_form_field/<?php echo get_value($form, 'id_module_form') ?>', '<?php echo URL_IMG ?>/icon_insert.png', 700, 600)"><?php echo lang('Novo Campo de Filtro') ?></a></div>
	<hr />
	<div id="box_table_form_fields_filter"></div>
	<br />

</div>
<?php } else { ?>
<div><?php echo message('warning', lang('Atenção!'), lang('O módulo selecionado não possui uma consulta de listagem (SQL) ou a consulta informada não é válida. Altere as propriedades do módulo informando a consulta corretamente e tente novamente.')) ?></div>
<?php } ?>