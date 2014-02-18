<?php 
	$class = ''; 
	if(strtolower(get_value($task, 'situation')) == 'finalizada'){
		$class = ' line-success';
	} elseif($delayed && strtolower(get_value($task, 'situation')) == 'aberta') {
		$class = ' line-delayed';
	}
?>
<div class="line-task<?php echo $class?>" id="line-task-<?php echo get_value($task, 'id_task')?>" onclick="show_area('box-details-task-<?php echo get_value($task, 'id_task')?>');">
	<img src="<?php echo URL_IMG ?>/icon_bullet_priority_<?php echo strtolower(get_value($task, 'priority'))?>.png" style="float:right;cursor:default" title="<?php echo lang('Prioridade') . ': ' . ucwords(get_value($task, 'priority')) ?>" />
	<div class="right" style="margin:1px 30px 0 0;float:right;width:55px;">
		<?php if($this->session->userdata('id_user') == get_value($task, 'id_user_responsible')) {?>
		<div class="inline top bold msg-user-type responsible" title="<?php echo lang('Sou Responsável')?>">R</div>
		<?php } ?>
		<?php if($this->session->userdata('id_user') == get_value($task, 'id_user_executor')) {?>
		<div class="inline top bold msg-user-type executor" title="<?php echo lang('Sou Executor')?>">E</div>
		<?php } ?>
	</div>
	<h6 style="margin:-3px 30px 0 0;float:right;cursor:default;color:#666;" title="<?php echo lang('Estimativa em horas')?>"><?php echo lang('Estimativa') . ': '. substr(get_value($task, 'estimate'), 0, 5) ?></h6>
	<div style="margin:-6px 40px 0 0;float:right;cursor:default;color:#666;">
		<h6 class="task-line-project-activity"><?php echo get_value($activity, 'project_title'); ?> > <span class="task-line-project-activity-name"><?php echo get_value($activity, 'title') ?></span></h6>
	</div>
	
	<?php if($delayed && strtolower(get_value($task, 'situation')) == 'aberta') {?>
	<div class="left bold msg-delayed">
		<img src="<?php echo URL_IMG ?>/icon_warning.png" style="width:11px;float:left;margin:-1px 3px 0 0px" />
		<div class="inline top"><?php echo lang('TAREFA ATRASADA')?></div>
	</div>
	<?php } ?>
	<img src="<?php echo URL_IMG ?>/icon_bullet_plus.png" id="box-details-task-<?php echo get_value($task, 'id_task') ?>_img" style="float:left" />
	<h6 style="margin:-3px 0 0 20px"><?php echo get_value($task, 'title') ?></h6>
</div>
<div class="box-details-task" id="box-details-task-<?php echo get_value($task, 'id_task')?>">
	<div class="triangle-top-border"></div>
	<div class="triangle-top"></div>
	<div id="box-details-task-content-<?php echo get_value($task, 'id_task')?>"></div>
</div>
<script type="text/javascript" language="javascript"> ajax_load_box_details_task(<?php echo get_value($task, 'id_task')?>); </script>