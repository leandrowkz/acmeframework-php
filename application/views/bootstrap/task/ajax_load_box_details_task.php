<table>
<td style="min-width:550px !important;">
	<h5><?php echo lang('Histórico / Andamento da Tarefa')?></h5>
	<hr style="margin:5px 0 0 0;" />
	<?php if(strtolower(get_value($task, 'situation')) != 'finalizada') { ?>
	<button class="mini-control green" style="float:right;margin:-32px 0 15px 0 !important" onclick="show_area_slide('box-new-history-custom-<?php echo get_value($task, 'id_task')?>');"><?php echo lang('Inserir Andamento / Finalizar')?></button>
	<!--div class="font_11" style="float:right;margin:-27px 15px 15px 0 !important"><a href="javascript:void(0)"><?php echo lang('Inserir Andamento')?></a></div-->
	<div class="box-new-history-custom" id="box-new-history-custom-<?php echo get_value($task, 'id_task')?>">
		<div class="font_11" style="margin:0 0 10px 85px;width:400px;line-height:18px;">
			<img src="<?php echo URL_IMG ?>/icon_info.png" style="float:left;margin:4px 5px 0 0" />
			<?php echo lang('Insira abaixo uma mensagem de finalização da tarefa. Após a postagem, a tarefa será marcada como finalizada.')?>
		</div>
		<div class="inline top" style="width:80px">
		<img src="<?php echo $this->session->userdata('user_img')?>" style="width:50px;" />
		</div>
		<div class="box-comment-new inline top font_11">
			<div class="triangle-left-border"></div>
			<div class="triangle-left"></div>
			<textarea id="comment-<?php echo get_value($task, 'id_task')?>" placeholder="<?php echo lang('Insira seu comentário aqui...')?>"></textarea>
			<div style="border-top:1px dashed #ccc;margin:5px 0;padding-top:5px;">
				<input type="hidden" id="id-task-<?php echo get_value($task, 'id_task')?>" value="<?php echo get_value($task, 'id_task')?>" />
				<input type="hidden" id="id-user-<?php echo get_value($task, 'id_task')?>" value="<?php echo $this->session->userdata('id_user')?>" />
				<input type="text" id="time-<?php echo get_value($task, 'id_task')?>" alt="time" value="00:00" />
				<div class="inline top comment" style="margin:3px 0 0 5px"><?php echo lang('Informe o tempo utilizado neste andamento') ?>.</div>
				<button class="mini-control green" style="float:right;margin-top:35px !important;" onclick="ajax_post_comment_dashboard(<?php echo get_value($task, 'id_task') ?>)"><?php echo lang('Postar') ?></button>
				<div style="margin-top:5px;">
					<input type="checkbox" id="finalizar-<?php echo get_value($task, 'id_task')?>" value="S" style="margin:10px 4px 0 0" />
					<div class="inline top bold" style="margin:8px 0 0 0px"><label for="finalizar-<?php echo get_value($task, 'id_task')?>"><?php echo lang('Quero finalizar esta tarefa.') ?></label></div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="box-history-class" id="box-history-<?php echo get_value($task, 'id_task')?>"></div>
	<script type="text/javascript" language="javascript"> ajax_load_box_comments(<?php echo get_value($task, 'id_task')?>); </script>
</td>
<td style="width:99%;padding:0 10px 0 70px;">
	<h3 class="inline top" style="cursor:default;margin:-6px 0 0 0" title="<?php echo lang('Título da Tarefa')?>"><?php echo get_value($task, 'title')?></h3>
	<!--
	<div class="inline top font_11" style="float:right;margin:11px 2px 0 15px !important">
		<a href="javascript:void(0)" onclick="show_area_slide('details-task-box-right-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('Visualizar Detalhes')?></a>
		<img src="<?php echo URL_IMG ?>/bullet_arrow_down.png" style="float:right;margin:-9px 0 0 4px" />
	</div>
	-->
	<hr style="margin:-2px 0 0 0;" />
	<div id="details-task-box-right-<?php echo get_value($task, 'id_task')?>" style="padding:8px 15px 30px 1px;line-height:25px;" class="font_11">
		<div class="bold inline top" style="width:150px"><?php echo lang('Projeto / Atividade')?>:</div>
		<div class="inline top"><?php echo get_value($activity, 'project_title') ?> > <?php echo get_value($activity, 'title') ?></div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Situação atual')?>:</div>
		<div class="inline top">
			<?php if(strtolower(get_value($task, 'situation')) == 'finalizada') { ?>
			<h5 class="inline top font_green" style="margin:0"><?php echo lang('Tarefa finalizada!'); ?></h5>
			<img class="inline top" src="<?php echo URL_IMG ?>/icon_success.png" style="margin:5px 0 0 2px" />
			<?php } else { echo get_value($task, 'situation'); }?>
		</div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Prioridade')?>:</div>
		<div class="inline top">
			<div class="inline top"><?php echo get_value($task, 'priority'); ?></div>
			<div class="inline top" style="margin-top:5px;"><img src="<?php echo URL_IMG ?>/icon_bullet_priority_<?php echo get_value($task, 'priority'); ?>.png" /></div>
		</div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Estimativa em horas')?>:</div>
		<div class="inline top"><?php echo substr(get_value($task, 'estimate'), 0, 5) ?> <?php echo lang('horas')?></div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Tempo utilizado')?>:</div>
		<div class="inline top"><?php echo substr($total_time_spended, 0, 5); ?> <?php echo lang('horas')?> (<strong style="cursor:default;" title="<?php echo $percentage_task . '% ' . lang('do tempo estimado') ?>"><?php echo $percentage_task ?>%</strong>)</div>
		<br />
		<div class="bold inline top" style="width:150px;margin-top:3px;<?php echo ($delayed && strtolower(get_value($task, 'situation')) == 'aberta') ? 'color:#B22222;' : ''?>"><?php echo lang('Previsão de início')?>:</div>
		<div class="inline top" style="margin-top:3px;<?php echo ($delayed && strtolower(get_value($task, 'situation')) == 'aberta') ? 'color:#B22222;"' : ''?>"><?php echo to_human_date(get_value($task, 'ini_prev')); ?></div>
		<?php if($delayed && (get_value($task, 'situation')) == 'aberta') {?>
		<h5 class="inline top font_warning" style="margin:2px 0 0 5px;"><?php echo lang('Tarefa atrasada!')?></h5>
		<img src="<?php echo URL_IMG ?>/icon_warning.png" style="margin:7px 0 0 2px" />
		<?php } ?>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Termina em')?>:</div>
		<div class="inline top"><?php echo to_human_date(get_value($task, 'end_prev')); ?></div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Usuário responsável')?>:</div>
		<div class="inline top">
			<a class="inline top" style="margin-top:-1px;" href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Perfil de usuário')?>', '<?php echo URL_ROOT ?>/project/modal_user_profile/<?php echo get_value($task, 'id_user_responsible')?>', '<?php echo URL_IMG ?>/icon_user_profile.png', 800, 600)" title="<?php echo lang('Clique para visualizar o perfil')?>"><?php echo get_value($task, 'login_responsible'); ?></a>
			<?php if($this->session->userdata('id_user') == get_value($task, 'id_user_responsible')) {?>
			<div class="inline top" style="margin-top:5px;line-height:10px;"><div class="inline top bold msg-user-type responsible" title="<?php echo lang('Sou Responsável')?>">R</div></div>
			<?php } ?>
		</div>
		<br />
		<div class="bold inline top" style="width:150px"><?php echo lang('Usuário executor')?>:</div>
		<div class="inline top">
			<a class="inline top" style="margin-top:-1px;" href="javascript:void(0)" onclick="iframe_modal('<?php echo lang('Perfil de usuário')?>', '<?php echo URL_ROOT ?>/project/modal_user_profile/<?php echo get_value($task, 'id_user_executor')?>', '<?php echo URL_IMG ?>/icon_user_profile.png', 800, 600)" title="<?php echo lang('Clique para visualizar o perfil')?>"><?php echo get_value($task, 'login_executor'); ?></a>
			<?php if($this->session->userdata('id_user') == get_value($task, 'id_user_executor')) {?>
			<div class="inline top" style="margin-top:5px;line-height:10px;"><div class="inline top bold msg-user-type executor" title="<?php echo lang('Sou Executor')?>">E</div></div>
			<?php } ?>
		</div>
		<div style="margin-top:10px;">
			<div style="margin-top:5px" class="inline top">
				<button class="mini-control green" onclick="redirect('<?php echo URL_ROOT ?>/task/form_update/<?php echo get_value($task, 'id_task')?>/?url=/task/dashboard')"><?php echo lang('Editar Tarefa') ?></button>
			</div>
			<?php if(get_value($task, 'situation') == 'finalizada') {?>
			<div style="margin:5px 0 0 15px;" class="inline top">
				<button class="mini-control green" onclick="redirect('<?php echo URL_ROOT ?>/task/form_reopen/<?php echo get_value($task, 'id_task')?>/?url=/task/user_statistics')"><?php echo lang('Reabrir Tarefa') ?></button>
			</div>
			<?php } ?>
		</div>
	</div>
	
	<h5 style="margin:0 0 5px 0"><?php echo lang('Descrição da Tarefa')?></h5>
	<hr />
	<div style="color:#333;padding:10px 15px 15px 1px" title="<?php echo lang('Descrição da Tarefa')?>">
		<?php if(strlen(get_value($task, 'description')) > 600) { ?>
		<div class="comment"><?php echo character_limiter(nl2br(get_value($task, 'description')), 600) ?> <a href="javascript:void(0)" onclick="show_area('view-description-task-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('Veja mais')?></a></div>
		<div id="view-description-task-<?php echo get_value($task, 'id_task')?>" style="display:none;border-top:1px dotted #aaa;margin-top:20px;padding-top:15px;"><?php echo nl2br(get_value($task, 'description')) ?> <a href="javascript:void(0)" onclick="show_area('view-description-task-<?php echo get_value($task, 'id_task')?>')"><?php echo lang('menos')?></a></div>
		<?php } elseif(strlen(get_value($task, 'description')) > 0) { ?>
		<div id="view-description-task-<?php echo get_value($task, 'id_task')?>"><?php echo nl2br(get_value($task, 'description')) ?></div>
		<?php } else { ?>
		<div class="comment italic"><?php echo lang('Nenhuma descrição disponível para esta tarefa.');?></a></div>
		<?php } ?>
	</div>
</td>
</table>
<script type="text/javascript" language="javascript">
	<?php if(strtolower(get_value($task, 'situation')) != 'finalizada') { ?>
	$('#comment-<?php echo get_value($task, 'id_task')?>').autosize();
	<?php } ?>
	enable_masks();
</script>