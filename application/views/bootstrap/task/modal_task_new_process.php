<?php echo $this->template->load_array_config_js_files(); ?>
<?php echo get_input_configurations(); ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		// Troca os links de inserção de atividade
		// parent.$('#link-new-activity-project-<?php echo get_value($activity, 'id_project')?>').show();
		// parent.$('#link-new-activity-project-<?php echo get_value($activity, 'id_project')?>-first').hide();
		
		// Variáveis de controle
		var details_activity_opened = parent.$('#box-details-activity-<?php echo get_value($activity, 'id_activity')?>').is(':visible');
		
		// Atualiza linha de atividade no grupo de atividades
		var html_activity = ajax_get_html_activity(<?php echo get_value($activity, 'id_activity') ?>);
		parent.$('#activity-<?php echo get_value($activity, 'id_activity') ?>').html(html_activity);
		
		// Abre a caixa de tarefas (lógica ao contrário - comportamento do bubbling event)
		if(!details_activity_opened)
			parent.$('#line-activity-<?php echo get_value($activity, 'id_activity') ?>').click();
		
		// Simula clique no botão detalhes da atividade
		if(details_activity_opened)
			parent.$('#box-line-activity-<?php echo get_value($activity, 'id_activity') ?> .details-activity div.btn-control').click();
		
		parent.close_modal();
	});		
</script>