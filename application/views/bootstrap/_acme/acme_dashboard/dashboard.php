<div>
<?php echo $this->template->load_js_file('highcharts.3.0.2/js/highcharts.js')?>
<?php echo $this->template->load_js_file('highcharts.3.0.2/js/highcharts-more.js')?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    // Ataccha evendo no input de pesquisa
	$("#search_mod").keyup(function() {
		var exist = false;
		if($("#search_mod").val().length > 2){			
			
			$('h6[id^="module_"]').each(function(){ 				
				$("#div_"+$(this).attr('id')).hide();								
			});
			
			var pesq = $("#search_mod").val().toLowerCase(); 		
			
			$('h6[id^="module_"]').each(function(index){ 
			
				var perm = $(this).text().toLowerCase();				
				
				if(perm.indexOf(pesq) != -1){					
					exist = true;
					$('#div_msg_no_module').hide();
					$("#div_"+$(this).attr('id')).show();	
				}
			});
			
			if(exist == false){
					$('#div_msg_no_module').show();
			}
		
		}else if(($("#search_mod").val().length <= 2)||($("#search_mod").val().length == '')){
			$('h6[id^="module_"]').each(function(index){ 
				$("#div_"+$(this).attr('id')).show();		
				$('#div_msg_no_module').hide();
			});
		}
	});
	
	// CHART
	// RANK DE ACESSOS POR BROWSERS
	$('#browsers_chart').highcharts({
        chart: {
            type: 'pie',
			height:250
        },
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage}%</b>',
			percentageDecimals: 1,
			formatter: function() {
				return '<b>'+ this.point.name + '</b>: <b>'+ this.percentage.toFixed(2) +'</b>%<br />' + this.y + ' <?php echo lang('Acessos')?>';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) + ' %';
					}
				}
			}
		},
        series: [{
			allowPointSelect: true,
			size: '100%',
			type: 'pie',
            name: '<?php echo lang('Acessos')?>',
            data: [
				<?php 
				$data = '';
				foreach($browsers as $browser) { 
				$data .= "['" . get_value($browser, 'browser_name') . "', " . get_value($browser, 'acessos') . "],";
				}
				echo trim($data, ',');
                ?>
            ]
        }]
    });
	
	// CHART
	// USUÁRIOS POR GRUPOS
	$('#groups_chart').highcharts({
        chart: {
            type: 'pie',
			height:265
        },
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage}%</b>',
			percentageDecimals: 1,
			formatter: function() {
				return '<b>'+ this.point.name + '</b>: <b>'+ this.percentage.toFixed(2) +'</b>%<br />' + this.y + ' <?php echo lang('Usuários')?>';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) + ' %';
					}
				}
			}
		},
        series: [{
			allowPointSelect: true,
			size: '100%',
			type: 'pie',
            name: '<?php echo lang('Usuários')?>',
            data: [
				<?php 
				$data = '';
				foreach($groups as $group) { 
				$data .= "['" . get_value($group, 'group_name') . "', " . get_value($group, 'users') . "],";
				}
				echo trim($data, ',');
                ?>
            ]
        }]
    });
	
	// CHART
	// ERROS MAPEADOS POR TIPO
	<?php if(count($error_types) > 0 ){?>
	$('#errors_chart').highcharts({
        chart: {
            type: 'pie',
			height:250
        },
		colors: [
		   '#CD5C5C', 
		   '#FF4500', 
		   '#B22222', 
		   '#EE2C2C', 
		   '#FF7F00'
		],
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage}%</b>',
			percentageDecimals: 1,
			formatter: function() {
				return '<b>'+ this.point.name + '</b>: <b>'+ this.percentage.toFixed(2) +'</b>%<br />' + this.y + ' <?php echo lang('Erros')?>';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) + ' %';
					}
				}
			}
		},
        series: [{
			allowPointSelect: true,
			size: '100%',
			type: 'pie',
            name: '<?php echo lang('Erros')?>',
            data: [
				<?php 
				$data = '';
				foreach($error_chart as $erro) { 
				$data .= "['" . get_value($erro, 'error_type') . "', " . get_value($erro, 'count_errors') . "],";
				}
				echo trim($data, ',');
                ?>
            ]
        }]
    });
	<?php } ?>
	
	// CHART
	// GAUGE DE TEMPO MÉDIO DE ACESSO
	$('#gauge_chart').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			height:265
	    },
	    
	    title: {
	        text: ''
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 15,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: '<?php echo lang('Segundos') ?>'
	        },
	        plotBands: [{
	            from: 0,
	            to: 2,
	            color: '#55BF3B' // green
	        }, {
	            from: 2,
	            to: 6,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: 6,
	            to: 15,
	            color: '#DF5353' // red
	        }]        
	    },
	
	    series: [{
	        name: '<?php echo lang('Tempo de Acesso')?>',
	        data: [<?php echo $average_time_access ?>],
	        tooltip: {
	            valueSuffix: ' <?php echo lang('segundos')?>'
	        }
	    }]
	
	});
});

function change_visualizacao_browsers(method)
{
	if(method == 'lista')
	{
		$('#browsers_chart').hide();
		$('#browsers_lista').show();
	} else {
		$('#browsers_chart').show();
		$('#browsers_lista').hide();
	}
}

function change_visualizacao_errors(method)
{
	if(method == 'lista')
	{
		$('#errors_chart').hide();
		$('#errors_lista').show();
	} else {
		$('#errors_chart').show();
		$('#errors_lista').hide();
	}
}
</script>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td style="min-width:500px">
			<div id="module_rotule" class="inline top">
				<h2 class="inline top font_shadow_gray" style="margin:-20px 5px 0 0"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
				<?php if($this->url_img != '') {?>
				<img src="<?php echo $this->url_img ?>"  />
				<?php } ?>
			</div>
			
			<h4 class="font_shadow_gray" style="margin-top:25px"><?php echo lang('Bem-vindo!') ?></h4>
			<div style="line-height:19px" class="font_11"><?php echo lang('Este é o dashboard padrão do sistema. Nesta página você encontrará estatísticas gerais de acesso à aplicação, mapeamento de erros, acesso rápido à funcionalidades e módulos do sistema além de lista de atualizações disponíveis.')?></div>
			<div style="line-height:19px" class="font_11">
				<?php echo lang('Esteja mais familiarizado com o sistema ACME Engine, descubra como construir uma aplicação cada vez melhor lendo a') . ' <a href="http://www.acmeengine.org/documentation" target="_blank">' . lang('documentação') . '</a> ';?>
				<div class="inline top" style="margin:4px 3px 0 -1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				<?php echo lang('disponível')?>.
			</div>
			
			<!--
			<h4 class="font_shadow_gray" style="margin-top:30px;"><?php echo lang('Atualizações Disponíveis');?></h4>
			<hr style="margin:5px 0" />
			<div><?php echo message('info', '', lang('Nenhuma atualização disponível até o momento.'))?></div>
			-->
			
			<h4 class="font_shadow_gray" style="margin-top:30px;"><?php echo lang('Acesso Rápido');?></h4>
			<hr style="margin:5px 0" />
			<div style="line-height:20px;">
				<h6 class="inline top">&bull;&nbsp;<a href="http://www.acmeengine.org/documentation/tutorials" target="blank"><?php echo lang('Tutoriais')?></a></h6>
				<div class="inline top" style="margin:7px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				<br />
				<h6 class="inline top">&bull;&nbsp;<a href="http://www.acmeengine.org/documentation" target="_blank"><?php echo lang('Documentação do ACME Engine')?></a></h6>
				<div class="inline top" style="margin:7px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
				<br />
				<h6 class="inline top">&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_module_manager"><?php echo lang('Administração de Módulos')?></a></h6>
				<br />
				<h6>&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Construtor de Módulos')?></a></h6>
			</div>
			
			<h4 class="inline top font_shadow_gray" style="margin-top:40px;"><?php echo lang('Módulos') ?> <?php echo ($show_acme_modules) ? lang('do ACME Engine') : lang('da Aplicação'); ?></h4>
			<div class="inline top" style="margin-top:50px;">
				<form id="form_modules" action="<?php echo URL_ROOT ?>/acme_dashboard/" method="post" class="inline top">
					<?php if($show_acme_modules) { ?>
					<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="N" />
					<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos da Aplicação')?></a>
					<?php } else { ?>
					<input type="hidden" name="show_acme_modules" id="show_acme_modules" value="Y" />
					<a href="javascript:void(0);" onclick="$('#form_modules').submit();"><?php echo lang('Exibir Módulos do ACME Engine')?></a>
					<?php } ?>
				</form>
			</div>
			<?php if(count($modules) > 0) {?>
			<input type="text" id="search_mod" placeholder="<?php echo lang('Módulo...') ?>" style="width:105px;font-size:15px !important;font-family:'Open Sans Condensed' !important;font-weight:bold !important;float:right;margin-top:40px;background-color:FF0000;background-image: url('<?php echo URL_IMG ?>/icon_search.png' );background-repeat:no-repeat;background-position:right;padding-right:22px;" />
			<hr style="margin:5px 0 10px 0" />
			
			<?php 
			$i = 0;
			$modulo_anterior = '';
			foreach($modules as $module) { 
			?>
			<?php if(get_value($module, 'lang_key_rotule') != $modulo_anterior) { ?>
			<?php $cont_class = 0; ?>
			<?php if($i > 0) { ?>	</td></tr></table></div></div><?php } ?>
			
			<div id="div_module_<?php echo $i;?>">
				<div id="box_group_view" style="margin-bottom:50px; background-color: #f5f5f5; ">
					<table width="100%" >
					<tr>
					<td id="box_permission_left" style="width:30px !important; padding: 20px 0 0 20px;" > 
						<?php if(get_value($module, 'URL_IMG') != '') { ?>
						<img class="inline top" style="float:right;" src="<?php echo eval_replace(get_value($module, 'URL_IMG')) ?>"> 
						<?php } ?>
					</td>
					<td id="box_permission_center" style="width:120px !important; padding: 22px 10px; border-right: 1px solid #CCC;" > 
						<h6 id="module_<?php echo $i;?>" class="inline top"><?php echo lang(get_value($module, 'lang_key_rotule')) ?></h6>
					</td>
					<td id="box_permission_right" style="line-height:18px; background-color:#FFF;">
					<?php }  ?>
						<div style="padding:14px 10px 10px 10px" class="font_11">
							<a href="<?php echo URL_ROOT . '/' . get_value($module, 'controller') ?>"><?php echo lang('Ir para o módulo')?></a>
							&nbsp;&nbsp;&nbsp;
							<a href="javascript:void(0)" onclick="iframe_modal('<?php echo('Editar Dados do Módulo')?>', '<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_update_module_data/<?php echo get_value($module, 'id_module') ?>', '', 800, 600)"><?php echo lang('Editar dados deste módulo') ?></a>
							<div class="font_11" style="margin-top:5px"><?php echo get_value($module, 'description')?></div>
							<div class="font_11 bold" style="margin-top:5px">
								<?php
									echo lang('Situação do módulo:');
									echo (get_value($module, 'dtt_inative') != '') ? '<span class="font_error"> Inativo</span>' : '<span class="font_green"> Ativo</span>';
								?>
							</div>
						</div>
					<?php 
						$i++;
						$cont_class++;
						$modulo_anterior = get_value($module, 'lang_key_rotule');
					} 
					?>
					</table>
				</div>
			</div>
			<div id="div_msg_no_module" style="display: none; line-height:normal;"><?php echo message('info', lang('Nenhum Módulo Encontrado'), lang('Sua pesquisa não contém resultados.')); ?></div>
			<?php } else { ?>
			<hr style="margin:5px 0 10px 0" />
			<?php echo message('info', lang('Nenhum Módulo'), lang('Nenhum módulo cadastrado até o momento para esta aplicação.')); } ?>
		</td>
		<td id="column_filter" width="300" nowrap style="padding-left:80px;">
			<?php echo $this->template->start_box(lang('Rank de Acessos por Browsers'), URL_IMG . '/icon_ranking_browser.png', 'min-height:250px;max-width:300px');?>
			<div style="height:10px;">
				<img src="<?php echo URL_IMG ?>/icon_mono_list.png" style="float:right;margin-left:10px;cursor:pointer" title="<?php echo lang('Visualização em Lista') ?>" onclick="change_visualizacao_browsers('lista')" />
				<img src="<?php echo URL_IMG ?>/icon_mono_chart.png" style="float:right;cursor:pointer" title="<?php echo lang('Visualização em Gráfico') ?>" onclick="change_visualizacao_browsers('grafico')" />
			</div>
			<div id="browsers_chart" style="width:100%;"></div>
			<div id="browsers_lista" style="display:none;">
			<?php foreach($browsers as $browser){ ?>
				<div style="margin:10px 0">
					<img src="<?php echo URL_IMG ?>/icon_<?php echo strtolower(str_replace(' ', '_', get_value($browser, 'browser_name')))?>.png" style="float:left;margin:2px 3px 0 0" />
					<div class="bold font_11"><?php echo get_value($browser, 'browser_name')?></div>
					<div style="width:100%;border:1px solid #8B7E66;height:25px;margin:5px 0 15px 0;box-shadow: 0px 0px 1px rgb(170,170,170);">
						<div class="font_11" style="float:right;margin:3px 3px 0 0;color:#333"><?php echo round(abs(get_value($browser, 'percent')), 2) . '% (' . get_value($browser, 'acessos') . ' ' . lang('acessos') . ')' ?></div>
						<div style="width:<?php echo abs(get_value($browser, 'percent'))?>%;background-color:#B0C4DE;height:25px;"></div>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php echo $this->template->end_box();?>
			
			<?php echo $this->template->start_box(lang('Usuários por Grupos'), URL_IMG . '/icon_group_user.png', 'min-height:250px;max-width:300px;margin-top:50px');?>
			<div id="groups_chart" style="width:100%;"></div>
			<?php echo $this->template->end_box();?>
		</td>
		<td id="column_filter" width="300" nowrap style="padding-left:60px;">
			<?php echo $this->template->start_box(lang('Tempo Médio de Carregamento'), URL_IMG . '/icon_gauge.png', 'min-height:250px;max-width:300px;');?>
			<div id="gauge_chart" style="width:100%;"></div>
			<?php echo $this->template->end_box();?>
			
			<?php echo $this->template->start_box(lang('Error Tracker'), URL_IMG . '/icon_bug.png', 'min-height:327px;width:300px;margin-top:50px');?>
			<?php if(count($error_types) > 0 ){?>
				<div style="height:10px;" id="controls_change_visualization">
					<img src="<?php echo URL_IMG ?>/icon_mono_list.png" style="float:right;margin-left:10px;cursor:pointer" title="<?php echo lang('Visualização em Lista') ?>" onclick="change_visualizacao_errors('lista')" />
					<img src="<?php echo URL_IMG ?>/icon_mono_chart.png" style="float:right;cursor:pointer" title="<?php echo lang('Visualização em Gráfico') ?>" onclick="change_visualizacao_errors('grafico')" />
				</div>
				<div id="errors_chart" style="width:100%;"></div>
				<div id="message_no_errors" style="display:none"><?php echo message('success', '', lang('Parabéns! Nenhum erro mapeado até o momento.')); ?></div>
				<div id="errors_lista" style="display:none;">
					<span class="font_11"><?php echo lang('Quantidade de erros distintos mapeados') . ': <span id="error_tracker_count_errors"></span>'; ?></span>
					<?php 
					$count_errors_total = 0;
					foreach($error_types as $error_type){ ?>
						<div id="error_type_<?php echo get_value($error_type, 'error_type') ?>" style="margin:10px 0 30px 0;">
							<div style="border-bottom:2px solid #8B1A1A;padding:3px 10px;background-color:#CD5C5C;cursor:pointer;box-shadow: 0px 0px 2px rgb(170,170,170);" onclick="show_area('<?php echo get_value($error_type, 'error_type'); ?>');show_area('<?php echo get_value($error_type, 'error_type'); ?>_controls')">
								<div class="font_11" style="float:right;margin:2px 0px 0 0;"><img src="<?php echo URL_IMG ?>/icon_bullet_plus.png" id="<?php echo get_value($error_type, 'error_type'); ?>_img" /></div>
								<span class="white font_shadow_black bold"><?php echo get_value($error_type, 'error_type'); ?></span>
							</div>
							<div id="<?php echo get_value($error_type, 'error_type'); ?>_controls" style="display:none;border-bottom:2px solid #333;padding:3px 10px;background-color:#666;" class="white font_shadow_black">
								<a href="javascript:void(0)" class="font_11" onclick="ajax_remove_all_log_errors('<?php echo get_value($error_type, 'error_type')?>')" style="color:white;"><?php echo lang('Remover Todos')?></a>
							</div>
							<div id="<?php echo get_value($error_type, 'error_type'); ?>" style="display:none;overflow-y:auto;max-height:200px;border-bottom:2px solid #B22222;">
								<?php $errors = $this->error->get_log_errors(get_value($error_type, 'error_type'), 10);?>
								<input type="hidden" id="error_count_<?php echo get_value($error_type, 'error_type') ?>" value="<?php echo count($errors) ?>" />
								<?php 
								foreach($errors as $error) { ?>
								<div id="error_tracker" class="font_11 error_tracker_<?php echo get_value($error, 'id_log_error')?>" style="padding:10px;">
									<div style="float:right;margin:-2px 0px 0 0;"><a href="javascript:void(0)" onclick="ajax_remove_log_error(<?php echo get_value($error, 'id_log_error')?>)"><?php echo lang('Remover') ?></a></div>
									<div><span class="bold"><?php echo lang('Em')?>: </span><span style="margin-bottom:5px"><?php echo get_value($error, 'log_dtt_ins')?></span></div>
									<div><span class="bold"><?php echo lang('Erro')?>: </span><span style="margin-bottom:5px"><?php echo get_value($error, 'header')?></span></div>
									<div><span class="bold"><?php echo lang('Mensagem')?>: </span><span style="margin-bottom:5px"><?php echo get_value($error, 'message')?></span></div>
								</div>
								<?php } ?>
							</div>
						</div>
					<?php 
					$count_errors_total += count($errors); 
					} ?>
					<input type="hidden" id="error_count" value="<?php echo $count_errors_total ?>" />
					<input type="hidden" id="error_all_lang_question" value="<?php echo lang("ATENÇÃO!\n\nDeseja realmente remover todos os logs de erros do tipo selecionado ?")?>" />
					<input type="hidden" id="error_all_lang_question_success" value="<?php echo lang("Registros de logs de erros removidos com sucesso.")?>" />
					<input type="hidden" id="error_lang_question" value="<?php echo lang("ATENÇÃO!\n\nDeseja realmente remover o log de erro selecionado ?")?>" />
					<input type="hidden" id="error_lang_question_success" value="<?php echo lang("Registro de log de erro removido com sucesso.")?>" />
					<input type="hidden" id="error_lang_question_error" value="<?php echo lang("Você não possui permissões para executar esta ação.")?>" />
					<script type="text/javascript" language="javascript">$('#error_tracker_count_errors').html($('#error_count').val())</script>
				</div>
			<?php } else { echo message('success', '', lang('Parabéns! Nenhum erro mapeado até o momento.')); }?>
			<?php echo $this->template->end_box();?>
		</td>
		</tr>
	</table>
</div>