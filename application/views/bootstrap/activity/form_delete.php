<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		enable_form_validations();
		enable_masks();
	});		
</script>
<style type="text/css">
	.line-task-dependencie {
		padding:5px 3px;
		background-color:#f5f5f5;
		border-bottom:1px solid #ccc;
		cursor:pointer;
	}
	
	.line-task-dependencie:hover {
		background-color:#f9f9f9;
		border-bottom:1px solid #ddd;
	}
	
	.line-task-dependencie:first-child {
		border-top:1px solid #ccc !important;
	}
</style>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo $this->lang_key_rotule; ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Deletar Atividade')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Deletar Atividade') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>

		</div>
	</div>
	
	<!-- DESCRICAO DO FORMULARIO (MSG) -->
	<?php echo message('warning', lang('ATENÇÃO!'), lang('A atividade que está sendo visualizada será deletada. Para confirmar esta ação clique em ok, para desistir clique em cancelar.'), false, 'margin:25px 0 10px 0') ?>
	
	<!-- FORMULARIO -->
	<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/activity/form_delete_process" method="post">
		<input type="hidden" name="id_activity" id="id_activity" value="<?php echo get_value($activity, 'id_activity'); ?>" />
		<input type="hidden" name="url_redirect" id="url_redirect" value="<?php echo $url_redirect ?>" />
		<br />
		<div id="box_group_view">
			<div class="odd">
				<div id="label_view"><?php echo lang('Projeto') ?></div>
				<div id="field_view"><?php echo get_value($activity, 'project_title') ?></div>
			</div>
			<div>
				<div id="label_view"><?php echo lang('Título da atividade') ?></div>
				<div id="field_view"><?php echo lang(get_value($activity, 'title')) ?></div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Descrição') ?></div>
				<div id="field_view"><?php echo character_limiter(get_value($activity, 'description'), 100) ?></div>
			</div>
			<div>
				<div id="label_view"><?php echo lang('Criado por') ?></div>
				<div id="field_view"><?php echo get_value($activity, 'login') ?></div>
			</div>
			<div class="odd">
				<div id="label_view"><?php echo lang('Criado em') ?></div>
				<div id="field_view"><?php echo to_human_date(get_value($activity, 'log_dtt_ins')) ?></div>
			</div>
		</div>
		
		<?php if(count($tasks) > 0) {?>
		<div style="margin:30px 0 20px 0;line-height:20px">
			<div class="font_11"><?php echo message('error', '', '<span class="bold">' . lang('ATENÇÃO!') . '</span> ' . lang('Esta atividade possui tarefas vinculadas. Deletar esta atividade implica na remoção de todas suas tarefas. Se você tem certeza disso, confirme a deleção logo mais abaixo.') . '') ?></div>
			<div class="bold" style="margin-top:20px;border-bottom:1px solid #ccc"><h6><?php echo lang('Tarefas desta atividade')?></h6></div>
			<?php 
			foreach($tasks as $task) { 
			$percentage_task = $this->task_lib->used_time_percentage(get_value($task, 'id_task'));
			$total_time_spended = $this->task_lib->total_time_history(get_value($task, 'id_task'));
			$delayed = ($this->task_lib->is_task_delayed(get_value($task, 'id_task'))) ? true : false;
			?>
			<div class="line-task-dependencie font_11" onclick="show_area('box-content-task-<?php echo get_value($task, 'id_task') ?>')">
				<img src="<?php echo URL_IMG ?>/icon_bullet_plus.png" style="float:left;margin:2px 2px 0 0" id="box-content-task-<?php echo get_value($task, 'id_task') ?>_img" />
				<div style="color:#555;float:right">(<?php echo lang('Será deletada')?>)</div>
				<div class="bold"><?php echo get_value($task, 'title') ?></div>
				<div id="box-content-task-<?php echo get_value($task, 'id_task') ?>" style="display:none;padding-left:18px">
					<div><?php echo character_limiter(get_value($task, 'description'), 200) ?></div>
					<div><strong><?php echo lang('Situação')?>: </strong> <?php echo get_value($task, 'situation')?></div>
					<div><strong><?php echo lang('Estimativa em horas')?>: </strong> <?php echo substr(get_value($task, 'estimate'), 0, 5)?> <?php echo lang('horas')?></div>
					<div><strong><?php echo lang('Tempo utilizado')?>: </strong> <?php echo substr($total_time_spended, 0, 5); ?> <?php echo lang('horas')?> (<strong style="cursor:default;" title="<?php echo $percentage_task . '% ' . lang('do tempo estimado') ?>"><?php echo $percentage_task ?>%</strong>)</div>
					<div <?php echo ($delayed && strtolower(get_value($task, 'situation')) == 'aberta') ? 'style="color:#B22222"' : ''?>><strong><?php echo lang('Inicia em')?>: </strong> <?php echo to_human_date(get_value($task, 'ini_prev'))?></div>
					<div><strong><?php echo lang('Previsão de término')?>: </strong> <?php echo to_human_date(get_value($task, 'end_prev'))?></div>
					<div><strong><?php echo lang('Usuário responsável')?>: </strong> <?php echo get_value($task, 'login_responsible'); ?></div>
					<div><strong><?php echo lang('Usuário executor')?>: </strong> <?php echo get_value($task, 'login_executor'); ?></div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<div style="margin:30px 0 0 1px">
			<div class="inline top font_11 bold" style="width:15px !important"><input type="checkbox" name="confirm" id="confirm" class="validate[required]" /></div>
			<div class="inline top font_11" style="width:400px"><label for="confirm"><?php echo lang('OK, quero deletar esta atividade e suas tarefas vinculadas.')?></label></div>
		</div>
		
		<div style="margin-top:30px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('OK')?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="redirect('<?php echo URL_ROOT . $url_redirect?>');"><?php echo lang('cancelar') ?></a></div>
		</div>
	</form>
</div>
