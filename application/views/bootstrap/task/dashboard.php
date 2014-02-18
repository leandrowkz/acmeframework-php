<?php echo load_js_file('autosize/jquery.autosize.js'); ?>
<script type="text/javascript">
	$(document).ready(function(){
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>/dashboard"><?php echo lang('Tarefas'); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item">
				<img class="inline top" src="<?php echo URL_IMG ?>/icon_insert.png" />
				<a href="<?php echo URL_ROOT ?>/task/form_insert?url=/task/dashboard"><h6 class="inline top"><?php echo lang('Nova Tarefa') ?></h6></a>
			</div>
			<div class="inline top module_menu_item">
				<img class="inline top" src="<?php echo URL_IMG ?>/icon_statistics.png" />
				<a href="<?php echo URL_ROOT ?>/task/user_statistics?url=/task/dashboard"><h6 class="inline top"><?php echo lang('Histórico / Estatísticas de Tarefas') ?></h6></a>
			</div>
		</div>
	</div>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description"><h6>&nbsp;</h6></div>
	
	<!-- LISTA DE PROJETOS ATIVOS -->
	<style type="text/css">
		hr {
			height:1px;
			background-color:#aaa;
			border-top: none;
			border-right: none;
			border-bottom: 1px solid #ddd;
			border-left: none;
		}	
		
		.line-task {
			background-color:#f5f5f5;
			padding:15px 10px;
			cursor:pointer;
			margin-bottom:0px;
			border-bottom:1px solid #bbb;
		}
		
		.line-success { background-color:#b6dbaa;border-bottom:1px solid #5d9d49; }
		.line-success:hover { background-color:#c7dec0 !important; }
		
		.line-delayed { background-color:#FFE875; border-bottom:1px solid #FFA724; }
		.line-delayed:hover { background-color:#ffefa3 !important; }
		
		.line-task:hover {
			background-color:#f0f0f0;
		}
		
		.task-line-project-activity {
			float:right;
		}
		
		.task-line-project-activity:hover .task-line-project-activity-name {
			display:inline-block !important;
		}
		
		.task-line-project-activity-name {
			display:none;
		}
		
		.box-details-task {
			border:1px solid #777;
			margin:0px 0 30px 0;
			min-height:150px;
			padding:25px 30px 20px 30px;
			-moz-box-shadow:0 0 8px 1px #999;
			-webkit-box-shadow: 0 0 8px #999;
			box-shadow: 0px 0px 8px rgb(150,150,150);
			display:none;
		}
		
		.triangle-top-border {
			float:left;
			width: 0;
			height: 0;
			margin:-43px 0 0 40px;
			border-left: 12px solid transparent;
			border-right: 12px solid transparent;
			border-bottom: 17px solid #444;
		}
		
		.triangle-top {
			float:left;
			width: 0;
			height: 0;
			margin:-41px 0 0 40px;
			border-left: 12px solid transparent;
			border-right: 12px solid transparent;
			border-bottom: 17px solid #fff;
		}
		
		.msg-delayed {
			cursor:default;
			margin:1px 40px 0 0;
			float:right;
			background-color:#000;
			color:#fff;
			padding:3px 4px;
			letter-spacing:1px;
			font-size:08px;
		}
		
		.msg-user-type {
			width:10px;
			text-align:center;
			cursor:default;
			background-color:#000;
			color:#fff;
			padding:5px;
			margin:-2px 0 0 5px;
			letter-spacing:1px;
			font-size:08px;
		}
		
		.responsible { background-color:#3A5FCD; }
		.executor { background-color:#FF4500; }
		
		
		/* =================================================================================== */
		/*  ANDAMENTO DA TAREFA - BLOCO DE ESTILOS CSS                                         */
		/* =================================================================================== */
		.percentage-task {
			float:right;
			width:60px;
			padding:3px 0;
			margin:0px 15px 0 0;
			color:#000;
			cursor:default;
			text-align:center;
		}
		
		.situation-task {
			float:right;
			margin:3px 11px 0 0;
			min-width:80px;
			color:#888;
		}
		
		.task-balloon-estimate {
			position:absolute;
			right:0%;
			width:150px;
			margin:-5px 53px 0 0;
			background-color:#000;
			color:#fff;
			padding:5px 10px;
			line-height:18px;
			display:none;
		}
		
		.task-balloon-estimate img {
			float:right;
			margin:2px -18px 0 0;
		}
		
		.label_view_custom {
			width:100% !important;
			cursor:default;
		}
		
		#field_view {
			font-size:11px;
		}
		
		.task-description, .project-description {
			right:0%;
			position:absolute;
			padding:5px;
			background-color:#fff;
			margin:-35px 0 0 0;
			display:none;
		}
		
		.line-history {
			width:100%;
			margin-bottom:30px
		}
		
		#box-new-history {
			display:none;
		}
		
		.box-new-history-custom {
			background-color:#fff;
			border-bottom:1px solid #ddd;
			margin:15px 0 0 0;
			padding:5px 15px 15px 15px;
			display:none;
		}
		
		.box-comment {
			position:relative;
			background-color:#fff !important;
			padding:10px;
			line-height:18px;
			width:360px;
			border:1px solid #888;
			-moz-box-shadow:0 0 2px 1px #999;
			-webkit-box-shadow: 0 0 2px #999;
			box-shadow: 0px 0px 2px rgb(150,150,150);
		}
		
		.box-comment-new {
			position:relative;
			background-color:#fff;
			padding:10px;
			line-height:18px;
			width:360px;
			border:1px solid #888;
			margin-bottom:20px;
			-moz-box-shadow:0 0 2px 1px #999;
			-webkit-box-shadow: 0 0 2px #999;
			box-shadow: 0px 0px 2px rgb(150,150,150);
		}
		
		.box-comment-new textarea { 
			width:100%;
			padding:0 0 0 3px;
			font-size:11px !important;
			border:1px solid #fff;
			background-color:#fff;
			background-image:none;
		}
		
		.box-comment-new input[type="text"] { 
			border:1px solid #ddd;
			padding:5px;
			color:#000;
			width:28px;
			font-size:11px !important;
			background-image:none;
			background-color:#ddd;
		}
		
		.triangle-left-border {
			position:absolute;
			margin:0 0 0 -35px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 24px solid #888;
			border-bottom: 15px solid transparent;
		}
		
		.triangle-left {
			position:absolute;
			margin:0 0 0 -33px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 23px solid #fff;
			border-bottom: 15px solid transparent;
		}
		
		.triangle-left-white-border {
			position:absolute;
			margin:5px 0 0 -32px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 24px solid #888;
			border-bottom: 15px solid transparent;
		}
		
		.triangle-left-white {
			position:absolute;
			margin:5px 0 0 -30px;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-right: 23px solid #fff;
			border-bottom: 15px solid transparent;
		}
		
		.triangle-right-border {
			position:absolute;
			right:0%;
			margin:0 -25px 0 0;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-left: 24px solid #888;
			border-bottom: 15px solid transparent;
		}
		
		.triangle-right {
			position:absolute;
			right:0%;
			margin:0 -23px 0 0;
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-left: 23px solid #fff;
			border-bottom: 15px solid transparent;
		}
		
		.box-history-class {
			padding:15px;
			width:550px;
			background-color:#f5f5f5;
			/*border:1px solid red*/
		}
		
		.box-details-right {
			padding:0 10px 0 2px;
			width:100%;
		}
	</style>
	
	<!-- TAREFAS PARA HOJE -->
	<h4 class="inline top"><?php echo lang('Tarefas para Hoje')?></h4>
	<div class="font_11 inline top" style="margin:15px 0 0 10px"><a href="javascript:void(0)" onclick="show_area('msg-saiba-mais-tasks-today')"><?php echo lang('Saiba mais')?></a></div>
	<div class="inline top" style="margin:3px 0 0 5px;position:absolute;">
		<div id="msg-saiba-mais-tasks-today" class="font_11" style="width:100%;margin:0 0 0 10px;padding:10px;background-color:#000;color:#fff;line-height:18px;display:none">
			<img src="<?php echo URL_IMG ?>/bg_arrow_form.png" style="float:left;margin:1px 0 0 -18px" />
			<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:10px;cursor:pointer;float:right;margin:4px 0px 0 0" onclick="show_area('msg-saiba-mais-tasks-today')" />
			<div><strong><?php echo lang('Tarefas para Hoje')?></strong> <?php echo lang('agrupa todas as tarefas que iniciam no dia de hoje e todas as outras já inicializadas (com andamento) que iniciaram em dias anteriores.')?></div>
		</div>
	</div>
	<hr />
	<div class="font_11" style="float:right;margin-top:-35px">
		<div class="bold inline top" style="margin:4px 5px 0 0"><?php echo lang('Exibindo tarefas onde sou') ?></div>
		<div class="inline top">
			<form id="form-tasks-today" action="<?php echo URL_ROOT ?>/task/dashboard" method="post">
			<select name="filter_user_today" class="mini" style="width:155px;" onchange="$('#form-tasks-today').submit()">
				<option value="responsible_or_executor" <?php echo (get_value($filters, 'filter_user_today') == 'responsible_or_executor') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável ou Executor') ?></option>
				<option value="responsible" <?php echo (get_value($filters, 'filter_user_today') == 'responsible') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável') ?></option>
				<option value="executor" <?php echo (get_value($filters, 'filter_user_today') == 'executor') ? 'selected="selected"' : '' ?>><?php echo lang('Executor') ?></option>
			</select>
			</form>
		</div>
	</div>
	<div id="box-tasks-today">
	<?php if(count($tasks_today) <= 0) { echo '<h6 style="color:#bbb">' . lang('Nenhuma tarefa localizada para estes critérios.') . '</h6>'; } ?>
	</div>
	
	<!-- TAREFAS ATRASADAS ABERTAS -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Tarefas Atrasadas e não Iniciadas')?></h4>
	<div class="font_11 inline top" style="margin:82px 0 0 10px"><a href="javascript:void(0)" onclick="show_area('msg-saiba-mais-tasks-delayed-opened')"><?php echo lang('Saiba mais')?></a></div>
	<div class="inline top" style="margin:70px 0 0 5px;position:absolute;">
		<div id="msg-saiba-mais-tasks-delayed-opened" class="font_11" style="width:100%;margin:0 0 0 10px;padding:10px;background-color:#000;color:#fff;line-height:18px;display:none">
			<img src="<?php echo URL_IMG ?>/bg_arrow_form.png" style="float:left;margin:1px 0 0 -18px" />
			<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:10px;cursor:pointer;float:right;margin:4px 0px 0 0" onclick="show_area('msg-saiba-mais-tasks-delayed-opened')" />
			<div><strong><?php echo lang('Tarefas Atrasadas e não Iniciadas')?></strong> <?php echo lang('é o conjunto de tarefas com situação aberta (sem andamento) e com data de início marcada para dias anteriores.')?></div>
		</div>
	</div>
	<hr />
	<div class="font_11" style="float:right;margin-top:-35px">
		<div class="bold inline top" style="margin:4px 5px 0 0"><?php echo lang('Exibindo tarefas onde sou') ?></div>
		<div class="inline top">
			<form id="form-tasks-delayed-opened" action="<?php echo URL_ROOT ?>/task/dashboard" method="post">
			<select name="filter_user_delayed_opened" class="mini" style="width:155px;" onchange="$('#form-tasks-delayed-opened').submit()">
				<option value="responsible_or_executor" <?php echo (get_value($filters, 'filter_user_delayed_opened') == 'responsible_or_executor') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável ou Executor') ?></option>
				<option value="responsible" <?php echo (get_value($filters, 'filter_user_delayed_opened') == 'responsible') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável') ?></option>
				<option value="executor" <?php echo (get_value($filters, 'filter_user_delayed_opened') == 'executor') ? 'selected="selected"' : '' ?>><?php echo lang('Executor') ?></option>
			</select>
			</form>
		</div>
	</div>
	<div id="box-tasks-delayed-opened">
	<?php if(count($tasks_delayed_opened) <= 0) { echo '<h6 style="color:#bbb">' . lang('Nenhuma tarefa localizada para estes critérios.') . '</h6>'; } ?>
	</div>
	
	<!-- TAREFAS FUTURAS -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Tarefas Futuras')?></h4>
	<div class="font_11 inline top" style="margin:82px 0 0 10px"><a href="javascript:void(0)" onclick="show_area('msg-saiba-mais-tasks-future')"><?php echo lang('Saiba mais')?></a></div>
	<div class="inline top" style="margin:70px 0 0 5px;position:absolute;">
		<div id="msg-saiba-mais-tasks-future" class="font_11" style="width:100%;margin:0 0 0 10px;padding:10px;background-color:#000;color:#fff;line-height:18px;display:none">
			<img src="<?php echo URL_IMG ?>/bg_arrow_form.png" style="float:left;margin:1px 0 0 -18px" />
			<img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:10px;cursor:pointer;float:right;margin:4px 0px 0 0" onclick="show_area('msg-saiba-mais-tasks-future')" />
			<div><strong><?php echo lang('Tarefas Futuras')?></strong> <?php echo lang('são todas as tarefas com previsão de início para os próximos dias.')?></div>
		</div>
	</div>
	<hr />
	<div class="font_11" style="float:right;margin-top:-35px">
		<div class="bold inline top" style="margin:4px 5px 0 0"><?php echo lang('Exibindo tarefas onde sou') ?></div>
		<div class="inline top">
			<form id="form-tasks-future" action="<?php echo URL_ROOT ?>/task/dashboard" method="post">
			<select name="filter_user_future" class="mini" style="width:155px;" onchange="$('#form-tasks-future').submit()">
				<option value="responsible_or_executor" <?php echo (get_value($filters, 'filter_user_future') == 'responsible_or_executor') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável ou Executor') ?></option>
				<option value="responsible" <?php echo (get_value($filters, 'filter_user_future') == 'responsible') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável') ?></option>
				<option value="executor" <?php echo (get_value($filters, 'filter_user_future') == 'executor') ? 'selected="selected"' : '' ?>><?php echo lang('Executor') ?></option>
			</select>
			</form>
		</div>
	</div>
	<div id="box-tasks-future">
	<?php if(count($tasks_future) <= 0) { echo '<h6 style="color:#bbb">' . lang('Nenhuma tarefa localizada para estes critérios.') . '</h6>'; } ?>
	</div>
	
	<!-- CARREGA TAREFAS DE HOJE (VIA AJAX) --> 
	<?php foreach($tasks_today as $task) {?>
	<script type="text/javascript" language="javascript"> load_task_line_dashboard(<?php echo get_value($task, 'id_task')?>, 'box-tasks-today'); </script>
	<?php } ?>
	
	<!-- CARREGA TAREFAS ATRASADAS E ABERTAS (VIA AJAX) --> 
	<?php foreach($tasks_delayed_opened as $task) {?>
	<script type="text/javascript" language="javascript"> load_task_line_dashboard(<?php echo get_value($task, 'id_task')?>, 'box-tasks-delayed-opened'); </script>
	<?php } ?>
	
	<!-- CARREGA TAREFAS FUTURAS, ABERTAS OU EM ANDAMENTO --> 
	<?php foreach($tasks_future as $task) {?>
	<script type="text/javascript" language="javascript"> load_task_line_dashboard(<?php echo get_value($task, 'id_task')?>, 'box-tasks-future'); </script>
	<?php } ?>
</div>