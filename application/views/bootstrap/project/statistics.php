<?php echo load_js_file('autosize/jquery.autosize.js'); ?>
<?php echo load_js_file('highcharts.3.0.2/js/highcharts.js'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		// GRÁFICO DE ESTATÍSTICAS DE TAREFAS GERAIS DO PROJETO
		$('#graphic-tasks-statistics').highcharts({
			chart: {
				plotBackgroundColor: null,
				backgroundColor: "#f5f5f5",
				plotBorderWidth: 0,
				plotShadow: false,
				height: '200'
			},
			title: {
				text: '',
				align: 'center',
				verticalAlign: 'middle',
				y: 0
			},
			tooltip: {
				pointFormat: 'Total: <b>{point.y}</b>'
			},
			plotOptions: {
				pie: {
					dataLabels: {
						enabled: true,
						distance: -50,
						style: {
							fontWeight: 'bold',
							color: 'white',
							textShadow: '0px 1px 2px black'
						}
					},
					startAngle: -90,
					endAngle: 90,
					center: ['50%', '50%']
				}
			},
			series: [{
				type: 'pie',
				name: '',
				size:180,
				innerSize: '0%',
				data: [
					{name:'<?php echo lang('Abertas')?>', y: <?php echo get_value($project, 'total_tasks_opened')?>},
					{name:'<?php echo lang('Em andamento')?>', y: <?php echo get_value($project, 'total_tasks_going')?>},
					{name:'<?php echo lang('Finalizadas')?>', y:<?php echo get_value($project, 'total_tasks_finalized')?>}
				]
			}]
		});
		
		// GRÁFICO DE VOLUME DE TAREFAS NOS ULTIMOS 6 MESES
		$('#box-graphic-tasks-months').highcharts({
            chart: {
                type: 'column',
				backgroundColor:'#f5f5f5'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
				'<?php echo get_month_to_words(get_value($project, 'month_name_6'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_5'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_4'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_3'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_2'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_1'));?>']
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
				<?php echo get_value($project, 'total_tasks_month_6_opened')?>,
				<?php echo get_value($project, 'total_tasks_month_5_opened')?>,
				<?php echo get_value($project, 'total_tasks_month_4_opened')?>,
				<?php echo get_value($project, 'total_tasks_month_3_opened')?>,
				<?php echo get_value($project, 'total_tasks_month_2_opened')?>,
				<?php echo get_value($project, 'total_tasks_month_1_opened')?>
				]
            }, {
                name: '<?php echo lang('Em andamento')?>',
                data: [
				<?php echo get_value($project, 'total_tasks_month_6_going')?>,
				<?php echo get_value($project, 'total_tasks_month_5_going')?>,
				<?php echo get_value($project, 'total_tasks_month_4_going')?>,
				<?php echo get_value($project, 'total_tasks_month_3_going')?>,
				<?php echo get_value($project, 'total_tasks_month_2_going')?>,
				<?php echo get_value($project, 'total_tasks_month_1_going')?>]
            }, {
                name: '<?php echo lang('Finalizadas')?>',
                data: [
				<?php echo get_value($project, 'total_tasks_month_6_finalized')?>,
				<?php echo get_value($project, 'total_tasks_month_5_finalized')?>,
				<?php echo get_value($project, 'total_tasks_month_4_finalized')?>,
				<?php echo get_value($project, 'total_tasks_month_3_finalized')?>,
				<?php echo get_value($project, 'total_tasks_month_2_finalized')?>,
				<?php echo get_value($project, 'total_tasks_month_1_finalized')?>]
            }]
        });
		
		// GRÁFICO DE CUSTO MENSAL DO PROJETO
		$('#box-graphic-montly-cost').highcharts({
            chart: {
                type: 'column',
				backgroundColor:'#f5f5f5'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
				'<?php echo get_month_to_words(get_value($project, 'month_name_6'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_5'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_4'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_3'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_2'));?>', 
				'<?php echo get_month_to_words(get_value($project, 'month_name_1'));?>']
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo lang('Custo em Reais') ?>'
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
                        'Custo: R$ '+ this.point.stackTotal;
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
                name: '<?php echo lang('Custo em Reais')?>',
                data: [
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_6') / 3600) * get_value($project, 'hour_value')), 2, '.', '') ?>,
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_5') / 3600) * get_value($project, 'hour_value')), 2, '.', '')?>,
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_4') / 3600) * get_value($project, 'hour_value')), 2, '.', '')?>,
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_3') / 3600) * get_value($project, 'hour_value')), 2, '.', '')?>,
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_2') / 3600) * get_value($project, 'hour_value')), 2, '.', '')?>,
				<?php echo number_format(((get_value($project, 'total_time_tasks_month_1') / 3600) * get_value($project, 'hour_value')), 2, '.', '')?>
				]
            }]
        });
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Projetos'); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Detalhes / Estatísticas de Projeto')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Detalhes / Estatísticas de Projeto') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
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
	</style>
	
	<!-- BOX DO USUARIO -->
	<table>
	<tr>
	<td style="width:98%;">
		<h4><?php echo get_value($project, 'title')?></h4>
		<hr />
		<div style="line-height:18px">
			<div style="color:#444;margin:10px 0 15px 0">
				<?php if(strlen(get_value($project, 'description')) > 600) { ?>
				<div class="comment"><?php echo character_limiter(nl2br(get_value($project, 'description')), 600) ?> <a href="javascript:void(0)" onclick="show_area('view-description-project-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('Veja mais')?></a></div>
				<div id="view-description-project-<?php echo get_value($project, 'id_project')?>" style="display:none;border-top:1px dotted #aaa;margin-top:20px;padding-top:15px;"><?php echo nl2br(get_value($project, 'description')) ?> <a href="javascript:void(0)" onclick="show_area('view-description-project-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('menos')?></a></div>
				<?php } elseif(strlen(get_value($project, 'description')) > 0) { ?>
				<div id="view-description-project-<?php echo get_value($project, 'id_project')?>"><?php echo nl2br(get_value($project, 'description')) ?></div>
				<?php } else { ?>
				<div class="comment italic"><?php echo lang('Nenhuma descrição disponível para esta tarefa.');?></a></div>
				<?php } ?>
			</div>
			<div>
				<h6 class="inline top" style="width:150px;"><?php echo lang('Valor da hora')?>:</h6>
				<h6 class="inline top" style="width:70px;margin-top:4px;">R$ <?php echo number_format(get_value($project, 'hour_value'), 2, ',', '.')?></h6>
			</div>
			<div>
				<h6 class="inline top" style="width:150px;"><?php echo lang('Criado em')?>:</h6>
				<h6 class="inline top" style="width:70px;margin-top:4px;"><?php echo to_human_date(get_value($project, 'log_dtt_ins'))?></h6>
			</div>
			<div>
				<h6 class="inline top" style="width:150px;"><?php echo lang('Situação do projeto')?>:</h6>
				<h6 class="inline top <?php echo (get_value($project, 'dtt_inative') == '') ? 'font_success' : 'font_error' ?>" style="width:70px;margin-top:4px;"><?php echo (get_value($project, 'dtt_inative') == '') ? lang('Ativo') : lang('Inativo') ?></h6>
				<div class="inline top font_11" style="margin:5px 0 0 -20px"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Ativar / Desativar Projeto')?>', '<?php echo URL_ROOT ?>/project/modal_project_inactivate/<?php echo get_value($project, 'id_project')?>', '<?php echo URL_IMG ?>/icon_project.png', 800, 600)"><?php echo lang('Ativar / Desativar Projeto') ?></a></div>
			</div>
		</div>
	</td>
	<td style="min-width:270px;width:200px;padding:10px 0 0 40px;">
		<h6><?php echo lang('Estatísticas de Custo')?></h6>
		<hr />
		<?php $style = ($project_amount_now > $project_amount_estimated) ? 'background-color:#FFE875;border-bottom:1px solid #FFA724;' : 'background-color:#b6dbaa;border-bottom:1px solid #5d9d49'; ?>
		<div style="height:200px;text-align:center;line-height:19px;padding:10px 10px;<?php echo $style; ?>">
			<div id="project-amount-now">
				<h6 class="bold"><?php echo lang('Até o momento este projeto custou')?>:</h6>
				<h3 style="margin:15px 0 10px 0">R$ <?php echo number_format($project_amount_now, 2, ',', '.')?></h3>
				<div class="font_11"><?php echo substr($total_time_history_hours, 0 , -3) . ' ' . lang('horas executadas') . ' <strong>X </strong> R$ ' . number_format(get_value($project, 'hour_value'), 2, ',', '.') . ' ' . lang('valor/hora')?></div>
			</div>
			<div id="project-amount-estimate" style="margin-top:20px;color:#666;border-top:1px dashed #555;padding-top:10px">
				<h6 class="bold"><?php echo lang('Projeção de custo do projeto')?>:</h6>
				<h3 style="margin:15px 0 10px 0">R$ <?php echo number_format($project_amount_estimated, 2, ',', '.')?></h3>
				<div class="font_11"><?php echo substr($total_time_estimated_hours, 0 , -3) . ' ' . lang('horas estimadas') . ' <strong>X </strong> R$ ' . number_format(get_value($project, 'hour_value'), 2, ',', '.') . ' ' . lang('valor/hora')?></div>
			</div>
		</div>
		<div style="margin-top:10px;">
			<div class="inline top" style="width:11px;height:11px;background-color:#FFE875;"></div>
			<div class="inline top font_11" style="color:#333;margin-top:-1px"><?php echo lang('Custo acima do estimado')?></div>
			<div class="inline top" style="margin-left:15px;width:11px;height:11px;background-color:#b6dbaa;"></div>
			<div class="inline top font_11" style="color:#333;margin-top:-1px"><?php echo lang('Custo abaixo')?></div>
		</div>
	</td>
	<td style="min-width:270px;width:200px;padding:10px 0 0 40px;">
		<h6><?php echo lang('Estatísticas de Tarefas')?></h6>
		<hr />
		<div style="background-color:#f5f5f5;padding:10px 10px;border-bottom:1px solid #ccc">
			<div id="graphic-tasks-statistics"></div>
		</div>
		<!--
		<div class="font_11" style="background-color:#333;padding:7px 12px;border-bottom:2px solid #000;">
			<a href="javascript:void(0)" style="color:#fff;margin-right:10px;"><?php echo lang('Modo Gráfico')?></a>
			<a href="javascript:void(0)" style="color:#fff;"><?php echo lang('Modo Lista')?></a>
		</div>
		-->
	</td>
	</tr>
	</table>
	
	<!-- GRÁFICO DE TAREFAS FINALIZADAS -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Volume de Tarefas nos Últimos 6 Meses')?></h4>
	<hr />
	<div id="box-graphic-tasks-months" style="margin-right:17px;"></div>
	
	<!-- GRÁFICO DE CUSTO MENSAL DO PROJETO -->
	<h4 class="inline top" style="margin-top:70px"><?php echo lang('Custo Mensal do Projeto')?></h4>
	<hr />
	<div id="box-graphic-montly-cost"></div>
	
	<div style="margin-top:70px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT . $url_redirect ?>')"><?php echo lang('Voltar')?></button></div>
	</div>
</div>