<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Remove linha de atividade
		parent.$('#activity-<?php echo get_value($activity, 'id_activity') ?>').remove();
		parent.close_modal();
	});		
</script>