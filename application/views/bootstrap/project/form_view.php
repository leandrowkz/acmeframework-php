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
		line-height:20px
	}
	
	.line-task-dependencie:hover {
		background-color:#f9f9f9;
		border-bottom:1px solid #ddd;
	}
	
	.line-task-dependencie:first-child {
		border-top:1px solid #ccc !important;
	}
	
	.box-project-activities {
		background-color:#fff;
		margin-top:5px;
		border:1px solid #777;
		min-height:50px;
		-moz-box-shadow:0 0 8px 1px #999;
		-webkit-box-shadow: 0 0 8px #999;
		box-shadow: 0px 0px 8px rgb(150,150,150);
		padding:0 15px 10px 15px;
	}
	
	.triangle-top-border {
		float:left;
		width: 0;
		height: 0;
		margin:-17px 0 0 40px;
		border-left: 12px solid transparent;
		border-right: 12px solid transparent;
		border-bottom: 17px solid #555;
	}
	
	.triangle-top {
		float:left;
		width: 0;
		height: 0;
		margin:-15px 0 0 40px;
		border-left: 12px solid transparent;
		border-right: 12px solid transparent;
		border-bottom: 17px solid #fff;
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
			<div class="inline top module_menu_item" title="<?php echo lang('Detalhes do Projeto')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Detalhes do Projeto') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>

		</div>
	</div>
	
	<h5 style="margin-top:25px"><?php echo lang('Dados do Projeto')?></h5>
	<hr style="margin-bottom:5px;" />
	<div id="box_group_view">
		<div>
			<div id="label_view"><?php echo lang('Título do Projeto') ?></div>
			<div id="field_view" class="font_blue"><h6 style="margin-top:0px;"><?php echo get_value($project, 'title'); ?></div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('Descrição') ?></div>
			<div id="field_view" style="max-width:700px;">
				<?php if(strlen(get_value($project, 'description')) > 600) { ?>
				<div class="comment"><?php echo character_limiter(nl2br(get_value($project, 'description')), 600) ?> <a href="javascript:void(0)" onclick="show_area('view-description-project-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('Veja mais')?></a></div>
				<div id="view-description-project-<?php echo get_value($project, 'id_project')?>" style="display:none;border-top:1px dotted #aaa;margin-top:20px;padding-top:15px;"><?php echo nl2br(get_value($project, 'description')) ?> <a href="javascript:void(0)" onclick="show_area('view-description-project-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('menos')?></a></div>
				<?php } elseif(strlen(get_value($project, 'description')) > 0) { ?>
				<div id="view-description-project-<?php echo get_value($project, 'id_project')?>"><?php echo nl2br(get_value($project, 'description')) ?></div>
				<?php } else { ?>
				<div class="comment italic"><?php echo lang('Nenhuma descrição disponível para este projeto.');?></a></div>
				<?php } ?>
			</div>
		</div>
		<div>
			<div id="label_view"><?php echo lang('Valor da Hora') ?></div>
			<div id="field_view"><?php echo get_value($project, 'hour_value') ?></div>
		</div>
		<div class="odd">
			<div id="label_view"><?php echo lang('Criado em') ?></div>
			<div id="field_view"><?php echo to_human_date(get_value($project, 'log_dtt_ins')) ?></div>
		</div>
	</div>
	
	<h5 style="margin:40px 0 15px 0"><?php echo lang('Atividades deste Projeto')?></h5>
	<?php if(count($activities) > 0 ) { ?>
	<div id="box-project-activities-<?php echo get_value($project, 'id_project')?>" class="box-project-activities with_shadow">
		<div class="triangle-top-border"></div>
		<div class="triangle-top"></div>
		<?php 
		foreach($activities as $activity) { 
		$tasks = $this->activity_model->get_activity_tasks(get_value($activity, 'id_activity')); 
		?>
		<div class="bold" style="margin-top:20px;border-bottom:1px solid #ccc"><h6><?php echo get_value($activity, 'title')?></h6></div>
		<?php 
		if(count($tasks) > 0) {
			foreach($tasks as $task) { 
			$percentage_task = $this->task_lib->used_time_percentage(get_value($task, 'id_task'));
			$total_time_spended = $this->task_lib->total_time_history(get_value($task, 'id_task'));
			$delayed = ($this->task_lib->is_task_delayed(get_value($task, 'id_task'))) ? true : false;
			?>
			<div class="line-task-dependencie font_11" onclick="show_area('box-content-task-<?php echo get_value($task, 'id_task') ?>')">
				<img src="<?php echo URL_IMG ?>/icon_bullet_plus.png" style="float:left;margin:2px 2px 0 0" id="box-content-task-<?php echo get_value($task, 'id_task') ?>_img" />
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
		<?php } else { ?>
		<div class="font_11 comment" style="line-height:20px;padding:1px 2px"><?php echo lang('Nenhuma tarefa para esta atividade.')?></div>
		<?php } ?>
		<?php } ?>
	</div>
	<?php } else { echo message('info', '', lang('Nenhuma atividade cadastrada para este projeto.'), false, 'margin-top:-10px'); } ?>
	
	<div style="margin-top:30px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT . $url_redirect?>');"><?php echo lang('Voltar')?></button></div>
	</div>
</div>
