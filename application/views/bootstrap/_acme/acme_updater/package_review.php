<div>	
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_updater/"><?php echo lang("Atualizações"); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_updater.png" />
		</div>
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Instalar Pacote de Atualização')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Instalar Pacote de Atualização') ?></h4>			
			</div>
		</div>
	</div>

	<?php if($package_installed){ ?>
	<div style="margin-top:20px"><?php echo message('warning', lang('ATENÇÃO!'), lang('O pacote de atualização que você está tentando instalar já está instalado. Verifique o pacote enviado e tente novamente.'))?></div>
	<?php } elseif($dependency){ ?>
	<div style="margin-top:20px"><?php echo message('error', lang('ATENÇÃO!'), lang('Existem dependências de outros pacotes. É necessário instalar estes pacotes antes de prosseguir. Visualize o conjunto de dependências abaixo.'))?></div>
	<?php } else { ?>
	<div id="module_description" style="line-height:normal;"><?php echo message('info', lang('Revisão do Pacote de Atualização'), lang('Revise o conteúdo do pacote de atualização abaixo, atentando para possíveis dependências de outros pacotes. Caso isso aconteça, você deverá fazer a instalação destes outros pacotes primeiramente. Você também pode visualizar as ações que o pacote realizará, para se certificar sobre a atualização.')) ?></div>
	<h4 style="margin-top:20px" class="font_error"><?php echo lang('ATENÇÃO!')?></h4>
	<h5><?php echo lang('O procedimento de atualização pode sobrescrever arquivos além de executar instruções SQL em seu banco de dados. Tenha em mente isso, e caso ache necessário, faça um backup dos arquivos que serão afetados. Para isto, visualize as instruções de execução do pacote, abaixo.')?></h5>
	<?php } ?>

	<form style="margin-top: 30px" id="form_default" name="form_default" enctype="multipart/form-data" action="<?php echo $action_form ?>" method="post">
		<input type="hidden" name="package_file_name" value="<?php echo $package_file_name ?>" />
		<div id="box_group_view">
			<div>
				<div id="label_view" class="inline"><?php echo lang('Versão') ?></div>
				<div id="field_view" class="inline"><h6 class="font_success"><?php echo get_value($package, 'package-version') ?><br /><span class="comment"><?php echo lang('O sistema será atualizado para esta versão')?></span></h6></div>
			</div>
			<div class="odd">
				<div id="label_view" class="inline"><?php echo lang('Nome do pacote') ?></div>
				<div id="field_view" class="inline"><?php echo get_value($package, 'package-name') ?></div>
			</div>
			<div>
				<div id="label_view" class="inline"><?php echo lang('Descrição do pacote') ?></div>
				<div id="field_view" class="inline" style="width:600px"><?php echo get_value($package, 'package-description') ?></div>
			</div>
			<div class="odd">
				<div id="label_view" class="inline"><?php echo lang('Dependências deste pacote') ?></div>
				<div id="field_view" class="inline">
					<?php if($dependency){ ?>
					<h6 class="inline"><?php echo lang('Dependência dos seguintes pacotes')?></h6><span class="font_red font_11"><?php echo lang(' (É necessário instalar estes pacotes anteriormente)')?></span>
					<?php foreach($dependencies as $package_dependency) {?>
					<h6>&bull;&nbsp;<a href="http://www.acmeengine.org/downloads/packages-updates/get/<?php echo $package_dependency; ?>" target="_blank"><?php echo lang('Pacote de atualização para a versão ') . ' ' . $package_dependency; ?></a><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" style="margin:-1px 0 0 3px;" /></h6>
					<?php } ?>
					<?php } else if(count($dependencies) > 0) { ?>
					<span><?php echo lang('Pacotes de dependências já instalados')?></span>
					<?php } else { ?>
					<span><?php echo lang('Nenhuma')?></span>
					<?php } ?>
				</div>
			</div>
			<div>
				<div id="label_view" class="inline"><?php echo lang('Instruções deste pacote') ?></div>
				<div id="field_view" class="inline" style="width:600px">
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
		<?php if(!$dependency && !$package_installed){ ?>
		<div style="margin-top: 40px;">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" name="upload" value="<?php echo lang('Executar Atualização'); ?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="$('#form_default').attr('action', '<?php echo URL_ROOT ?>/acme_updater/package_delete');$('#form_default').submit();"><?php echo lang('voltar')?></a></div>
		</div>
		<?php } else if($package_installed) { ?>
		<div style="margin-top: 40px;">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Voltar'); ?>" /></div>
		</div>
		<?php } else { ?>
		<div style="margin-top: 40px;">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Voltar'); ?>" /></div>
			<div style="margin:18px 0px 0 0" class="inline top font_red"><?php echo lang('É necessário resolver as pendências de instalação de pacotes antes de prosseguir.')?></div>
		</div>
		<?php } ?>
	</form>
</div>

