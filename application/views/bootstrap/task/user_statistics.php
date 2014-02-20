<?php echo load_js_file('autosize/jquery.autosize.js'); ?>
<?php echo load_js_file('highcharts.3.0.2/js/highcharts.js'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		 $('#box-graphic-tasks-finalized').highcharts({
            chart: {
                type: 'column',
				backgroundColor:'#f5f5f5'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
				'<?php echo get_month_to_words(get_value($user, 'month_name_6'));?>', 
				'<?php echo get_month_to_words(get_value($user, 'month_name_5'));?>', 
				'<?php echo get_month_to_words(get_value($user, 'month_name_4'));?>', 
				'<?php echo get_month_to_words(get_value($user, 'month_name_3'));?>', 
				'<?php echo get_month_to_words(get_value($user, 'month_name_2'));?>', 
				'<?php echo get_month_to_words(get_value($user, 'month_name_1'));?>']
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo lang('Total de tarefas') ?>'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -70,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: '<?php echo lang('Abertas')?>',
                data: [
				<?php echo get_value($user, 'total_tasks_month_6_opened')?>,
				<?php echo get_value($user, 'total_tasks_month_5_opened')?>,
				<?php echo get_value($user, 'total_tasks_month_4_opened')?>,
				<?php echo get_value($user, 'total_tasks_month_3_opened')?>,
				<?php echo get_value($user, 'total_tasks_month_2_opened')?>,
				<?php echo get_value($user, 'total_tasks_month_1_opened')?>
				]
            }, {
                name: '<?php echo lang('Em andamento')?>',
                data: [
				<?php echo get_value($user, 'total_tasks_month_6_going')?>,
				<?php echo get_value($user, 'total_tasks_month_5_going')?>,
				<?php echo get_value($user, 'total_tasks_month_4_going')?>,
				<?php echo get_value($user, 'total_tasks_month_3_going')?>,
				<?php echo get_value($user, 'total_tasks_month_2_going')?>,
				<?php echo get_value($user, 'total_tasks_month_1_going')?>]
            }, {
                name: '<?php echo lang('Finalizadas')?>',
                data: [
				<?php echo get_value($user, 'total_tasks_month_6_finalized')?>,
				<?php echo get_value($user, 'total_tasks_month_5_finalized')?>,
				<?php echo get_value($user, 'total_tasks_month_4_finalized')?>,
				<?php echo get_value($user, 'total_tasks_month_3_finalized')?>,
				<?php echo get_value($user, 'total_tasks_month_2_finalized')?>,
				<?php echo get_value($user, 'total_tasks_month_1_finalized')?>]
            }]
        });
	});
</script>
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
		/*
		-moz-box-shadow:0 0 5px 1px #999;
		-webkit-box-shadow: 0 0 5px #999;
		box-shadow: 0px 0px 5px rgb(150,150,150);
		*/
	}
	
	.line-success { background-color:#b6dbaa; border-bottom:1px solid #5d9d49; }
	.line-success:hover { background-color:#c7dec0 !important; }
	
	.line-delayed { background-color:#FFE875; border-bottom:1px solid #FFA724; }
	.line-delayed:hover { background-color:#ffefa3 !important; }
	
	.line-task:hover {
		background-color:#f0f0f0;
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
	
	.box-stats {
		width:100%;
		background-color:#f9f9f9 !important;
		padding:10px;
		line-height:22px;
		border:1px solid #888;
		-moz-box-shadow:0 0 2px 1px #999;
		-webkit-box-shadow: 0 0 2px #999;
		box-shadow: 0px 0px 2px rgb(150,150,150);
	}
	
	.box-stats .triangle-left-border {
		position:absolute;
		margin:15px 0 0 -35px;
		width: 0;
		height: 0;
		border-top: 15px solid transparent;
		border-right: 24px solid #888;
		border-bottom: 15px solid transparent;
	}
	
	.box-stats .triangle-left {
		position:absolute;
		margin:15px 0 0 -33px;
		width: 0;
		height: 0;
		border-top: 15px solid transparent;
		border-right: 23px solid #f9f9f9;
		border-bottom: 15px solid transparent;
	}
	
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
			<div class="inline top module_menu_item" title="<?php echo lang('Histório / Estatísticas de Tarefas')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Histórico / Estatísticas de Tarefas') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>

		</div>
	</div>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description"><h6>&nbsp;</h6></div>
	
	<!-- BOX DO USUARIO -->
	<table>
	<tr>
	<td style="width:120px;">
		<?php $img_user = (get_value($user, 'url_img') == '') ? URL_IMG . '/avatar_user_unknown.png' : tag_replace(get_value($user, 'url_img')); ?>
		<img src="<?php echo $img_user; ?>" />
	</td>
	<td style="width:99%;padding:0 20px 0 40px;">
		<div class="box-stats inline top">
			<div class="triangle-left-border"></div>
			<div class="triangle-left"></div>
			<div>
				<h5><?php echo lang('Estatisticas de') . ' ' . get_value($user, 'name')?></h5>
				<h6 class="comment"><?php echo lang('Grupo') . ': ' . get_value($user, 'group_name') ?></h6>
				<div style="margin-top:10px;">
					<h6 class="inline top" style="width:200px"><?php echo lang('Total de tarefas') ?>:</h6>
					<h6 class="inline top right" style="width:40px;"><?php echo get_value($user, 'total_tasks') ?></h6>
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
					<div class="inline top bold" style="width:200px"><?php echo lang('Total de tarefas')?> <a href="#box-tasks-finalized"><?php echo lang('finalizadas')?></a>:</div>
					<div class="inline top right" style="width:40px;"><?php echo get_value($user, 'total_tasks_finalized') ?></div>
					<div class="inline top comment" style="margin-left:20px">(<?php echo get_value($user, 'total_tasks_finalized_responsible') . ' ' . lang('como responsável') . ', ' . get_value($user, 'total_tasks_finalized_executor') . ' ' . lang('como executor') ?>)</span>						
				</div>
			</div>
		</div>
	</td>
	</tr>
	</table>
	
	<!-- GRÁFICO DE TAREFAS FINALIZADAS -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Estatísticas de Tarefas nos Últimos 6 Meses')?></h4>
	<hr />
	<div id="box-graphic-tasks-finalized" style="margin-right:17px;"></div>
	
	<!-- TAREFAS FINALIZADAS -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Tarefas Finalizadas')?></h4>
	<hr />
	<div class="font_11" style="float:right;margin-top:-35px">
		<div class="bold inline top" style="margin:4px 5px 0 0"><?php echo lang('Exibindo tarefas onde sou') ?></div>
		<div class="inline top">
			<form id="form-tasks-finalized" action="<?php echo URL_ROOT ?>/task/user_statistics/<?php echo $id_user ?>?url=<?php echo $url_redirect ?>" method="post">
			<select name="filter_user_finalized" class="mini" style="width:155px;" onchange="$('#form-tasks-finalized').submit()">
				<option value="responsible_or_executor" <?php echo (get_value($filters, 'filter_user_finalized') == 'responsible_or_executor') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável ou Executor') ?></option>
				<option value="responsible" <?php echo (get_value($filters, 'filter_user_finalized') == 'responsible') ? 'selected="selected"' : '' ?>><?php echo lang('Responsável') ?></option>
				<option value="executor" <?php echo (get_value($filters, 'filter_user_finalized') == 'executor') ? 'selected="selected"' : '' ?>><?php echo lang('Executor') ?></option>
			</select>
			</form>
		</div>
	</div>
	<div id="box-tasks-finalized">
	<?php if(count($tasks_finalized) <= 0) { echo '<h6 style="color:#bbb">' . lang('Nenhuma tarefa localizada para estes critérios.') . '</h6>'; } ?>
	</div>
	
	<!-- CARREGA TAREFAS FINALIZADAS --> 
	<?php foreach($tasks_finalized as $task) {?>
	<script type="text/javascript" language="javascript"> load_task_line_dashboard(<?php echo get_value($task, 'id_task')?>, 'box-tasks-finalized'); </script>
	<?php } ?>
	
	<div style="margin-top:70px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT . $url_redirect ?>')"><?php echo lang('Voltar')?></button></div>
	</div>
</div>