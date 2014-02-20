<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
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
		
		.line-success { background-color:#b6dbaa;border-bottom:1px solid #5d9d49; }
		.line-success:hover { background-color:#c7dec0 !important;border-bottom:1px solid #5d9d49; }
		
		.line-delayed { background-color:#FFE875; border-bottom:1px solid #FFA724; }
		.line-delayed:hover { background-color:#ffefa3 !important; border-bottom:1px solid #FFA724; }
		
		.box-stats {
			width:100%;
			background-color:#f9f9f9 !important;
			padding:10px;
			line-height:18px;
			border:1px solid #888;
			-moz-box-shadow:0 0 2px 1px #999;
			-webkit-box-shadow: 0 0 2px #999;
			box-shadow: 0px 0px 2px rgb(150,150,150);
		}
		
		.box-stats .triangle-left-border {
			position:absolute;
			margin:5px 0 0 -35px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 24px solid #888;
			border-bottom: 15px solid transparent;
		}
		
		.box-stats .triangle-left {
			position:absolute;
			margin:5px 0 0 -33px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 23px solid #f9f9f9;
			border-bottom: 15px solid transparent;
		}	
	</style>
</head>
<body>
	<div id="modal_content">		
		<table>
		<tr>
		<td style="width:80px;">
			<?php $img_user = (get_value($user, 'url_img') == '') ? URL_IMG . '/avatar_user_unknown.png' : tag_replace(get_value($user, 'url_img')); ?>
			<img src="<?php echo $img_user; ?>" style="width:50px;margin-top:5px" />
		</td>
		<td style="width:99%;padding:0 20px 0 40px;">
			<div class="box-stats inline top">
				<div class="triangle-left-border"></div>
				<div class="triangle-left"></div>
				<div>
					<h6><?php echo lang('Estatisticas de') . ' ' . get_value($user, 'name')?> <span class="comment">(<?php echo get_value($user, 'group_name') ?>)</span></h6>
					<div class="font_11" style="margin-top:5px;">
						<div class="inline bold" style="width:200px"><?php echo lang('Total de tarefas') ?>:</div>
						<div class="inline top right bold" style="width:40px;"><?php echo get_value($user, 'total_tasks') ?></div>
					</div>
					<div class="font_11">
						<div class="inline top bold" style="width:200px"><?php echo lang('Total de tarefas em aberto')?>:</div>
						<div class="inline top right" style="width:40px;"><?php echo get_value($user, 'total_tasks_opened') ?></div>
						<div class="inline top comment" style="margin-left:20px">(<?php echo get_value($user, 'total_tasks_opened_responsible') . ' ' . lang('como responsável') . ', ' . get_value($user, 'total_tasks_opened_executor') . ' ' . lang('como executor') ?>)</span>						
					</div>
					<div class="font_11">
						<div class="inline top bold" style="width:200px"><?php echo lang('Total de tarefas em andamento')?>:</div>
						<div class="inline top right" style="width:40px;"><?php echo get_value($user, 'total_tasks_going') ?></div>
						<div class="inline top comment" style="margin-left:20px">(<?php echo get_value($user, 'total_tasks_going_responsible') . ' ' . lang('como responsável') . ', ' . get_value($user, 'total_tasks_going_executor') . ' ' . lang('como executor') ?>)</span>						
					</div>
					<div class="font_11">
						<div class="inline top bold" style="width:200px"><?php echo lang('Total de tarefas finalizadas')?></a>:</div>
						<div class="inline top right" style="width:40px;"><?php echo get_value($user, 'total_tasks_finalized') ?></div>
						<div class="inline top comment" style="margin-left:20px">(<?php echo get_value($user, 'total_tasks_finalized_responsible') . ' ' . lang('como responsável') . ', ' . get_value($user, 'total_tasks_finalized_executor') . ' ' . lang('como executor') ?>)</span>						
					</div>
				</div>
			</div>
		</td>
		</tr>
		</table>
		
		<div class="bold" style="margin-top:20px;border-bottom:1px solid #ccc"><h6><?php echo lang('Tarefas para Hoje')?></h6></div>
		<?php if(count($tasks_today) > 0) {?>
		<div style="margin:0px 0 20px 0;line-height:20px">
			<?php 
			foreach($tasks_today as $task) { 
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
		</div>
		<?php } else { ?>
		<div class="font_11 comment" style="line-height:20px;padding:1px 2px"><?php echo lang('Nenhuma tarefa localizada.')?></div>
		<?php } ?>
		
		<div class="bold" style="margin-top:30px;border-bottom:1px solid #ccc"><h6><?php echo lang('Tarefas Atrasadas e não Iniciadas')?></h6></div>
		<?php if(count($tasks_delayed_opened) > 0) {?>
		<div style="margin:0px 0 20px 0;line-height:20px">
			<?php 
			foreach($tasks_delayed_opened as $task) { 
			$percentage_task = $this->task_lib->used_time_percentage(get_value($task, 'id_task'));
			$total_time_spended = $this->task_lib->total_time_history(get_value($task, 'id_task'));
			$delayed = ($this->task_lib->is_task_delayed(get_value($task, 'id_task'))) ? true : false;
			?>
			<div class="line-task-dependencie font_11 line-delayed" onclick="show_area('box-content-task-<?php echo get_value($task, 'id_task') ?>')">
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
		</div>
		<?php } else { ?>
		<div class="font_11 comment" style="line-height:20px;padding:1px 2px"><?php echo lang('Nenhuma tarefa localizada.')?></div>
		<?php } ?>
		
		<div class="bold" style="margin-top:30px;border-bottom:1px solid #ccc"><h6><?php echo lang('Próximas Tarefas')?></h6></div>
		<?php if(count($tasks_future) > 0) {?>
		<div style="margin:0px 0 20px 0;line-height:20px">
			<?php 
			foreach($tasks_future as $task) { 
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
		</div>
		<?php } else { ?>
		<div class="font_11 comment" style="line-height:20px;padding:1px 2px"><?php echo lang('Nenhuma tarefa localizada.')?></div>
		<?php } ?>
		
		<div class="bold" style="margin-top:30px;border-bottom:1px solid #ccc"><h6><?php echo lang('Tarefas Finalizadas')?></h6></div>
		<?php if(count($tasks_finalized) > 0) {?>
		<div style="margin:0px 0 20px 0;line-height:20px">
			<?php 
			foreach($tasks_finalized as $task) { 
			$percentage_task = $this->task_lib->used_time_percentage(get_value($task, 'id_task'));
			$total_time_spended = $this->task_lib->total_time_history(get_value($task, 'id_task'));
			$delayed = ($this->task_lib->is_task_delayed(get_value($task, 'id_task'))) ? true : false;
			?>
			<div class="line-task-dependencie font_11 line-success" onclick="show_area('box-content-task-<?php echo get_value($task, 'id_task') ?>')">
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
		</div>
		<?php } else { ?>
		<div class="font_11 comment" style="line-height:20px;padding:1px 2px"><?php echo lang('Nenhuma tarefa localizada.')?></div>
		<?php } ?>
		
		<div style="margin-top:30px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('Fechar')?></button></div>
		</div>
	</div>
</body>
</html>
