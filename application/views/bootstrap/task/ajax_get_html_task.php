<div class="line-task" style="padding:2px 3px" id="line-task-<?php echo get_value($task, 'id_task') ?>">
	<div style="margin:0 0 0 15px">
		<h6 class="inline top" style="margin:0 0 0 5px;">></h6>
		<div class="inline top font_11" style="margin-top:4px;"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Histórico de Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_history/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo get_value($task, 'title') ?></a></div>
		<div class="details-task">
			<div class="box-details-task" id="box-details-task-<?php echo get_value($task, 'id_task')?>">
				<?php echo start_box(get_value($task, 'title'), URL_IMG . '/icon_task.png', 'width:400px;min-height:200px;line-height:18px');?>
					<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="float:right;margin:-37px 0 0 0;width:10px;cursor:pointer;" onclick="show_area_fade('box-details-task-<?php echo get_value($task, 'id_task')?>')" />
					<img src="<?php echo URL_IMG ?>/icon-arrow-white-balloon-right.png" style="float:right;margin:45px -26px 0 0;" />
					<img src="<?php echo URL_IMG ?>/icon_bullet_priority_<?php echo strtolower(get_value($task, 'priority'))?>.png" title="<?php echo lang('Prioridade: ') . ucwords(get_value($task, 'priority'))?>" style="float:right;margin:2px -3px 0 0px" />
					<?php if($delayed && strtolower(get_value($task, 'situation')) == 'aberta') { ?>
					<div style="margin-bottom:10px;">
						<img src="<?php echo URL_IMG ?>/icon_warning.png" style="float:left;margin:4px 5px 0 0px" />
						<h5 class="inline top" style="color:#B22222"><?php echo lang('Tarefa atrasada!')?></h5>
					</div>
					<?php } else if(strtolower(get_value($task, 'situation')) == 'finalizada') { ?>
					<div style="margin-bottom:10px;">
						<img src="<?php echo URL_IMG ?>/icon_success.png" style="float:left;margin:4px 5px 0 0px" />
						<h5 class="inline top font_success"><?php echo lang('Tarefa finalizada!')?></h5>
					</div>
					<?php } ?>
					<div class="font_11"><strong><?php echo lang('Situação')?>: </strong> <?php echo get_value($task, 'situation')?></div>
					<div class="font_11"><strong><?php echo lang('Estimativa em horas')?>: </strong> <?php echo substr(get_value($task, 'estimate'), 0, 5)?> <?php echo lang('horas')?></div>
					<div class="font_11"><strong><?php echo lang('Tempo utilizado')?>: </strong> <?php echo substr($total_time_spended, 0, 5); ?> <?php echo lang('horas')?> (<strong style="cursor:default;" title="<?php echo $percentage_task . '% ' . lang('do tempo estimado') ?>"><?php echo $percentage_task ?>%</strong>)</div>
					<div class="font_11" <?php echo ($delayed && strtolower(get_value($task, 'situation')) == 'aberta') ? 'style="color:#B22222"' : ''?>><strong><?php echo lang('Inicia em')?>: </strong> <?php echo to_human_date(get_value($task, 'ini_prev'))?></div>
					<div class="font_11"><strong><?php echo lang('Previsão de término')?>: </strong> <?php echo to_human_date(get_value($task, 'end_prev'))?></div>
					<div class="font_11"><strong><?php echo lang('Usuário responsável')?>: </strong> <a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Perfil de usuário')?>', '<?php echo URL_ROOT ?>/project/modal_user_profile/<?php echo get_value($task, 'id_user_responsible')?>', '<?php echo URL_IMG ?>/icon_user_profile.png', 800, 600)" title="<?php echo lang('Clique para visualizar o perfil')?>"><?php echo get_value($task, 'login_responsible'); ?></a></div>
					<div class="font_11"><strong><?php echo lang('Usuário executor')?>: </strong> <a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Perfil de usuário')?>', '<?php echo URL_ROOT ?>/project/modal_user_profile/<?php echo get_value($task, 'id_user_executor')?>', '<?php echo URL_IMG ?>/icon_user_profile.png', 800, 600)" title="<?php echo lang('Clique para visualizar o perfil')?>"><?php echo get_value($task, 'login_executor'); ?></a></div>
					<div class="font_11" style="margin:10px 0"><?php echo character_limiter(nl2br(get_value($task, 'description')), 350) ?></div>
					<h6><?php echo lang('Ações para esta tarefa:')?></h6>
					<div class="font_11" style="line-height:20px">
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_find.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Histórico de Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_history/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Visualizar Histórico')?></a>
						</div>
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_success.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Finalizar Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_finalize/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Finalizar Tarefa')?></a>
						</div>
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_pencil.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Editar Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_edit/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Editar Tarefa')?></a>
						</div>
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_reopen.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Reabrir Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_reopen/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Reabrir Tarefa')?></a>
						</div>
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_postpone.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Adiar Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_postpone/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 700, 500)"><?php echo lang('Adiar Tarefa')?></a>
						</div>
						<div class="task-line-action">
							<img src="<?php echo URL_IMG ?>/icon_cross.png" />
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Deletar Tarefa')?>', '<?php echo URL_ROOT ?>/task/modal_task_delete/<?php echo get_value($task, 'id_task')?>', '<?php echo URL_IMG ?>/icon_task.png', 800, 600)"><?php echo lang('Deletar Tarefa')?></a>
						</div>
					</div>
				<?php echo end_box(); ?>
			</div>
			<div class="btn-control bold" onclick="show_area_fade('box-details-task-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('DETALHES')?></div>
		</div>
		<div class="right font_11 percentage-task" onmouseover="show_area('task-balloon-estimate-<?php echo get_value($task, 'id_task')?>')" onmouseout="show_area('task-balloon-estimate-<?php echo get_value($task, 'id_task')?>')">
			<div class="left font_11 task-balloon-estimate" id="task-balloon-estimate-<?php echo get_value($task, 'id_task')?>">
				<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
				<div><strong><?php echo $percentage_task ?>%</strong> <?php echo lang('do tempo estimado') ?></div>
				<div><?php echo lang('Estimativa')?>: <?php echo substr(get_value($task, 'estimate'), 0, 5) ?> <?php echo lang('horas')?></div>
				<div><?php echo lang('Utilizado')?>: <?php echo substr($total_time_spended, 0, 5) ?> <?php echo lang('horas')?></div>
			</div>
			<div class="bold"><?php echo $percentage_task ?> %</div>
		</div>
		<div class="right font_11 situation-task"><?php echo get_value($task, 'situation') ?></div>
		<?php if($delayed && strtolower(get_value($task, 'situation')) == 'aberta') { ?>
		<div class="left bold msg-delayed">
			<img src="<?php echo URL_IMG ?>/icon_warning.png" style="width:11px;float:left;margin:-1px 3px 0 0px" />
			<div class="inline top"><?php echo lang('TAREFA ATRASADA')?></div>
		</div>
		<?php } ?>
	</div>
</div>