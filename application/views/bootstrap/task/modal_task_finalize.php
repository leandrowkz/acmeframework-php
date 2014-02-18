<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<?php echo load_js_file('autosize/jquery.autosize.js'); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			enable_form_validations();
			enable_masks();
			
			// Focus no campo comentário
			$('#comment').focus();
			
			// Remove caixa de novo comentario carregada via ajax
			$('#box-new-history').remove();
		});		
	</script>
	<style type="text/css">
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
		
		#label_view {
			width:100% !important;
			cursor:default;
		}
		
		#task-description, #project-description {
			right:0%;
			position:absolute;
			padding:5px;
			background-color:#fff;
			margin:-35px 0 0 0;
			display:none;
		}
		
		.box-details-right {
			background-color:#f5f5f5;
			margin-left:25px;
			padding:7px 10px 10px 10px;
			border:1px solid #888;
			width:225px;
			/*min-height:90px;*/
			line-height:20px;
			-moz-box-shadow:0 0 2px 1px #999;
			-webkit-box-shadow: 0 0 2px #999;
			box-shadow: 0px 0px 2px rgb(150,150,150);
		}
		
		.line-history {
			width:100%;
			margin-bottom:30px
		}
		
		#box-new-history-custom {
			background-color:#FAFAD2;
			border-bottom:1px solid #ddd;
			margin:-15px 0 0px 0;
			padding:15px 10px 20px 10px;
		}
		
		#box-new-history {
			background-color:#E0EEEE;
			border-bottom:1px solid #ddd;
			margin:15px 0 30px 0;
			padding:20px 10px 20px 10px;
			display:none;
		}
		
		.box-comment {
			position:relative;
			background-color:#f5f5f5 !important;
			padding:10px;
			line-height:18px;
			min-width:550px;
			border:1px solid #888;
			-moz-box-shadow:0 0 2px 1px #999;
			-webkit-box-shadow: 0 0 2px #999;
			box-shadow: 0px 0px 2px rgb(150,150,150);
		}
		
		.box-comment-new {
			position:relative;
			background-color:#fff;
			padding:5px 8px;
			line-height:18px;
			min-width:554px;
			border:1px solid #888;
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
		
		.box-comment-new input { 
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
			border-right: 23px solid #f5f5f5;
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
			border-right: 23px solid #f5f5f5;
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
	</style>
</head>
<body>
	<?php echo get_input_configurations(); ?>
	<div id="modal_content">
		<!-- DETAILS TAREFA E HISTORICO -->
		<div id="box-finalize">
			<div id="box_group_view" class="inline top" style="width:460px;">
				<div style="position:relative;">
					<div id="label_view" onmouseover="show_area('project-description')" onmouseout="show_area('project-description')"><h6 style="margin-top:0px;color:#555;"><?php echo get_value($activity, 'project_title'); ?> > <?php echo get_value($activity, 'title'); ?></h6></div>
					<div id="project-description" class="comment font_11">(<?php echo lang('Projeto / Atividade')?>)</div>
				</div>
				<div class="odd" style="position:relative;">
					<div id="label_view"><h5  onmouseover="show_area('task-description')" onmouseout="show_area('task-description')"><?php echo get_value($task, 'title') ?></h5></div>
					<div id="task-description" class="comment font_11" style="background-color:#f5f5f5">(<?php echo lang('Tarefa')?>)</div>
				</div>
				<div>
					<div class="font_11" style="padding:5px 10px;">
						<?php if(strlen(get_value($task, 'description')) > 200) { ?>
						<div class="comment"><?php echo character_limiter(get_value($task, 'description'), 200) ?> <a href="javascript:void(0)" onclick="show_area('view-description-task')"><?php echo lang('Veja mais')?></a></div>
						<div id="view-description-task" style="display:none;border-top:1px dashed #aaa;margin-top:10px;padding-top:5px;"><?php echo nl2br(get_value($task, 'description')) ?> <a href="javascript:void(0)" onclick="show_area('view-description-task')"><?php echo lang('menos')?></a></div>
						<?php } elseif(strlen(get_value($task, 'description')) > 0) { ?>
						<div id="view-description-task"><?php echo nl2br(get_value($task, 'description')) ?></div>
						<?php } else { ?>
						<div class="comment italic"><?php echo lang('Nenhuma descrição disponível para esta tarefa.');?></a></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="box-details-right inline top font_11">
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
				<div style="margin-bottom:5px;"><?php echo lang('Tarefa')?> <strong><?php echo lang(get_value($task, 'situation')) ?></strong>, <?php echo lang('de prioridade')?> <strong><?php echo lang(get_value($task, 'priority'))?></strong>.</div>
				<div style="margin-bottom:10px;"><a href="javascript:void(0)" onclick="show_area('view-details-task')"><?php echo lang('Veja mais sobre esta tarefa')?></a></div>
				<div id="view-details-task" style="display:none;padding-top:5px;border-top:1px dotted #888;">
					<div <?php echo ($delayed && strtolower(get_value($task, 'situation')) == 'aberta') ? 'style="color:#B22222"' : ''?>><strong><?php echo lang('Inicia em')?>: </strong> <?php echo to_human_date(get_value($task, 'ini_prev'))?></div>
					<div style="margin-bottom:5px;"><strong><?php echo lang('Prev. término')?>: </strong> <?php echo to_human_date(get_value($task, 'end_prev'))?></div>
					<div><strong><?php echo lang('Estimativa em horas')?>: </strong> <?php echo substr(get_value($task, 'estimate'), 0, 5)?> <?php echo lang('horas')?></div>
					<div><strong><?php echo lang('Tempo utilizado')?>: </strong> <?php echo substr($total_time_spended, 0, 5); ?> <?php echo lang('horas')?> (<strong style="cursor:default;" title="<?php echo $percentage_task . '% ' . lang('do tempo estimado') ?>"><?php echo $percentage_task ?>%</strong>)</div>
					<div style="margin-top:5px;"><strong><?php echo lang('Quem é o responsável')?>: </strong> <?php echo get_value($task, 'login_responsible'); ?></div>
					<div><strong><?php echo lang('Quem está executando')?>: </strong> <?php echo get_value($task, 'login_executor'); ?></div>
				</div>
			</div>
		
			<!-- MENSAGEM DE FINALIZAÇÃO -->
			<h6 class="inline top" style="margin:30px 0 0 0"><?php echo lang('Mensagem de Finalização da Tarefa') ?></h6>
			<div class="inline top font_11" style="float:right;margin:32px 0 0 10px">
				<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" style="float:right;margin:4px 0 0 1px" />
				<a href="javascript:void(0)" onclick="show_area_slide('box-history-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('Veja o histórico desta tarefa')?></a>
			</div>
			<hr style="margin-bottom:10px" />
			<div class="font_11"><?php echo message('info', '', lang('Insira uma mensagem de finalização da tarefa. É obrigatório que esta mensagem possua informação de tempo utilizado.'));?></div>
			<div style="margin-top:20px">
				<div class="inline top" style="width:80px">
				<img src="<?php echo $this->session->userdata('user_img')?>" style="width:50px;" />
				</div>
				<div class="box-comment-new inline top font_11">
					<div class="triangle-left-white-border"></div>
					<div class="triangle-left-white" style="border-right: 23px solid #fff;"></div>
					<textarea id="comment" placeholder="<?php echo lang('Insira seu comentário aqui...')?>"></textarea>
					<div style="border-top:1px dashed #ccc;margin:5px 0;padding-top:5px;">
						<input type="hidden" id="id_task" value="<?php echo get_value($task, 'id_task')?>" />
						<input type="hidden" id="id_user" value="<?php echo $this->session->userdata('id_user')?>" />
						<input type="text" id="time" alt="time" value="00:00" />
						<div class="inline top comment" style="margin:3px 0 0 5px">
							<div><?php echo lang('Informe o tempo utilizado neste andamento') ?>.</div>
						</div>
						<button class="mini-control green" style="float:right;" onclick="ajax_post_comment_history_finalize()"><?php echo lang('Postar') ?></button>
					</div>
				</div>
			</div>
			
			<!-- CAIXA ONDE FICARÃO COMENTÁRIOS/ANDAMENTOS/HISTÓRICO  -->
			<div id="box-history-<?php echo get_value($task, 'id_task')?>" style="display:none;margin-top:30px;border-top:1px dashed #888;padding-top:15px;"></div>
		</div>
		
		<div id="msg-finalize" class="font_11" style="display:none;"><?php echo message('success', lang('Feito!'), lang('Tarefa finalizada com sucesso! Clique ') . '<a href="javascript:void(0);" onclick="parent.close_modal();">' . lang('aqui') . '</a> ' . lang('para fechar essa janela.')) ?></div>
		
		<!-- CARREGA HISTÓRICO DA TAREFA -->
		<script type="text/javascript" language="javascript"> ajax_load_box_comments(<?php echo get_value($task, 'id_task')?>); </script>
		
		<div style="margin-top:30px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal();"><?php echo lang('Fechar')?></button></div>
		</div>
	</div>
</body>
</html>
