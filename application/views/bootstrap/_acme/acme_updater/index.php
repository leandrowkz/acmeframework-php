<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$('.custom_message h5').remove();
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_updater"><?php echo lang('Atualizações'); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_updater.png" />
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Novo Módulo')?>">
				<img class="inline top" src="<?php echo URL_IMG ?>/icon_insert.png" />
				<h6 class="inline top"><a href="<?php echo URL_ROOT ?>/acme_updater/package_upload"><?php echo lang('Instalar Pacote de Atualização')?></a></h6>
			</div>
		</div>		
	</div>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description"><?php echo lang('Utilize este módulo para gerenciar as atualizações já instaladas em sua instância do ACME Engine. Você pode instalar um novo pacote disponível no site do projeto ou então visualizar detalhes de pacotes já instalados.')?></div>
	
	<!-- LISTAGEM DE DADOS -->
	<div id="module_table">
		<h4><?php echo lang('Pacotes de Atualização Instalados') ?></h4>
		<hr style="margin-bottom:10px" />
		<div class="custom_message">
		<?php 
			if($count_packages > 0)
				echo $module_table;
			else
				echo message('info', lang('Consulta Vazia'), lang('Nenhum pacote de atualização instalado até o momento.'));
		?>
		</div>
	</div>
</div>