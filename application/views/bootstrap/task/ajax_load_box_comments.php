<div id="box-new-history">
	<div class="inline top" style="width:80px">
	<img src="<?php echo $this->session->userdata('user_img')?>" style="width:50px;" />
	</div>
	<div class="box-comment-new inline top font_11">
		<div class="triangle-left-white-border"></div>
		<div class="triangle-left-white"></div>
		<textarea id="comment" placeholder="<?php echo lang('Insira seu comentário aqui...')?>"></textarea>
		<div style="border-top:1px dashed #ccc;margin:5px 0;padding-top:5px;">
			<input type="hidden" id="id_task" value="<?php echo get_value($task, 'id_task')?>" />
			<input type="hidden" id="id_user" value="<?php echo $this->session->userdata('id_user')?>" />
			<input type="text" id="time" alt="time" value="00:00" />
			<div class="inline top comment" style="margin:3px 0 0 5px">
				<div><?php echo lang('Informe o tempo utilizado neste andamento') ?>. <a href="javascript:void(0)" onclick="show_area('details-saiba-mais-history')"><?php echo lang('Saiba mais')?></a></div>
				<div id="details-saiba-mais-history" style="display:none;width:435px"><?php echo lang('Caso você não informe o tempo utilizado, isto é, deixe o valor "00:00", o registro será interpretado como um comentário à tarefa, apenas, e irá ser exibido com o ícone ') ?><img src="<?php echo URL_IMG ?>/icon_comment.png" />.</div>
			</div>
			<button class="mini-control green" style="float:right;" onclick="ajax_post_comment_history()"><?php echo lang('Postar') ?></button>
		</div>
	</div>
</div>
<?php 
if(count($course) > 0) {
	$i = 0;
	foreach($course as $history) {
	$user_img = (get_value($history, 'url_img') != '') ? eval_replace(get_value($history, 'url_img')) : URL_IMG . '/avatar_user_unknown.png';
	$is_left = ($i % 2 == 0 ) ? true : false;
	?>
		<?php if($is_left) { ?>
		<div class="line-history" id="line-history-<?php echo get_value($history, 'id_task_history')?>">
			<div class="inline top" style="width:80px">
			<img src="<?php echo $user_img; ?>" style="width:50px;" />
			</div>
			<div class="box-comment inline top font_11">
				<div class="triangle-left-border"></div>
				<div class="triangle-left"></div>
				<?php if(get_value($history, 'time') != '00:00:00') {?>
					<div class="left font_11 task-balloon-estimate" id="task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>">
						<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
						<div><?php echo lang('Usuário informou que utilizou ') . substr(get_value($history, 'time'), 0, 5) . ' ' . lang('horas neste andamento') ?>.</div>
					</div>
					<h6 onmouseover="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" onmouseout="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" style="cursor:default;float:right;margin:0 0 0 0"><?php echo substr(get_value($history, 'time'), 0, 5); ?></h6>
					<?php } else { ?>
					<div class="left font_11 task-balloon-estimate" id="task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>" style="margin:-5px 40px 0 0;width:210px;">
						<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
						<div><?php echo lang('Registro de comentário / histórico, apenas') ?>.</div>
					</div>
					<div onmouseover="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" onmouseout="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" style="cursor:default;float:right;margin:0 0 0 0"><img src="<?php echo URL_IMG ?>/icon_comment.png" /></div>
				<?php } ?>
				<div><strong><?php echo get_value($history, 'login') ?></strong> <span class="comment"><?php echo lang('em') . ' ' . to_human_date(get_value($history, 'log_dtt_ins')) . ' ' . lang('as') . ' ' . substr(get_value($history, 'log_dtt_ins'), 10, 6)?> :</span></div>
				<div style="margin-top:3px;"><?php echo nl2br(get_value($history, 'comment'))?></div>
				<?php if(get_value($history, 'comment_system') != '') {?>
				<div style="margin-top:10px;border-top:1px dashed #ccc;padding-top:3px;" class="comment"><?php echo nl2br(get_value($history, 'comment_system'))?></div>
				<?php } ?>
				<?php if(get_value($history, 'id_user') == $this->session->userdata('id_user') && get_value($task, 'situation') != 'finalizada'){?>
				<div style="float:left;margin:5px 0 0 0"><a href="javascript:void(0);" onclick="ajax_delete_comment_history(<?php echo get_value($history, 'id_task_history') ?>, <?php echo get_value($task, 'id_task')?>)"><?php echo lang('Excluir comentário')?></a></div>
				<?php } ?>
			</div>
		</div>
		<?php } else { ?>
		<div class="right line-history" id="line-history-<?php echo get_value($history, 'id_task_history')?>">
			<div class="box-comment inline top font_11 left" style="background-color:#fff;">
				<div class="triangle-right-border"></div>
				<div class="triangle-right"></div>
				<?php if(get_value($history, 'time') != '00:00:00') {?>
					<div class="left font_11 task-balloon-estimate" id="task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>">
						<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
						<div><?php echo lang('Usuário informou que utilizou ') . substr(get_value($history, 'time'), 0, 5) . ' ' . lang('horas neste andamento') ?>.</div>
					</div>
					<h6 onmouseover="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" onmouseout="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" style="cursor:default;float:right;margin:0 0 0 0"><?php echo substr(get_value($history, 'time'), 0, 5); ?></h6>
					<?php } else { ?>
					<div class="left font_11 task-balloon-estimate" id="task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>" style="margin:-5px 40px 0 0;width:210px;">
						<img src="<?php echo URL_IMG ?>/icon-arrow-balloon-right.png">
						<div><?php echo lang('Registro de comentário / histórico, apenas') ?>.</div>
					</div>
					<div onmouseover="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" onmouseout="show_area('task-balloon-estimate-<?php echo get_value($history, 'id_task_history')?>')" style="cursor:default;float:right;margin:0 0 0 0"><img src="<?php echo URL_IMG ?>/icon_comment.png" /></div>
				<?php } ?>
				<div><strong><?php echo get_value($history, 'login') ?></strong> <span class="comment"><?php echo lang('em') . ' ' . to_human_date(get_value($history, 'log_dtt_ins')) . ' ' . lang('as') . ' ' . substr(get_value($history, 'log_dtt_ins'), 10, 6)?> :</span></div>
				<div style="margin-top:3px;"><?php echo nl2br(get_value($history, 'comment'))?></div>
				<?php if(get_value($history, 'comment_system') != '') {?>
				<div style="margin-top:5px;border-top:1px dashed #ccc;padding-top:5px;" class="comment"><?php echo nl2br(get_value($history, 'comment_system'))?></div>
				<?php } ?>
				<?php if(get_value($history, 'id_user') == $this->session->userdata('id_user') && get_value($task, 'situation') != 'finalizada'){?>
				<div style="float:right;margin:5px 0 0 0"><a href="javascript:void(0);" onclick="ajax_delete_comment_history(<?php echo get_value($history, 'id_task_history') ?>, <?php echo get_value($task, 'id_task')?>)"><?php echo lang('Excluir comentário')?></a></div>
				<?php } ?>
			</div>
			<div class="inline top" style="width:80px">
			<img src="<?php echo $user_img;  ?>" style="width:50px;" />
			</div>
		</div>
		<?php } ?>
	<?php $i++; } ?>
<?php } else { echo message('info', '', '<span class="font_11">' . lang('Nenhum histórico / andamento registrado para esta tarefa.') . '</span>', false, 'margin-top:-5px;'); } ?>
<script type="text/javascript" language="javascript">
	$('#comment').autosize();
	enable_masks();
</script>