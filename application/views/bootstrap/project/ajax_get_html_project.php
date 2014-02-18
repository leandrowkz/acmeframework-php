<div class="box-project">
	<table class="box-project-content">
		<tr>
			<td style="width:100px">
				<div class="project-logo">
					<img src="<?php echo get_value($project, 'url_img')?>" />
					<div id="controls-logo-<?php echo get_value($project, 'id_project') ?>" class="project-logo-controls bottom center" onclick="iframe_modal('<?php echo lang('Alterar logo de projeto')?>', '<?php echo URL_ROOT ?>/project/modal_project_change_logo/<?php echo get_value($project, 'id_project')?>', '<?php echo URL_IMG ?>/icon_project.png', 650, 480)"><?php echo lang('Alterar logo')?></div>
				</div>
				<!--
				<div class="center" style="width:102px;margin:20px 0 0 0">
					<img src="<?php echo URL_IMG ?>/icon_cog.png" style="margin:6px 0px 0 0" class="inline top" />
					<h6 class="inline top"><a href="javascript:void(0);" onclick="show_area_slide('box-project-controls-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('Gerenciar') ?></a></h6>
				</div>
				-->
			</td>
			<td style="width:98%">
				<h4 style="margin-top:-4px"><?php echo get_value($project, 'title') ?></h4>
				<div style="line-height:18px;"><?php echo character_limiter(nl2br(get_value($project, 'description')), 1500); ?></div>
			</td>
			<td class="center" style="min-width:170px !important;">
				<h3 style="letter-spacing:1px;margin-left:-10px;"><?php echo lang('Utilizado') ?></h3>
				<h1 class="inline top" style="margin:-30px 0 0 0 !important;font-size:104px !important;"><?php echo $this->project_lib->used_time_percentage(get_value($project, 'id_project')) ?></h1>
				<h4 class="inline top" style="margin:26px 0 0 3px">%</h4>
				<h6 style="margin-top:-20px"><?php echo lang('do tempo total estimado')?></h6>
			</td>
		</tr>
	</table>
	<div id="box-project-controls-<?php echo get_value($project, 'id_project')?>" class="box-project-controls">
		<a href="javascript:void(0);" onclick="show_area('box-project-activities-<?php echo get_value($project, 'id_project')?>')"><?php echo lang('Atividades')?></a>
		<a href="<?php echo URL_ROOT . '/' . $this->controller ?>/statistics/<?php echo get_value($project, 'id_project')?>?url=/project/dashboard"><?php echo lang('Detalhes / Estatísticas')?></a>
		<a href="javascript:void(0);" onclick="iframe_modal('<?php echo lang('Editar dados de projeto')?>', '<?php echo URL_ROOT ?>/project/modal_project_edit/<?php echo get_value($project, 'id_project')?>', '<?php echo URL_IMG ?>/icon_project.png', 800, 600)"><?php echo lang('Dados do Projeto')?></a>
		<!--<div onclick="show_area_slide('box-project-controls-<?php echo get_value($project, 'id_project')?>')"><img src="<?php echo URL_IMG ?>/icon_close_white.png" style="width:12px" /></div>-->
	</div>
	
	<?php $activities = $this->project_model->get_project_activities(get_value($project, 'id_project')); ?>
	<div id="box-project-activities-<?php echo get_value($project, 'id_project')?>" class="box-project-activities with_shadow">
		<div style="height:4px;background-color:#fff;margin:-6px -3px 0 -3px"></div>
		<div class="triangle-top-border"></div>
		<div class="triangle-top"></div>
		
		<!-- LINK PARA NOVA ATIVIDADE -->
		<?php $style = (count($activities) > 0) ? 'margin:20px 20px -10px 25px;' : 'margin:20px 20px 20px 20px;'; ?>
		<h6 style="<?php echo $style;?>"><a href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Nova Atividade')?>', '<?php echo URL_ROOT ?>/activity/modal_activity_new/<?php echo get_value($project, 'id_project')?>', '<?php echo URL_IMG ?>/icon_activity.png', 695, 530)"><?php echo lang('Nova atividade...')?></a></h6>
		
		<!-- CARREGA ATIVIDADES VIA AJAX -->
		<div id="box-project-activity-container-<?php echo get_value($project, 'id_project') ?>" style="margin:20px"></div>
		
		<?php foreach($activities as $activity) { ?>
		<script type="text/javascript" language="javascript"> load_activity_line(<?php echo get_value($activity, 'id_activity') ?>, <?php echo get_value($project, 'id_project') ?>); </script>
		<?php } ?>
	</div>
</div>