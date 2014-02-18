<?php echo load_js_file('tinymce/tinymce.min.js') ?>
<?php echo load_js_file('jquery.ui.1.10.3.custom/js/jquery-ui-1.10.3.custom.js');?>
<link type="text/css" rel="stylesheet" href="<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.css" />
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		enable_form_validations();
		enable_masks();
		
		// Data de início
		$("#ini_prev").datepicker({
			showOn: "button",
			buttonImage: "<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/images/calendar.png",
			buttonImageOnly: true,
			dateFormat: "dd/mm/yy"
		});
		
		// Data de fim
		$("#end_prev").datepicker({
			showOn: "button",
			buttonImage: "<?php echo URL_JS ?>/jquery.ui.1.10.3.custom/css/custom-theme/images/calendar.png",
			buttonImageOnly: true,
			dateFormat: "dd/mm/yy"
		});
		
		// Habilita o editor HTML Visual
		tinymce.init({
			selector: "#description",
			valid_elements: "*[*]",
			extended_valid_elements: 'php',
			custom_elements : 'php',
			forced_root_block: false,
			force_p_newlines: false,
			force_br_newlines: true,
			remove_linebreaks: false,
			convert_newlines_to_brs: false,
			font_formats : "Andale Mono=andale mono,times;"+
                "Arial=arial,helvetica,sans-serif;"+
                "Arial Black=arial black,avant garde;"+
                "Book Antiqua=book antiqua,palatino;"+
                "Comic Sans MS=comic sans ms,sans-serif;"+
                "Courier New=courier new,courier;"+
                "Georgia=georgia,palatino;"+
                "Helvetica=helvetica;"+
                "Impact=impact,chicago;"+
                "Open Sans Condensed=open sans condensed;"+
                "Symbol=symbol;"+
                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
                "Terminal=terminal,monaco;"+
                "Times New Roman=times new roman,times;"+
                "Trebuchet MS=trebuchet ms,geneva;"+
                "Verdana=verdana,geneva;"+
                "Webdings=webdings;"+
                "Wingdings=wingdings,zapf dingbats",
			plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks",
						"insertdatetime media table contextmenu paste code"
					],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | styleselect | fontselect | fontsizeselect ",
			toolbar2: "hr | outdent indent | numlist | bullist | table | link | code ",
			menubar:false,
			autosave_ask_before_unload: false,
			content_css: '<?php echo URL_CSS ?>/style.css',
			max_height: "auto",
			min_height: 300,
			height : 180
		});
	});
	
	/**
	* ajax_build_options_project_activities()
	* Carrega opções de atividades do projeto selecionado no combo-box.
	* @return void
	*/
	function ajax_build_options_project_activities()
	{
		if($('#id_project').val() != '')
		{
			// Habilita loading
			enable_loading();
			
			var url_ajax = $('#URL_ROOT').val() + '/project/ajax_build_options_project_activities/' + $('#id_project').val();
			
			$.ajax({
				url: url_ajax,
				context: document.body,
				cache: false,
				async: false,
				type: 'POST',
				success: function(data)
				{
					// Carrega histórico na caixa de histórico
					$('#id_activity').html(data);
				}
			});
			
			// Desabilita o loading
			disable_loading();
		}
	}
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Editar')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Editar Tarefa') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . $url_redirect ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Utilize o formulário abaixo para criar uma nova tarefa. Campos com (*) são obrigatórios.')) ?></div>
	
	<!-- FORMULARIO -->
	<div style="margin-top:30px">
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/task/form_update_process" method="post">
			<input type="hidden" name="url_redirect" id="url_redirect" value="<?php echo $url_redirect ?>" />
			<input type="hidden" name="id_task" id="id_task" value="<?php echo get_value($task, 'id_task') ?>" />
			<h5><?php echo lang('Dados Básicos da Tarefa')?></h5>
			<hr />
			<div id="form_line" class="odd" style="padding-top:15px;">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Título da Tarefa')?>*</div>
				<div class="form_field"><input type="text" name="title" id="title" class="validate[required]" maxlength="250" style="width:300px" value="<?php echo get_value($task, 'title')?>" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Projeto')?>*</div>
				<div class="form_field"><select name="id_project" id="id_project" style="width:312px" class="validate[required]" onchange="ajax_build_options_project_activities()"><?php echo $options_projects; ?></select></div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Atividade')?>*</div>
				<div class="form_field"><select name="id_activity" id="id_activity" style="width:312px" class="validate[required]"><?php echo $options_activities; ?></select></div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Usuário Responsável')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="id_user_responsible" id="id_user_responsible" style="width:312px;" class="validate[required]"><?php echo $options_user_responsible; ?></select>
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Usuário que será responsável pela tarefa')?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Usuário Executor')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="id_user_executor" id="id_user_executor" style="width:312px;" class="validate[required]"><?php echo $options_user_executor; ?></select>
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Usuário que irá executar a tarefa')?></div>
				</div>
			</div>
			
			<br />
			<br />
			<br />
			<h5><?php echo lang('Descrição da Tarefa')?></h5>
			<hr />
			<div id="form_line" class="odd" style="padding-top:15px;">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Descrição')?></div>
				<div class="form_field"><textarea name="description" id="description" style="width:200px;height:100px;"><?php echo get_value($task, 'description')?></textarea></div>
			</div>
			
			<br />
			<br />
			<br />
			<h5><?php echo lang('Definições e Estimativas da Tarefa')?></h5>
			<hr />
			<div id="form_line" class="odd"  style="padding-top:10px;">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Situação da Tarefa')?></div>
				<div class="form_field font_blue" style="width:400px;padding-top:-1px"><h6><?php echo lang('aberta')?></h6></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Prioridade')?>*</div>
				<div class="form_field" style="min-width:400px">
					<select name="priority" id="priority" style="width:91px;" class="validate[required]">
						<option value="baixa" <?php echo (strtolower(get_value($task, 'priority')) == 'baixa') ? 'selected="selected"' : ''; ?>><?php echo lang('Baixa')?></option>
						<option value="normal" <?php echo (strtolower(get_value($task, 'priority')) == 'normal') ? 'selected="selected"' : ''; ?>><?php echo lang('Normal')?></option>
						<option value="alta" <?php echo (strtolower(get_value($task, 'priority')) == 'alta') ? 'selected="selected"' : ''; ?>><?php echo lang('Alta')?></option>
					</select>
				</div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Estimativa')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="estimate" id="estimate" value="<?php echo substr(get_value($task, 'estimate'), 0, 5)?>" alt="time" class="validate[required]" style="width:79px;" maxlength="5" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 5px"><?php echo lang('Estimativa em horas da tarefa.') . ' <strong>' . lang('Formato HH:MM') . '</strong>'?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Previsão de Início')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="ini_prev" id="ini_prev" value="<?php echo to_human_date(get_value($task, 'ini_prev'))?>" alt="date" class="validate[required,custom[date]]" style="width:79px;" maxlength="10" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 26px"><?php echo lang('Data de início da tarefa.') . ' <strong>' . lang('Formato DD/MM/AAAA') . '</strong>'?></div>
				</div>
			</div>
			<div id="form_line" class="odd">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Previsão de Término')?>*</div>
					<div class="form_field" style="min-width:400px">
					<input type="text" name="end_prev" id="end_prev" value="<?php echo to_human_date(get_value($task, 'end_prev'))?>" alt="date" class="validate[required,custom[date]]" style="width:79px;" maxlength="10" />
					<div class="inline top font_11 comment" style="margin:6px 0 0 26px"><?php echo lang('Previsão de data em que tarefa termina.') . ' <strong>' . lang('Formato DD/MM/AAAA') . '</strong>'?></div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Enviar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . $url_redirect; ?>"><?php echo lang('cancelar')?></a></div>
			</div>
		</form>
	</div>
</div>