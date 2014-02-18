/**
* functions.needed.js
*
* Arquivo de funções específicas da aplicação. Entende-se uma função específica aquela que possui 
* uma funcionalidade enraizada em uma regra de uma determinada tela. Por exemplo, uma função que
* habilita um formulário de módulo é considerada específica, portanto pode estar presente neste
* arquivo.
*		
* @since 		15/08/2012
* @location		js.functions.needed.js
*		
* ================================================================================================ 
*/

/**
* ajax_get_html_task_dashboard()
* Retorna o bloco HTML de uma linha de tarefa de id encaminhada. Para uso no dashboard de tarefas.
* @param int id_task
* @return string return_data
*/
function ajax_get_html_task_dashboard(id_task)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/task/ajax_get_html_task_dashboard/' + id_task;
	
	var return_data = '';
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Retorna html da linha de atividade
			return_data = data;
		}
	});
	
	// Desabilita o loading
	disable_loading();
	
	return return_data;
}

/**
* load_task_line_dashboard()
* Carrega linha html de tarefa com base no id encaminhado, para uso no dashboard de tarefas.
* @param int id_task
* @param int id_target
* @return void
*/
function load_task_line_dashboard(id_task, id_target)
{
	// HTML da linha
	var html_line = '<div id="task-' + id_task + '">' + ajax_get_html_task_dashboard(id_task) + '</div>';
	
	// Adiciona a linha à caixa de tarefas especifica
	var html_box_tasks = $('#' + id_target).html();	
	$('#' + id_target).html(html_box_tasks + html_line);
}

/**
* ajax_post_comment_dashboard()
* Insere um post de comentário de andamento de tarefa, nos detalhes de determinada tarefa no dashboard
* de tarefas, ou então finaliza a tarefa, conforme a combinação realizada.
* @param int id_task
* @return void
*/
function doit(id_comment, id_time)
{
	$(id_comment).css('border', '1px solid #fff');
	$(id_time).css('border', '1px solid #fff');
}
function ajax_post_comment_dashboard(id_task)
{
	// Valida o comentário
	var id_time = '#time-' + id_task;
	var id_id_user = '#id-user-' + id_task;
	var id_comment = '#comment-' + id_task;
	var id_finalize = '#finalizar-' + id_task;
	
	if($(id_comment).val() == '' || (($(id_time).val() == '00:00' || $(id_time).val().length < 5) && $(id_finalize).is(':checked')))
	{
		if($(id_comment).val() == '')
			$(id_comment).css('border', '1px solid #B22222');
		
		if(($(id_time).val() == '00:00' || $(id_time).val().length < 5) && $(id_finalize).is(':checked'))
			$(id_time).css('border', '1px solid #B22222');
		
		setTimeout(function(){doit(id_comment, id_time)}, 2000);
		return false;
	} else {
		// Habilita loading
		enable_loading();
		
		// Valores do post
		var time = $(id_time).val();
		var id_user = $(id_id_user).val();
		var comment = $(id_comment).val();
		var finalize = ($(id_finalize).is(':checked')) ? 'S' : 'N';
		
		var url_ajax = $('#URL_ROOT').val() + '/task/ajax_post_comment_dashboard/';
		
		$.ajax({
			url: url_ajax,
			data: 'id_user=' + id_user + '&time=' + time + '&comment=' + comment + '&id_task=' + id_task + '&finalize=' + finalize,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				// Atualiza linha de tarefa no grupo de tarefas
				var html_task_line = ajax_get_html_task_dashboard(id_task);
				
				// Substitui pelo conteudo atual
				$('#task-' + id_task).html(html_task_line);
				
				// Clica na linha
				$('#line-task-' + id_task).click();
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
}

/**
* ajax_load_box_details_task()
* Carrega caixa de detalhes de uma tarefa, para o dashboard de tarefas.
* @param int id_task
* @return void
*/
function ajax_load_box_details_task(id_task)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/task/ajax_load_box_details_task/' + id_task;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Carrega histórico na caixa de histórico
			$('#box-details-task-content-' + id_task).html(data);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_post_comment_history_reopen()
* Insere um post de comentário de andamento de tarefa na tela modal de histórico. Reabre a tarefa
* após isso.
* @return void
*/
function ajax_post_comment_history_reopen()
{
	var ret = false;
	// Valida o comentário
	if($('#comment').val() == '')
	{
		$('#comment').css('border', '1px solid #B22222');
		setTimeout("$('#comment').css('border', '1px solid #fff');", 2000);
		ret = false;
	} else {
		// Habilita loading
		enable_loading();
		
		// Valores do post
		var time = $('#time').val();
		var id_task = $('#id_task').val();
		var id_user = $('#id_user').val();
		var comment = $('#comment').val();
		
		var url_ajax = $('#URL_ROOT').val() + '/task/ajax_post_comment_history_reopen/';
		
		$.ajax({
			url: url_ajax,
			data: 'id_user=' + id_user + '&time=' + time + '&comment=' + comment + '&id_task=' + id_task,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				ret = true;
				
				// Atualiza linha de tarefa no grupo de tarefas
				var html_task = ajax_get_html_task(id_task);
				parent.$('#task-' + id_task).html(html_task);
				
				// Clica no botão detalhes da tarefa
				parent.$('#line-task-' + id_task + ' .details-task div.btn-control').click();
				
				// Esconde caixa de envio de nova mensagem e mostra mensagem de tarefa finalizada
				$('#box-finalize').hide();
				$('#msg-finalize').show();
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
	
	return ret;
}

/**
* ajax_post_comment_history_finalize()
* Insere um post de comentário de andamento de tarefa na tela modal de histórico. Finaliza a tarefa
* após isso.
* @return boolean true/false
*/
function ajax_post_comment_history_finalize()
{
	var ret = false;
	// Valida o comentário
	if($('#comment').val() == '' || $('#time').val() == '00:00' || $('#time').val().length < 5)
	{
		if($('#comment').val() == '')
			$('#comment').css('border', '1px solid #B22222');
		
		if($('#time').val() == '00:00' || $('#time').val().length < 5)
			$('#time').css('border', '1px solid #B22222');
		
		setTimeout("$('#comment').css('border', '1px solid #fff');", 2000);
		setTimeout("$('#time').css('border', '1px solid #ddd');", 2000);
		ret = false;
	} else {
		// Habilita loading
		enable_loading();
		
		// Valores do post
		var time = $('#time').val();
		var id_task = $('#id_task').val();
		var id_user = $('#id_user').val();
		var comment = $('#comment').val();
		
		var url_ajax = $('#URL_ROOT').val() + '/task/ajax_post_comment_history_finalize/';
		
		$.ajax({
			url: url_ajax,
			data: 'id_user=' + id_user + '&time=' + time + '&comment=' + comment + '&id_task=' + id_task,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				ret = true;
				
				// Atualiza linha de tarefa no grupo de tarefas
				var html_task = ajax_get_html_task(id_task);
				parent.$('#task-' + id_task).html(html_task);
				
				// Clica no botão detalhes da tarefa
				parent.$('#line-task-' + id_task + ' .details-task div.btn-control').click();
				
				// Esconde caixa de envio de nova mensagem e mostra mensagem de tarefa finalizada
				$('#box-finalize').hide();
				$('#msg-finalize').show();
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
	
	return ret;
}

/**
* ajax_post_comment_history()
* Insere um post de comentário de andamento de tarefa na tela modal de histórico.
* @return void
*/
function ajax_post_comment_history()
{
	// Valida o comentário
	if($('#comment').val() == '')
	{
		$('#comment').css('border', '1px solid #B22222');
		setTimeout("$('#comment').css('border', '1px solid #fff');", 2000);
		return false;
	} else {
		// Habilita loading
		enable_loading();
		
		// Valores do post
		var time = $('#time').val();
		var id_task = $('#id_task').val();
		var id_user = $('#id_user').val();
		var comment = $('#comment').val();
		
		var url_ajax = $('#URL_ROOT').val() + '/task/ajax_post_comment_history/';
		
		$.ajax({
			url: url_ajax,
			data: 'id_user=' + id_user + '&time=' + time + '&comment=' + comment + '&id_task=' + id_task,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				// Carrega bloco de comentários mais uma vez
				// ajax_load_box_comments(id_task);
				window.location.reload();
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
}

/**
* ajax_delete_comment_history()
* Deleta um post de comentário de id encaminhado.
* @param int id_task_history
* @param int id_task
* @return void
*/
function ajax_delete_comment_history(id_task_history, id_task)
{
	// Valida o comentário
	if(window.confirm("ATENÇÃO!\n\nO comentário selecionado será removido. Para continuar, clique em OK.") == true)
	{
		// Habilita loading
		enable_loading();
		
		var url_ajax = $('#URL_ROOT').val() + '/task/ajax_delete_comment_history/' + id_task_history;
		
		$.ajax({
			url: url_ajax,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				ajax_load_box_comments(id_task);
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
}

/**
* ajax_load_box_comments()
* Carrega caixa de comentários/historico/andamento de uma tarefa de id encaminhado.
* @param int id_task
* @return void
*/
function ajax_load_box_comments(id_task)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/task/ajax_load_box_comments/' + id_task;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Carrega histórico na caixa de histórico
			$('#box-history-' + id_task).html(data);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_get_html_project()
* Retorna o bloco HTML de uma caixa de projeto id encaminhada.
* @param int id_project
* @return string return_data
*/
function ajax_get_html_project(id_project)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/project/ajax_get_html_project/' + id_project;
	
	var return_data = '';
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Retorna html da linha de atividade
			return_data = data;
		}
	});
	
	// Desabilita o loading
	disable_loading();
	
	return return_data;
}

/**
* load_project_line()
* Carrega caixa html de projeto com base no id encaminhado
* @param int id_project
* @return void
*/
function load_project_line(id_project)
{
	// HTML da caixa
	var html_project = '<div id="project-' + id_project + '">' + ajax_get_html_project(id_project) + '</div>';
	
	// Adiciona a linha à caixa de atividades do projeto em questão
	var html_box_projects = $('#box-projects').html();	
	$('#box-projects').html(html_box_projects + html_project);
}

/**
* ajax_get_html_activity()
* Retorna o bloco HTML de uma linha de atividadede id encaminhada.
* @param int id_activity
* @return string return_data
*/
function ajax_get_html_activity(id_activity)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/activity/ajax_get_html_activity/' + id_activity;
	
	var return_data = '';
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Retorna html da linha de atividade
			return_data = data;
		}
	});
	
	// Desabilita o loading
	disable_loading();
	
	return return_data;
}

/**
* load_activity_line()
* Carrega linha html de atividade com base no id encaminhado. Necessario o id do projeto o qual
* esta linha sera inserida. Função utilizada quando tela de dashboard de projeto está sendo carregada.
* @param int id_activity
* @param int id_project
* @return void
*/
function load_activity_line(id_activity, id_project)
{
	// HTML da linha
	var html_activity = '<div id="activity-' + id_activity + '">' + ajax_get_html_activity(id_activity) + '</div>';
	
	// Adiciona a linha à caixa de atividades do projeto em questão
	var html_box_activities = $('#box-project-activity-container-' + id_project).html();	
	$('#box-project-activity-container-' + id_project).html(html_box_activities + html_activity);
}

/**
* ajax_get_html_task()
* Retorna o html de uma linha de tarefa de id encaminhada.
* @param int id_task
* @return void
*/
function ajax_get_html_task(id_task)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/task/ajax_get_html_task/' + id_task;
	
	var return_data = '';
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Retorna html da linha de atividade
			return_data = data;
		}
	});
	
	// Desabilita o loading
	disable_loading();
	
	return return_data;
}

/**
* load_task_line()
* Carrega linha html de tarefa com base no id encaminhado. Necessario o id da atividade o qual
* esta linha sera inserida. Função utilizada quando tela de dashboard de projetos está sendo carregada.
* @param int id_task
* @param int id_activity
* @return void
*/
function load_task_line(id_task, id_activity)
{
	// HTML da linha
	var html_task = '<div id="task-' + id_task + '">' + ajax_get_html_task(id_task) + '</div>';
	
	// Adiciona a linha à caixa de tarefas da atividade em questão
	var html_box_tasks = $('#box-tasks-activity-' + id_activity).html();	
	$('#box-tasks-activity-' + id_activity).html(html_task + html_box_tasks);
}

/**
* ajax_load_activity_tasks()
* Carrega bloco html de tarefas de uma atividade.
* @param int id_activity
* @return void
*/
function ajax_load_activity_tasks(id_activity)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/activity/ajax_load_activity_tasks/' + id_activity;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			$('#box-tasks-activity-' + id_activity).html(data);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_show_install_errors()
* Exibe erros de instalação, na tela de instalação executada com sucesso.
* @param int id_package
* @return void
*/
function ajax_show_install_errors(id_package)
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/acme_updater/ajax_show_install_errors/' + id_package;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			$('#errors_details').html(data);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_remove_all_log_errors()
* Remove todos os registros de erros de uma determinada categoria de erro.
* @param string error_type
* @return void
*/
function ajax_remove_all_log_errors(error_type)
{
	if(window.confirm($('#error_all_lang_question').val()) == true)
	{
		// Habilita loading
		enable_loading();
		
		var url_ajax = $('#URL_ROOT').val() + '/acme_log_error/ajax_remove_all_log_errors/' + error_type;
		
		$.ajax({
			url: url_ajax,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				// Alerta remoção com sucesso
				alert($('#error_all_lang_question_success').val());
				
				// Atualiza contador de erros
				$('#error_count').val($('#error_count').val() - $('#error_count_' + error_type).val());
				
				// Atualiza label de contagem de erros
				$('#error_tracker_count_errors').html($('#error_count').val());
				
				// Remove o bloco do erro
				$('#' + error_type).remove();
				
				// Remove linha indicativa de erro
				$('#error_type_' + error_type).remove();
				
				// Mostra mensagem em tempo real de sem erros
				if($('#error_count').val() <= 0)
				{
					$('#controls_change_visualization').hide();
					$('#errors_lista').hide();
					$('#message_no_errors').show();
				}
			},
			error: function(data)
			{
				alert($('#error_lang_question_error').val());
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
}

/**
* ajax_remove_log_error()
* Remove um registro de log de erro de id encaminhado.
* @param int id_log_error
* @return void
*/
function ajax_remove_log_error(id_log_error)
{
	if(window.confirm($('#error_lang_question').val()) == true)
	{
		// Habilita loading
		enable_loading();
		
		var url_ajax = $('#URL_ROOT').val() + '/acme_log_error/ajax_remove_log_error/' + id_log_error;
		
		$.ajax({
			url: url_ajax,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				// Alerta remoção com sucesso
				alert($('#error_lang_question_success').val());
				
				// Remove o bloco do erro
				$('.error_tracker_' + id_log_error).remove();
				
				// Atualiza contador de erros
				$('#error_count').val($('#error_count').val() - 1);
				
				// Atualiza label de contagem de erros
				$('#error_tracker_count_errors').html($('#error_count').val());
				
				// Mostra mensagem em tempo real de sem erros
				if($('#error_count').val() <= 0)
				{
					$('#controls_change_visualization').hide();
					$('#errors_lista').hide();
					$('#message_no_errors').show();
				}
			},
			error: function(data)
			{
				alert($('#error_lang_question_error').val());
			}
		});
		
		// Desabilita o loading
		disable_loading();
	}
}

/**
* ajax_reorder_menu()
* Atualiza nodo reordenado com base no id encaminhado.
* @param int id_menu
* @param int id_menu_parent_new
* @return void
*/
function ajax_reorder_menu(id_menu, id_menu_parent_new)
{
	// Habilita loading
	enable_loading();
	
	// DEBUG:
	// alert($('#menu_li_' + id_menu).prev().attr('order'));
	
	var order = ($('#menu_li_' + id_menu).prev().attr('order') == '' || $('#menu_li_' + id_menu).prev().attr('order') == undefined) ? 0 : $('#menu_li_' + id_menu).prev().attr('order');
	order = parseInt(order) + 1;
	
	var url_ajax = $('#URL_ROOT').val() + '/acme_menu/ajax_reorder_menu/' + id_menu + '/' + id_menu_parent_new + '/' + order;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			$('#message_success_template').fadeIn();
			setTimeout('$("#message_success_template").fadeOut();', 3000);
		},
		error: function(data)
		{
			$('#message_error_template').fadeIn();
			setTimeout('$("#message_error_template").fadeOut();', 3000);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_modal_bookmark_update()
* Modal de edição de formulário de opções de edição de bookmark.
* @param string modal_title
* @param integer idx_bookmark
* @param integer id_bookmark
* @return void
*/
function ajax_modal_bookmark_update(modal_title, idx_bookmark, id_bookmark)
{
	// Fecha form e bullet de edicao
	$('#img_user_bookmark_' + idx_bookmark).hide();
	$('#form_user_bookmark_' + idx_bookmark).hide();
	iframe_modal(modal_title, $('#URL_ROOT').val() + '/acme_user/ajax_modal_bookmark_update/' + id_bookmark, $('#URL_IMG').val() + '/icon_update.png', 600, 500);
}

/**
* ajax_modal_bookmark_delete()
* Modal de deleção de formulário de opções de edição de bookmark.
* @param string modal_title
* @param integer idx_bookmark
* @param integer id_bookmark
* @return void
*/
function ajax_modal_bookmark_delete(modal_title, idx_bookmark, id_bookmark)
{
	// Fecha form e bullet de edicao
	$('#img_user_bookmark_' + idx_bookmark).hide();
	$('#form_user_bookmark_' + idx_bookmark).hide();
	iframe_modal(modal_title, $('#URL_ROOT').val() + '/acme_user/ajax_modal_bookmark_delete/' + id_bookmark, $('#URL_IMG').val() + '/icon_delete.png', 600, 500);
}

/**
* show_form_options_update_bookmark()
* Exibe formulário de opções de edição/deleção de bookmark.
* @param integer idx_bookmark
* @param integer id_bookmark
* @return void
*/
function show_form_options_update_bookmark(idx_bookmark, id_bookmark)
{
	$('div[id^="form_user_bookmark_"]').each(function(){
		$(this).hide();
	});
	$('#form_user_bookmark_' + idx_bookmark).show();
}

/**
* close_form_options_update_bookmark()
* Exibe formulário de opções de edição/deleção de bookmark.
* @param integer idx_bookmark
* @return void
*/
function close_form_options_update_bookmark(idx_bookmark)
{
	$('#form_user_bookmark_' + idx_bookmark).hide();
	$('div[id^="img_user_bookmark_"]').each(function(){
		$(this).hide();
	});
}

/**
* show_bullet_update_bookmark()
* Exibe botão de edição de bookmark para o bookmark com o mouse over atual.
* @param integer idx_bookmark
* @return void
*/
function show_bullet_update_bookmark(idx_bookmark)
{
	$('#img_user_bookmark_' + idx_bookmark).show();
}

/**
* clear_bullet_update_bookmark()
* Esconde botão de edição de bookmark para o bookmark com o mouse over atual.
* @param integer idx_bookmark
* @return void
*/
function clear_bullet_update_bookmark(idx_bookmark)
{
	if(!$('#form_user_bookmark_' + idx_bookmark).is(':visible'))
	{
		$('#img_user_bookmark_' + idx_bookmark).hide();
	}
}

/**
* ajax_set_user_permission()
* Habilita ou desabilita permissao de um usuario para determinado módulo
* @param integer id_user
* @param string id_module_permission
* @return void
*/
function ajax_set_user_permission(id_user, id_module_permission)
{
	// Habilita loading
	enable_loading();
	
	// Inicializa vars
	var action, classe;
	
	// Dispara o ajax da url do form
	if($('#checkbox_action_' + id_module_permission).is(':checked'))
	{
		action = 'enable';
		classe = 'font_success inline ';	
	} else {
		action = 'disable';
		classe = 'font_error inline ';
	}
	
	var url_ajax = $('#URL_ROOT').val() + '/acme_user/ajax_set_user_permission/' + id_user + '/' + id_module_permission + '/' + action;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Altera label de sim para não (chaveia)
			$('#status_action_' + id_module_permission).html($('#lang_permission_'+ action +'_' + id_module_permission).val());
			$('#status_action_' + id_module_permission).attr('class', classe);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_load_table_module_custom_data()
* Carrega uma tabela de dados especificos (ações, permissões, menus) do modulo para um target.
* @param int id_module
* @param string data_type
* @return void
*/
function ajax_load_table_module_custom_data(id_module, data_type)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	$.ajax({
		url: $('#URL_ROOT').val() + '/acme_module_manager/ajax_load_table_' + data_type + '/' + id_module,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			$('#load_module_' + data_type).html(data);
			$('#load_module_' + data_type + ' h5').remove();
			$('#load_module_' + data_type + ' div.comment').remove();
		}
	});
	
	// Fecha o loading
	disable_loading();
}

/**
* ajax_delete_module_file()
* Apaga arquivo de configuração de arquivo de módulo.
* @param string file_name
* @return void
*/
function ajax_delete_module_file(file_name)
{
	if(window.confirm("ATENÇÃO!\n\nDeseja realmente remover o arquivo " + file_name + "?"))
	{
		// Habilita loading
		enable_loading();
		
		// Dispara o ajax da url do form
		$.ajax({
			url: $('#URL_ROOT').val() + '/acme_maker/delete_module/' + file_name,
			context: document.body,
			cache: false,
			async: false,
			type: 'POST',
			success: function(data)
			{
				alert("ATENÇÃO!\n\nArquivo removido com sucesso!");
				window.location.reload();
			}
		});
		
		// Fecha o loading
		disable_loading();
	}
}

/**
* clear_ini_file()
* Apaga conteudo do textarea de configuração de arquivo de módulo.
* @param object editor
* @return void
*/
function clear_ini_file(editor)
{
	if(window.confirm("ATENÇÃO!\n\nDeseja realmente remover o conteúdo do campo do arquivo?"))
	{
		editor.setValue('');
		alert("ATENÇÃO!\n\nConteúdo removido com sucesso!");
	}
}

/**
* ajax_copy_skeleton_custom_section()
* Copia esqueleto de uma seção custom de nome encaminhado. Utilizado na criação (Textarea)
* de módulo.
* @param string section_name
* @param object editor
* @return void
*/
function ajax_copy_skeleton_custom_section(section_name, editor)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	$.ajax({
		url: $('#URL_ROOT').val() + '/acme_maker/ajax_get_skeleton_custom_section/' + section_name,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			editor.setValue(data);
			alert("ATENÇÃO!\n\nSeção copiada com sucesso!");
		}
	});
	
	// Fecha o loading
	disable_loading();
}

/**
* ajax_copy_skeleton_module_file()
* Copia esqueleto de arquivo .ini de módulo para o textarea de criação. Parametro diz
* tipo de arquivo a ser copiado.
* @param string method
* @param object editor
* @return void
*/
function ajax_copy_skeleton_module_file(method, editor)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	$.ajax({
		url: $('#URL_ROOT').val() + '/acme_maker/ajax_get_skeleton_module_file/' + method,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// $('#ini_file').html(data + "\n\n\n" + $('#ini_file').html());
			editor.setValue(data);
			alert("ATENÇÃO!\n\nCopiado com sucesso!");
		}
	});
	
	// Fecha o loading
	disable_loading();
}

/**
* enable_column_name_field()
* Habilita ou desabilita uma coluna de nome de tabela de campo.
* @return void
*/
function enable_column_name_field()
{
	$('#table_column').attr('disabled', false);
}	

/**
* check_all_form_fields()
* Marca ou desmarca todos os checkboxes de campos da pagina.
* @param string operation
* @param int id_module_form
* @return void
*/
function check_all_form_fields(operation, id_module_form, id_module)
{
	// Habilita loading
	enable_loading();
	
	var checked = $('#checbox_form_fields_check_all_' + operation).is(':checked');
	$('input[id^="checkbox_form_field_' + operation + '_"]').each(function(){
		// Seta para checado
		$(this).attr('checked', $('#checbox_form_fields_check_all_' + operation).is(':checked'));
		
		// Dispara funcao do input
		ajax_set_config_form_field($(this).val(), operation, id_module_form);
	});
	
	// Carrega todo o bloco da tabela
	ajax_load_box_config_form_fields(operation, id_module);
	
	// Passa o checkbox para o estado anterior
	$('#checbox_form_fields_check_all_' + operation).attr('checked', checked);
	
	// Aviso de salvamento
	alert("ATENÇÃO!\n\nCampos salvos com sucesso!");
	
	// Desabilita o loading
	disable_loading();
}	

/**
* ajax_set_config_form_field()
* Habilita ou desabilita um campo de formulario com base no campo encaminhado.
* @param string column_name
* @param string operation
* @param integer id_form
* @return void
*/
function ajax_set_config_form_field(column_name, operation, id_form, id_module)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	var action = ($('#checkbox_form_field_' + operation + '_' + column_name).is(':checked')) ? 'enable' : 'disable';
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_' + action + '_form_field/' + column_name + '/' + id_form;
	
	setTimeout(function(){
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Recarrega campos do formulário
			if(id_module != null && id_module != undefined)
			{
				ajax_load_box_config_form_fields(operation, id_module);
			}
			
			var classe = $('#line_form_field_' + operation + '_' + column_name).attr('class');
			
			$('#line_form_field_' + operation + '_' + column_name).attr('class', 'success');
			$('#img_success_form_field_' + operation + '_' + column_name).show();
			
			// $(document).ready(function(){
			setTimeout(function(){ 
				$('#line_form_field_' + operation + '_' + column_name).attr('class', classe); 
				$('#img_success_form_field_' + operation + '_' + column_name).hide();
			}, 3000);
		},
		complete: function() { disable_loading(); }
	});
	}, 200);
	
}

/**
* ajax_set_config_form()
* Habilita ou desabilita um formulario com base na opção selecionada.
* @param string operation
* @param integer id_module
* @return void
*/
function ajax_set_config_form(operation, id_module)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	// Inicializa vars
	var action, classe;
	
	// Dispara o ajax da url do form
	if($('#checkbox_form_' + operation).is(':checked'))
	{
		action = 'enable';
		classe = 'inline top font_success';	
	} else {
		action = 'disable';
		classe = 'inline top font_error';
	}
	
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_' + action + '_form/' + operation + '/' + id_module;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Recarrega campos do formulário
			ajax_load_box_config_form_fields(operation, id_module);
			
			$('#status_form_' + operation).html($('#lang_status_form_' + operation + '_' + action).val());
			$('#status_form_' + operation).attr('class', classe);
			// alert("ATENÇÃO!\n\nSalvo com sucesso!");
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_set_config_action()
* Habilita ou desabilita uma ação de registro que aponta para determinado formulario. Utilizado nos
* formularios de edição, deleção e visualização.
* @param string operation
* @param integer id_module
* @return void
*/
function ajax_set_config_action(operation, id_module)
{
	// Habilita loading
	enable_loading();
	
	// Inicializa vars
	var action, classe;
	
	// Dispara o ajax da url do form
	if($('#checkbox_action_' + operation).is(':checked'))
	{
		action = 'enable';
		classe = 'inline top font_success';	
	} else {
		action = 'disable';
		classe = 'inline top font_error';
	}
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_' + action + '_config_action/' + operation + '/' + id_module;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Altera label de sim para não (chaveia)
			// alert('#lang_status_menu_insert_' + action);
			// alert($('#lang_status_action_' + operation + '_' + action).val());
			$('#status_action_' + operation).html($('#lang_status_action_' + operation + '_' + action).val());
			$('#status_action_' + operation).attr('class', classe);
			// alert("ATENÇÃO!\n\nSalvo com sucesso!");
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_set_config_menu_insert()
* Habilita ou desabilita um menu de inserção de formulario.
* @param integer id_module
* @return void
*/
function ajax_set_config_menu_insert(id_module)
{
	// Habilita loading
	enable_loading();
	
	// Inicializa vars
	var action, classe;
	
	// Dispara o ajax da url do form
	if($('#checkbox_menu_insert').is(':checked'))
	{
		action = 'enable';
		classe = 'inline top font_success';	
	} else {
		action = 'disable';
		classe = 'inline top font_error';
	}
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_' + action + '_menu_insert/' + id_module;
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Altera label de sim para não (chaveia)
			// alert('#lang_status_menu_insert_' + action);
			// alert($('#lang_status_menu_insert_' + action).attr('value'));
			$('#status_menu_insert').html($('#lang_status_menu_insert_' + action).val());
			$('#status_menu_insert').attr('class', classe);
			// alert("ATENÇÃO!\n\nSalvo com sucesso!");
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_load_box_config_form_fields()
* Carrega box html de campos de um determinado form.
* @param string operation
* @param integer id_module
* @return void
*/
function ajax_load_box_config_form_fields(operation, id_module)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_config_form_fields/' + operation + '/' + id_module;
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Carrega o conteudo para o box adequado
			$('#box_table_form_fields_' + operation).html(data);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* ajax_load_box_config_form()
* Carrega box html de configurações de um determinado formulário.
* @param string operation
* @param integer id_module
* @return void
*/
function ajax_load_box_config_form(operation, id_module)
{
	// Habilita loading
	enable_loading();
	
	// Dispara o ajax da url do form
	var url_ajax = $('#URL_ROOT').val() + '/acme_module_manager/ajax_config_form/' + operation + '/' + id_module;
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			// Carrega o conteudo para o box adequado
			$('#box_form_' + operation).html(data);
			
			// Ajusta exibição de aba
			show_tab_config_form(operation);
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* show_tab_config_form()
* Exibe aba correta do box de configuracao de formulario.
* @param string operation
* @return void
*/
function show_tab_config_form(operation)
{
	// Cor da aba selecionada
	$('#aba_form_' + operation).css('background-color', '#f5f5f5').css('border-top', '2px solid #bbb').css('margin-bottom', '-1px');
	
	// Deselect nas outras abas e box
	switch(operation)
	{
		case 'filter':
			$('#aba_form_insert, #aba_form_update, #aba_form_delete, #aba_form_view').css('background-color', '#e9e9e9').css('border-top', '1px solid #e9e9e9').css('margin-bottom', '-2px');
			$('#box_form_insert, #box_form_update, #box_form_delete, #box_form_view').hide();
		break;
		
		case 'insert':
			$('#aba_form_filter, #aba_form_update, #aba_form_delete, #aba_form_view').css('background-color', '#e9e9e9').css('border-top', '1px solid #e9e9e9').css('margin-bottom', '-2px');
			$('#box_form_filter, #box_form_update, #box_form_delete, #box_form_view').hide();
		break;
		
		case 'update':
			$('#aba_form_filter, #aba_form_insert, #aba_form_delete, #aba_form_view').css('background-color', '#e9e9e9').css('border-top', '1px solid #e9e9e9').css('margin-bottom', '-2px');
			$('#box_form_filter, #box_form_insert, #box_form_delete, #box_form_view').hide();
		break;
		
		case 'delete':
			$('#aba_form_filter, #aba_form_update, #aba_form_insert, #aba_form_view').css('background-color', '#e9e9e9').css('border-top', '1px solid #e9e9e9').css('margin-bottom', '-2px');
			$('#box_form_filter, #box_form_update, #box_form_insert, #box_form_view').hide();
		break;
		
		case 'view':
			$('#aba_form_filter, #aba_form_update, #aba_form_delete, #aba_form_insert').css('background-color', '#e9e9e9').css('border-top', '1px solid #e9e9e9').css('margin-bottom', '-2px');
			$('#box_form_filter, #box_form_update, #box_form_delete, #box_form_insert').hide();
		break;
	}
	
	// Exibe o box correto
	$('#box_form_' + operation).show();
}

/**
* verify_login_custom()
* Regra para Validação de login (unico) para validate jquery (formularios). Quando esta validação
* é utilizada em formulários, esta função é disparada retornando true ou false para o objeto
* que faz validação de formulário.
* CUSTOMIZADO, VERIFICA NO FORMULARIO SE O VALOR ANTERIOR É EXATAMENTE IGUAL AO DIGITADO, UTILIZADO
* EM FORMULÁRIO DE EDIÇÃO. NESTE CASO NÃO RETORNA ERRO POIS O VALOR PERMANECEU INALTERADO.
* @param object field
* @param object rules
* @param object i
* @param object options
* @return boolean
*/
function verify_login_custom(field, rules, i, options)
{
	if(field.val() != $('#login_previous').val())
	{
		var retorno = false;
		$.ajax({
			url: $('#URL_ROOT').val() + '/acme_user/verify_login/' + field.val(),
			context: document.body,
			cache: false,
			async: false,
			// data: 'email=' + prUser,
			type: 'POST',
			success: function(json){
				json = JSON.parse(json);
				
				if(json.user_exists == true)
				{
					retorno = true;
				}
			}
		});
		
		if(retorno)
			return options.allrules.verify_login.alertText;
	}
}