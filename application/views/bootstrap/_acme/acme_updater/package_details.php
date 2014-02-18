<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$('.custom_message h5').remove();
	});
</script>
<div>	
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_updater/"><?php echo lang("Atualizações"); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_updater.png" />			
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Detalhes do Pacote de Atualização')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Detalhes do Pacote de Atualização') ?></h4>			
			</div>
		</div>
	</div>

	<div id="module_description" style="line-height:normal;"><?php echo message('info', '', lang('Visualize nesta página os detalhes do pacote de atualização selecionado, como dados gerais, mensagens de erro geradas no momento de sua instalação e dependências com outros pacotes.')) ?></div>
	
	<h5 style="margin-top:35px"><?php echo lang('Dados do Pacote') ?></h5>
	<hr style="margin-bottom:10px" />
	<div id="box_group_view">
		<div class="odd">
			<div id="label_view" class="inline"><?php echo lang('Versão') ?></div>
			<div id="field_view" class="inline"><h6 class="font_success"><?php echo get_value($package_data, 'version') ?></h6></div>
		</div>
		<div  >
			<div id="label_view" class="inline"><?php echo lang('Nome do pacote') ?></div>
			<div id="field_view" class="inline"><?php echo get_value($package_data, 'name') ?></div>
		</div>
		<div class="odd">
			<div id="label_view" class="inline"><?php echo lang('Arquivo do pacote') ?></div>
			<div id="field_view" class="inline"><?php echo basename(get_value($package_data, 'path_file')) ?></div>
		</div>
		<div>
			<div id="label_view" class="inline"><?php echo lang('Descrição do pacote') ?></div>
			<div id="field_view" class="inline" style="width:600px"><?php echo get_value($package_data, 'description') ?></div>
		</div>
		<div class="odd">
			<div id="label_view" class="inline"><?php echo lang('Disponível desde') ?></div>
			<div id="field_view" class="inline" style="width:600px"><?php echo get_value($package_data, 'dtt_package_available') ?></div>
		</div>
		<div>
			<div id="label_view" class="inline"><?php echo lang('Instruções deste pacote') ?></div>
			<div id="field_view" class="inline" style="width:600px">
				<a href="javascript:void(0);" onclick="show_area('package_instructions')"><?php echo lang('Exibir Instruções do pacote')?></a>
				<div id="package_instructions" style="display:none;">
				<?php 
					foreach($package['package-actions'] as $instruction_number => $action) {
						switch(strtolower(key($action)))
						{
							case 'mkdir':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Criar diretório no sistema') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Diretório do sistema a ser criado:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['mkdir'] . '</span></div><br />';
							break;
							
							case 'rmdir':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Remover diretório do sistema') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Diretório do sistema a ser deletado:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['rmdir'] . '</span></div><br />';
							break;
							
							case 'unlink':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Remover arquivo do sistema') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Arquivo do sistema a ser deletado:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['unlink'] . '</span></div><br />';
							break;
							
							case 'rename':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Renomear arquivo/diretório do sistema') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Arquivo/diretório do sistema a ser renomeado:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['rename']['from'] . '</span></div>';
								echo '<div class="font_11"><strong>' . lang('Novo nome:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['rename']['to'] . '</span></div><br />';
							break;
							
							case 'run-sql-file':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Executar arquivo SQL') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Arquivo SQL do pacote:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['run-sql-file']['file'] . '&nbsp;&nbsp;&nbsp;</span>';
								echo '<a href="javascript:void(0)" onclick="show_area(\'run_sql_file_' . $instruction_number . '\')">' . lang('Exibir conteúdo do arquivo') . '</a></div>';
								echo '<div class="font_11 word_wrap" style="margin-top:5px;border:3px dashed #ccc;background-color:#f5f5f5;padding:10px 15px;display:none" id="run_sql_file_' . $instruction_number . '"><pre>' . $action['run-sql-file']['content'] . '</pre></div><br />';
							break;
							
							case 'copy-replace-file':
								echo '<h6 style="color:steelblue">' . $instruction_number . ') ' . lang('Copiar/substituir arquivo do sistema') . '</h6>';
								echo '<div class="font_11"><strong>' . lang('Substituir o arquivo do sistema:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['copy-replace-file']['to'] . '</span></div>';
								echo '<div class="font_11"><strong>' . lang('Pelo aquivo do pacote:') . '</strong>';
								echo '<span>&nbsp;&nbsp;&nbsp;' . $action['copy-replace-file']['from'] . '</span></div><br />';
							break;
						}
					}
				?>
				</div>
			</div>
		</div>
	</div>
	
	<h5 style="margin-top:45px"><?php echo lang('Problemas na Execução deste Pacote') ?></h5>
	<hr />
	<div class="custom_message">
	<?php echo $table_errors; ?>
	</div>
	
	<h5 style="margin-top:45px"><?php echo lang('Dependências deste Pacote') ?></h5>
	<hr style="margin-bottom:10px;" />
	<?php if(count($package['package-dependencies']['version']) > 0) {?>
	<table class="table_sorter">
	<thead>
		<tr>
			<th><?php echo lang('VERSÃO')?></th>
			<th><?php echo lang('NOME')?></th>
			<th><?php echo lang('ARQUIVO')?></th>
			<th><?php echo lang('DESCRIÇÃO')?></th>
			<th><?php echo lang('INSTALADO EM')?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach($package['package-dependencies']['version'] as $version => $dep_package){
	$dep_package = $this->acme_updater_model->get_package_data($dep_package);
	?>
		<tr>
			<td><?php echo get_value($dep_package, 'version')?></td>
			<td><?php echo get_value($dep_package, 'name')?></td>
			<td><?php echo basename(get_value($dep_package, 'path_file'))?></td>
			<td><?php echo get_value($dep_package, 'description')?></td>
			<td><?php echo get_value($dep_package, 'dtt_package_installed')?></td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php } else { ?>
	<?php echo message('info', '', lang('Pacote sem dependências de outros pacotes.'))?>
	<?php } ?>
	
	<div style="margin-top: 35px;">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_updater/');"><?php echo lang('OK'); ?></button></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="redirect('<?php echo URL_ROOT ?>/acme_updater/');"><?php echo lang('voltar')?></a></div>
	</div>
</div>

