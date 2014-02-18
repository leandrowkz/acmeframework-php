<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Troca os links de inserção de atividade
		// parent.$('#link-new-activity-project-<?php echo get_value($activity, 'id_project')?>').show();
		// parent.$('#link-new-activity-project-<?php echo get_value($activity, 'id_project')?>-first').hide();
		
		// Insere linha de atividade ao grupo de atividades
		var html_activity = '<div id="activity-<?php echo get_value($activity, 'id_activity') ?>">' + ajax_get_html_activity(<?php echo get_value($activity, 'id_activity') ?>) + '</div>';
		var html_box_projects = parent.$('#box-project-activity-container-<?php echo get_value($activity, 'id_project') ?>').html();
		parent.$('#box-project-activity-container-<?php echo get_value($activity, 'id_project') ?>').html(html_activity + html_box_projects);
		
		parent.close_modal();
	});		
</script>