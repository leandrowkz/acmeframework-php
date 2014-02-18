<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		enable_form_validations();
		enable_masks();
	});		
</script>

<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Tarefas'); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Deletar Tarefa')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Deletar Tarefa') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>

		</div>
	</div>
	
	<!-- DESCRICAO DO FORMULARIO (MSG) -->
	<?php echo message('warning', lang('ATENÇÃO!'), lang('A tarefa que está sendo visualizada será deletada. Para confirmar esta ação clique em ok, para desistir clique em cancelar.'), false, 'margin:25px 0 10px 0;') ?>
	
	<!-- FORMULARIO -->
	<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/task/form_delete_process" method="post">
		<input type="hidden" name="id_task" id="id_task" value="<?php echo get_value($task, 'id_task'); ?>" />
		<input type="hidden" name="url_redirect" id="url_redirect" value="<?php echo $url_redirect ?>" />
		<br />
		<div id="box_group_view">
			<img src="<?php echo URL_IMG ?>/icon_bullet_priority_<?php echo get_value($task, 'priority')?>.png" style="float:right;margin:7px 7px 0 0" title="<?php echo lang('Prioridade') . ': ' . get_value($task, 'priority'); ?>" />
			<div>
				<div id="label_view"><?php echo lang('Projeto/Atividade') ?></div>
				<div id="field_view" class="font_blue"><h6 style="margin-top:0px;"><?php echo get_value($activity, 'project_title'); ?> > <?php echo get_value($activity, 'title'); ?></h6></div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Título da tarefa') ?></div>
				<div id="field_view"><?php echo lang(get_value($task, 'title')) ?></div>
			</div>
			<div>
				<div id="label_view"><?php echo lang('Descrição') ?></div>
				<div id="field_view"><?php echo character_limiter(get_value($task, 'description'), 100) ?></div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Usuário responsável') ?></div>
				<div id="field_view"><?php echo get_value($task, 'login_responsible') ?></div>
			</div>
			<div>
				<div id="label_view"><?php echo lang('Usuário executor') ?></div>
				<div id="field_view"><?php echo get_value($task, 'login_executor') ?></div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Criada em') ?></div>
				<div id="field_view"><?php echo to_human_date(get_value($task, 'log_dtt_ins')) ?></div>
			</div>
		</div>
		
		<div style="margin:30px 0 0 1px">
			<div class="inline top font_11 bold" style="width:15px !important"><input type="checkbox" name="confirm" id="confirm" class="validate[required]" /></div>
			<div class="inline top font_11" style="width:400px"><label for="confirm"><?php echo lang('OK, quero deletar esta tarefa e todo seu histórico vinculado.')?></label></div>
		</div>
		
		<div style="margin-top:30px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('OK')?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="redirect('<?php echo URL_ROOT . $url_redirect?>');"><?php echo lang('cancelar') ?></a></div>
		</div>
	</form>
</div>
