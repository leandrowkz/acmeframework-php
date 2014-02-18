<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo $this->template->load_array_config_css_files(); ?>
<?php echo $this->template->load_js_file('highcharts.3.0.2/js/highcharts.js')?>
<?php echo $this->template->load_js_file('highcharts.3.0.2/js/highcharts-more.js')?>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	// CHART AXIS
	// ACESSOS POR BROWSERS NOS ULTIMOS 6 MESES
	$('#browsers_chart').highcharts({
		title: {
			text: ''               
		},
		
		 chart: {
            type: 'line',
			height:300,
        },
		
		xAxis: { 
			categories: [  
				<?php	
					$meses="";
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_6') )."',"; 
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_5') )."',"; 
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_4') )."',"; 
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_3') )."',"; 
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_2') )."',"; 
					$meses.= "'".$this->app_date->get_month_to_words( get_value($browser_rank[0], 'nome_mes_1') )."',"; 									
					echo trim($meses, ',');
				?>
			]
		},	

		yAxis: {
			title: {
				text: '<?php echo lang('Acessos')?>'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}],
			min: 0
		},
		series: [
			<?php 
			$series = '';
			$ant_browser = '';
			$fecha_data = false;
			foreach($browser_rank as $browser) {
				$series .="
					{
					allowPointSelect: true,
					size: '100%',
					type: 'line',
					name: '".  get_value($browser, 'browser_name')."',
					data: [ ". get_value($browser, '6').",".
								  get_value($browser, '5').",".
								  get_value($browser, '4').",".
								  get_value($browser, '3').",".
								  get_value($browser, '2').",".
								  get_value($browser, '1')." ] },";					
			}			
			echo trim($series, ',');
			?>
		]
    });
});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">			
			<h2 style="color:#000; border-bottom:1px solid #999;border-bottom:0px !important;" class="inline top font_shadow_gray"><?php echo lang('Perfil de Usuário') ?></h2>
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Perfil de Usuário')?>" style="margin:-7px 0 0 -15px">
				<div class="inline top comment" style="margin:12px 0 0 8px"><a href="<?php echo $this->session->userdata('url_default') ?>"><?php echo lang('Ir Para a pagina inicial')?></a></div>
			</div>
		</div>		
	</div>
	
	<div id="triangle" style="left:40px;position:relative; top:-25px;" ></div>
	
	<table id="tbl_perfil" style="width:100%;margin-top:-25px;">
		<tr>
		<td style="width: 120px; background-color: #e9e9e9;">
			<div style="width: 80px; height: 80px; margin: 28px 20px 15px 20px;">
				<img style="width:80px;height:80px;" src="<?php echo eval_replace($user_img); ?>" />
			</div>
			<div style="margin: 0 20px 20px 20px;">								
				<?php if($editable){  ?>
				<button class="mini" style="width:80px" onclick="redirect('<?php echo URL_ROOT ?>/acme_user/user_profile_photo_upload/<?php echo $id_user; ?>')"><?php echo lang('Editar Foto') ?></button>
				<?php } ?>
			</div>
		</td>		
		<td style="background-color: #f5f5f5;">
			<div style="margin: 20px 20px 20px 20px;">
				<?php if($editable){  ?>
				<a href="javascript:void(0);" class="black" onclick="iframe_modal('<?php echo lang('Editar Dados')?>', '<?php echo URL_ROOT ?>/acme_user/ajax_modal_data_edit/<?php echo $id_user; ?>', '<?php echo URL_IMG ?>/icon_update.png', 700, 550)" title="<?php echo lang('Editar Dados do Usuário')?>">
					<h4 class="inline"><?php echo $name ?></h4>
					<img src="<?php echo URL_IMG ; ?>/icon_bullet_edit.png" style="margin-left:5px" />
				</a>
				<h5 style="float:right;margin:7px 2px 0 0"><a href="javascript:void(0);" onclick="iframe_modal('<?php echo lang('Alterar Senha')?>', '<?php echo URL_ROOT ?>/acme_user/ajax_change_password/<?php echo $id_user; ?>', '<?php echo URL_IMG ?>/icon_reset_password.png', 700, 550)" style="float:right"><?php echo lang('Alterar Senha') ?></a></h5>
				<img style="float:right;margin:13px 7px 0 0" src="<?php echo URL_IMG ; ?>/icon_reset_password.png" />
				<?php } else { ?>
					<h4 class="inline"><?php echo $name ?></h4>
				<?php } ?>
				<div id="box_group_view" style="margin: 10px 0 0 0;">
					<div class="odd">
						<div id="label_view" class="inline"><?php echo lang('Email'); ?></div>
						<div id="field_view" class="inline"><?php echo $email; ?></div>
					</div>                                                                                           
					<div class="">                                                                                   
						<div id="label_view" class="inline"><?php echo lang('Login'); ?></div>                               
						<div id="field_view" class="inline"><?php echo $login; ?></div>
					</div>                                                                          
					<div class="odd">                                                                  
						<div id="label_view" class="inline"><?php echo lang('Grupo'); ?></div>              
						<div id="field_view" class="inline"><?php echo $group; ?></div>
					</div>
					<div class="">                                                               
						<div id="label_view" class="inline"><?php echo lang('Idioma Padrão'); ?></div>       
						<div id="field_view" class="inline">
						<?php 
							switch($lang_default)
							{
								case 'pt_BR':
									echo lang('Português (Brasil)');
								break;
								
								case 'en_US':
									echo lang('Inglês (Estados Unidos)');
								break;
								
								default:
									echo lang('Português (Brasil)');
								break;
							} 
						?>
						</div>
					</div>  
					<div class="odd">                                                               
						<div id="label_view" class="inline"><?php echo lang('Pagina Inicial'); ?></div>       
						<div id="field_view" class="inline"><?php echo eval_replace($url_default); ?></div>
					</div>                                                                          
				</div>
				<h5 style="margin-top:45px;"><?php echo lang('Estatísticas de Acesso')?></h5>
				<hr style="margin-bottom:15px;">
				<div id="browsers_chart" style="width:100%;border: 1px solid #AAAAAA; box-shadow: 0 0 2px #969696; line-height: 20px !important;"></div>
			</div>
		</td>
		</tr>
	</table>	

	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo $this->session->userdata('url_default'); ?>'"><?php echo lang('Ir para Pagina Inicial')?></button></div>		
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="window.history.back();"><?php echo lang('voltar')?></a></div>
	</div>
</div>