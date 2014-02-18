<div id="box-line-activity-<?php echo get_value($activity, 'id_activity') ?>">
	<div class="line-activity" id="line-activity-<?php echo get_value($activity, 'id_activity') ?>" onclick="show_area('box-tasks-activity-<?php echo get_value($activity, 'id_activity') ?>')">
		<img id="box-tasks-activity-<?php echo get_value($activity, 'id_activity') ?>_img" src="<?php echo URL_IMG ?>/icon_bullet_plus.png" style="float:left;margin:6px 5px 0 0" />
		<h6><?php echo get_value($activity, 'title')?></h6>
		<div class="details-activity">
			<div class="box-details-activity" id="box-details-activity-<?php echo get_value($activity, 'id_activity')?>">
				<?php echo start_box(get_value($activity, 'title'), URL_IMG . '/icon_activity.png', 'width:400px;min-height:200px;line-height:18px');?>
					<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="float:right;margin:-37px 0 0 0;width:10px;cursor:pointer;" onclick="show_area_fade('box-details-activity-<?php echo get_value($activity, 'id_activity')?>')" />
					<img src="<?php echo URL_IMG ?>/icon-arrow-white-balloon-right.png" style="float:right;margin:20px -26px 0 0;" />
					<div class="font_11"><strong><?php echo lang('Criada por')?>: </strong> <a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Perfil de usuário')?>', '<?php echo URL_ROOT ?>/project/modal_user_profile/<?php echo get_value($activity, 'id_user')?>', '<?php echo URL_IMG ?>/icon_user_profile.png', 800, 600)" title="<?php echo lang('Clique para visualizar o perfil')?>"><?php echo get_value($activity, 'login'); ?></a> <span class="comment"><?php echo lang('em')?> <?php echo to_human_date(get_value($activity, 'log_dtt_ins'))?></span></div>
					<div class="font_11"><strong><?php echo lang('Estimativa de tarefas')?>: </strong> <?php echo $activity_time_estimated; ?> <?php echo lang('horas')?></div>
					<div class="font_11"><strong><?php echo lang('Tempo utilizado')?>: </strong> <?php echo $activity_time_history; ?> <?php echo lang('horas')?> (<strong style="cursor:default;" title="<?php echo $percentage_activity . '% ' . lang('do tempo estimado') ?>"><?php echo $percentage_activity ?>%</strong>)</div>
					<div class="font_11"><strong><?php echo lang('Total de tarefas')?>: </strong> <?php echo get_value($activity, 'total_tasks'); ?> (<a href="javascript:void(0)" onclick="show_area('stats-tasks-activity-<?php echo get_value($activity, 'id_activity')?>')"><?php echo lang('veja mais')?></a>)</div>
					<div class="font_11" id="stats-tasks-activity-<?php echo get_value($activity, 'id_activity')?>" style="display:none;color:#444;margin-left:96px">
						<div class="font_11"><?php echo get_value($activity, 'total_tasks_aberta') . ' ' . lang('abertas') ?></div>
						<div class="font_11"><?php echo get_value($activity, 'total_tasks_andamento') . ' ' . lang('em andamento') ?></div>
						<div class="font_11"><?php echo get_value($activity, 'total_tasks_finalizada') . ' ' . lang('finalizadas') ?></div>
					</div>
					<div class="font_11" style="margin:10px 0"><?php echo character_limiter(nl2br(get_value($activity, 'description')), 350) ?></div>
					<h6><?php echo lang('Ações para esta atividade:')?></h6>
					<div class="font_11">
						<div>
							<img src="<?php echo URL_IMG ?>/icon_bullet_edit_color.png" style="float:left;margin:0px 7px  0 -6px" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Editar atividade')?>', '<?php echo URL_ROOT ?>/activity/modal_activity_edit/<?php echo get_value($activity, 'id_activity')?>', '<?php echo URL_IMG ?>/icon_activity.png', 695, 530)"><?php echo lang('Editar atividade')?></a>
						</div>
						<div>
							<img src="<?php echo URL_IMG ?>/icon_bullet_delete.png" style="float:left;margin:-1px 7px  0 -6px" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Deletar atividade')?>', '<?php echo URL_ROOT ?>/activity/modal_activity_delete/<?php echo get_value($activity, 'id_activity')?>', '<?php echo URL_IMG ?>/icon_activity.png', 695, 530)"><?php echo lang('Deletar atividade')?></a>
						</div>
						<div>
							<img src="<?php echo URL_IMG ?>/icon_insert.png" style="float:left;margin:4px 7px  0 0px;width:10px" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Nova Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_new/<?php echo get_value($activity, 'id_activity')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Adicionar tarefa')?></a>
						</div>
					</div>
				<?php echo end_box(); ?>
			</div>
			<div class="btn-control bold" onclick="show_area_fade('box-details-activity-<?php echo get_value($activity, 'id_activity')?>')"><?php echo lang('DETALHES')?></div>
		</div>
		<div class="right percentage-activity" onmouseover="show_area('activity-balloon-estimate-<?php echo get_value($activity, 'id_activity')?>')" onmouseout="show_area('activity-balloon-estimate-<?php echo get_value($activity, 'id_activity')?>')">
			<div class="left font_11 activity-balloon-estimate" id="activity-balloon-estimate-<?php echo get_value($activity, 'id_activity')?>">
				<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
				<div><strong><?php echo $percentage_activity ?>%</strong> <?php echo lang('do tempo estimado') ?></div>
				<div><?php echo lang('Estimativa')?>: <?php echo $activity_time_estimated; ?> <?php echo lang('horas')?></div>
				<div><?php echo lang('Utilizado')?>: <?php echo $activity_time_history; ?> <?php echo lang('horas')?></div>
			</div>
			<h6><?php echo $percentage_activity ?> %</h6>
		</div>
		<div class="right" style="float:right;margin:-29px 168px 0 0;color:#888"><h6><?php echo $activity_situation ?></h6></div>
	</div>
</div>

<!-- CAIXA ONDE FICARÃO AS TAREFAS --> 
<div id="box-tasks-activity-<?php echo get_value($activity, 'id_activity') ?>" style="display:none;margin:0px 0 20px 0;">
	<!-- LINK PARA NOVA TAREFA -->
	<div class="bold btn-new-task" id="link-new-task-activity-<?php echo get_value($activity, 'id_activity')?>">
		<h6 class="inline top" style="margin:1px 0 0 23px;">></h6>
		<div class="inline top" style="margin-top:7px;"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Nova Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_new/<?php echo get_value($activity, 'id_activity')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('NOVA TAREFA...')?></a></div>
	</div>
</div>

<!-- CARREGA TAREFAS VIA AJAX -->
<?php foreach($tasks as $task) { ?>
<script type="text/javascript" language="javascript"> load_task_line(<?php echo get_value($task, 'id_task') ?>, <?php echo get_value($activity, 'id_activity') ?>) </script>
<?php } ?>

<!-- CANCELA O EVENTO DE BUBBLING --> 
<script type="text/javascript" language="javascript">$('.details-activity').click(function(event){event.stopPropagation();})</script>