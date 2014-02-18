<?php if(count($fields) > 0) { ?>
<div style="line-height:25px;margin-top:5px;">
	<?php if($disabled != '') {?>
	<div class="font_12 font_red bold"><?php echo lang('ATENÇÃO! Os campos deste formulário não podem ser alterados pois o formulário <u>não</u> está em uso. Habilite o formulário para que seus campos possam ser editáveis.') ?></div>
	<?php } ?>
	<div><?php echo lang('Marque ou desmarque as caixas dos campos que deverão aparecer no formulário de inserção do módulo. Utilize o ícone de edição a esquerda para editar os dados do campo selecionado.') ?></div>
</div>
<table class="table_sorter" style="margin-top:10px;">
<thead>
	<tr>
		<th><!--input type="checkbox" id="checbox_form_fields_check_all_<?php echo $operation ?>" onclick="check_all_form_fields('<?php echo $operation ?>', <?php echo get_value($form, 'id_module_form') ?>, <?php echo get_value($form, 'id_module') ?>);" <?php echo $disabled ?> /--></th>
		<th></th>
		<th></th>
		<th><?php echo lang('Coluna (Tabela)') ?></th>
		<th><?php echo lang('Rótulo de Exibição') ?></th>
		<th><?php echo lang('Tipo') ?></th>
		<th><?php echo lang('ID HTML') ?></th>
		<th><?php echo lang('Maxlength') ?></th>
		<th><?php echo lang('Validações') ?></th>
		<th><?php echo lang('Ordem') ?></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php foreach($fields as $field) { ?>
	<tr class="<?php echo $class_disabled; ?><?php echo ((get_value($field, 'column_key') == 'PRI' || get_value($field, 'column_not_exists') == 'Y') && $class_disabled == '' && $operation != 'filter') ? ' warning' : ''; ?>" id="line_form_field_<?php echo $operation . '_' . get_value($field, 'column_name') ?>">
		<td style="width:01%;vertical-align:top"><input type="checkbox" id="checkbox_form_field_<?php echo $operation; ?>_<?php echo get_value($field, 'column_name') ?>" <?php echo get_value($field, 'checked') ?> value="<?php echo get_value($field, 'column_name') ?>" onclick="ajax_set_config_form_field('<?php echo get_value($field, 'column_name') ?>', '<?php echo $operation ?>', <?php echo get_value($form, 'id_module_form') ?>, <?php echo get_value($form, 'id_module') ?>)" <?php echo $disabled ?> style="margin-top:2px;" /></td>
		<td style="width:01%;vertical-align:top">
			<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Edição de Campo')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_form_field/<?php echo get_value($field, 'id_module_form_field') ?>', '<?php echo URL_IMG ?>/icon_update.png', 700, 600)">
			<img src="<?php echo URL_IMG ?>/icon_update.png" />
			</a>
		</td>
		<td style="width:01%;vertical-align:top">
			<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Deleção de Campo')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_delete_form_field/<?php echo get_value($field, 'id_module_form_field') ?>', '<?php echo URL_IMG ?>/icon_delete.png', 700, 480)">
			<img src="<?php echo URL_IMG ?>/icon_delete.png" />
			</a>
		</td>
		<td><?php echo get_value($field, 'column_name') ?></td>
		<td><?php echo get_value($field, 'rotule') ?></td>
		<td><?php echo get_value($field, 'type') ?></td>
		<td><?php echo get_value($field, 'id_html') ?></td>
		<td><?php echo get_value($field, 'maxlength') ?></td>
		<td><?php echo get_value($field, 'validations') ?></td>
		<td><?php echo get_value($field, 'order') ?></td>
		<td style="width:01%">
		<?php if(get_value($field, 'description') != '') { ?>
			<img src="<?php echo URL_IMG ?>/icon_description.png" title="<?php echo get_value($field, 'description') ?>" />
		<?php } ?>
		</td>
		<td style="width:01%">
		<?php if(get_value($field, 'column_key') == 'PRI' && $operation != 'filter') { ?>
			<img src="<?php echo URL_IMG ?>/icon_warning.png" title="<?php echo lang('Este campo parece ser uma chave primária. Caso esteja com AUTO INCREMENT habilitado, recomendamos severamente a não ativá-lo nos formulários de inserção e edição.')?>" /></td>
		<?php } else if(get_value($field, 'column_not_exists') == 'Y' && $operation != 'filter') { ?>
			<img src="<?php echo URL_IMG ?>/icon_warning.png" title="<?php echo lang('Este campo possui um nome de coluna inexistente na tabela do módulo. Recomendamos que você inative seu uso ou remova-o.')?>" /></td>
		<?php } ?>
		<td style="width:01%"><img id="img_success_form_field_<?php echo $operation . '_' . get_value($field, 'column_name') ?>" src="<?php echo URL_IMG ?>/icon_success.png" style="display:none" /></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php } else { ?>
<?php echo message('info', lang('Nenhum Campo'), lang('Este formulário não possui nenhum campo cadastrado. Para inserir um novo campo para este formulário, clique no link <strong>Novo Campo</strong>, acima.'))?>
<?php } ?>