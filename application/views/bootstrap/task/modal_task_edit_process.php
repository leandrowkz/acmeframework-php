<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Troca os links de inserção de atividade
		
		// Atualiza linha de tarefa no grupo de tarefas
		var html_task = ajax_get_html_task(<?php echo get_value($task, 'id_task') ?>);
		parent.$('#task-<?php echo get_value($task, 'id_task') ?>').html(html_task);
		
		// Clica no botão detalhes da tarefa
		parent.$('#line-task-<?php echo get_value($task, 'id_task') ?> .details-task div.btn-control').click();
		
		parent.close_modal();
	});		
</script>