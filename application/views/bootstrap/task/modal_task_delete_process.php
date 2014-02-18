<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Remove linha de tarefa
		parent.$('#task-<?php echo get_value($task, 'id_task') ?>').remove();
		parent.close_modal();
	});		
</script>