<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// ajax_load_box_config_form('filter', <?php echo $id_module ?>);
		ajax_load_box_config_form('filter', <?php echo $id_module ?>);
		
		// Atacha funcoes ao click das abas
		$('#aba_form_filter').click(function(){ ajax_load_box_config_form('filter', <?php echo $id_module; ?>) }); 
		$('#aba_form_insert').click(function(){ ajax_load_box_config_form('insert', <?php echo $id_module; ?>) }); 
		$('#aba_form_update').click(function(){ ajax_load_box_config_form('update', <?php echo $id_module; ?>) }); 
		$('#aba_form_delete').click(function(){ ajax_load_box_config_form('delete', <?php echo $id_module; ?>) }); 
		$('#aba_form_view').click(function(){ ajax_load_box_config_form('view', <?php echo $id_module; ?>) }); 
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang($this->lang_key_rotule); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Gerenciamento de Formulários')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Gerenciamento de Formulários') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT . '/' . $this->controller ?>"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>
	</div>
	
	<!-- DESCRICAO DO FORM -->
	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Nesta página você poderá configurar e habilitar o uso dos formulários básicos do módulo selecionado. Utilize a navegação em abas abaixo para alterar informações e configurações do formulário que está sendo exibido.')) ?></div>
	
	<!-- ABAS DE FORMULARIOS -->
	<br />
	<br />
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_filter"><?php echo lang('Formulário de Filtros') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_insert"><?php echo lang('Formulário de Inserção') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_update"><?php echo lang('Formulário de Edição') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_delete"><?php echo lang('Formulário de Deleção') ?></div>
	<div class="inline top font_11 bold aba_config_forms" id="aba_form_view"  ><?php echo lang('Formulário de Visualização') ?></div>
	
	<!-- BOX DE CONFIGS DE FORMS -->
	<div class="box_config_form" id="box_form_filter"></div>
	<div class="box_config_form" id="box_form_insert"></div>
	<div class="box_config_form" id="box_form_update"></div>
	<div class="box_config_form" id="box_form_delete"></div>
	<div class="box_config_form" id="box_form_view"  ></div>
	
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo URL_ROOT . '/' . $this->controller ?>'"><?php echo lang('ok')?></button></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT . '/' . $this->controller ?>">voltar</a></div>
	</div>
</div>