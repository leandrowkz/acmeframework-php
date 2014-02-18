<?php echo load_js_file('autosize/jquery.autosize.js'); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		enable_form_validations();
		enable_masks();
		
		// Focus no campo comentário
		$('#comment-<?php echo get_value($task, 'id_task')?>').focus();
		
		// AUTOSIZE MT DAORA!
		$('#comment-<?php echo get_value($task, 'id_task')?>').autosize();
		
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
		padding:7px 10px 10px 10px;
		border:1px solid #888;
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
	
	#box-new-history {
		background-color:#E0EEEE;
		border-bottom:1px solid #ddd;
		margin:15px 0 30px 0;
		padding:20px 10px 20px 10px;
		display:none;
	}
	
	.box-comment {
		position:relative;
		text-align:left;
		background-color:#f5f5f5 !important ;
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
		border-left: 23px solid #f5f5f5;
		border-bottom: 15px solid transparent;
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
			<div class="inline top module_menu_item" title="<?php echo lang('Finalizar Tarefa')?>" style="margin:-19px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Finalizar Tarefa') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>

		</div>
	</div>
	
	<!-- DETAILS TAREFA E HISTORICO -->
	<table style="margin-top:25px">
	<tr>
	<td style="width:99%">
		<div id="box_group_view" class="inline top" style="width:100%">
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
	</td>
	<td style="width:250px;min-width:250px;padding:0 25px 0 40px;">
		<div class="box-details-right inline top font_11" style="width:100%;margin-right:30px !important;">
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
	</td>
	</tr>
	</table>
	
	<!-- MENSAGEM DE REABERTURA  -->
	<h6 class="inline top" style="margin:40px 0 0 0"><?php echo lang('Mensagem de Reabertura') ?></h6>
	<div class="inline top font_11" style="float:right;margin:42px 0 0 10px">
		<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" style="float:right;margin:4px 0 0 1px" />
		<a href="javascript:void(0)" onclick="show_area_slide('box-history-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('Veja o histórico desta tarefa')?></a>
	</div>
	<hr style="margin-bottom:10px" />
	<?php echo message('info', '', lang('Insira uma mensagem de finalização da tarefa. É obrigatório que esta mensagem possua informação de tempo utilizado.'));?>
	<div style="margin-top:20px;">
		<div class="inline top" style="width:80px">
		<img src="<?php echo $this->session->userdata('user_img')?>" style="width:50px;" />
		</div>
		<div class="box-comment-new inline top font_11">
			<div class="triangle-left-white-border"></div>
			<div class="triangle-left-white" style="border-right:23px solid #fff"></div>
			<textarea id="comment" placeholder="<?php echo lang('Insira seu comentário aqui...')?>"></textarea>
			<div style="border-top:1px dashed #ccc;margin:5px 0;padding-top:5px;">
				<input type="hidden" id="id_task" value="<?php echo get_value($task, 'id_task')?>" />
				<input type="hidden" id="id_user" value="<?php echo $this->session->userdata('id_user')?>" />
				<input type="text" id="time" alt="time" value="00:00" />
				<div class="inline top comment" style="margin:3px 0 0 5px">
					<div><?php echo lang('Informe o tempo utilizado neste andamento') ?>.</div>
				</div>
				<button class="mini-control green" style="float:right;" onclick="javascript:if(ajax_post_comment_history_finalize()==true){redirect('<?php echo URL_ROOT . $url_redirect?>');}"><?php echo lang('Postar') ?></button>
			</div>
		</div>
	</div>
	
	<!-- CAIXA ONDE FICARÃO COMENTÁRIOS/ANDAMENTOS/HISTÓRICO  -->
	<div id="box-history-<?php echo get_value($task, 'id_task')?>" style="display:none;margin-top:30px;border-top:1px dashed #888;padding-top:15px;"></div>
	
	<!-- CARREGA HISTÓRICO DA TAREFA -->
	<script type="text/javascript" language="javascript"> ajax_load_box_comments(<?php echo get_value($task, 'id_task')?>); </script>
	
	<div style="margin-top:30px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT . $url_redirect ?>')"><?php echo lang('Voltar')?></button></div>
	</div>
</div>
