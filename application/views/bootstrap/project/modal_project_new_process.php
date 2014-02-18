<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Insere linha de atividade ao grupo de atividades
		var html_project = ajax_get_html_project(<?php echo get_value($project, 'id_project') ?>);
		var html_box_projects = parent.$('#box-projects').html();
		parent.$('#box-projects').html(html_project + html_box_projects);
		
		// Fecha a janela, habilita o loading e recarrega pagina
		parent.enable_loading();
		parent.window.location.reload();
		parent.close_modal();
	});		
</script>