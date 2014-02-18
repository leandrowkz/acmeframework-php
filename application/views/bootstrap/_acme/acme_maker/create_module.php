<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Maker'); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_maker.png" />
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Resumo de Criação de Módulo')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Resumo de Criação de Módulo') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT ?>/acme_maker/"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<div id="module_description">
		<?php echo message('success', lang('Tudo Certo!'), lang('Módulo gerado com sucesso! Estamos quase lá. Analise as instruções abaixo, são realmente importantes.'), false, 'line-height:normal'); ?>
		<div style="line-height:25px">
			<br />
			<div><?php echo lang('O módulo') . ' <strong>' . get_value($file_data, 'rotule') . '</strong> ' . lang(' foi gerado com sucesso.')?></div>
			<h6 class="inline top">&bull;&nbsp;<a href="<?php echo URL_ROOT . '/' . get_value($file_data, 'controller')?>" target="_blank"><?php echo lang('Clique aqui para abrir o módulo')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 3px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			
			<br />
			<br />
			<div><?php echo lang('Os seguintes arquivos e diretórios foram criados:')?></div>
			<div>&bull;&nbsp;<?php echo 'controllers/<strong>' . get_value($file_data, 'controller') . '.php</strong>' ?></div>
			<div>&bull;&nbsp;<?php echo 'models/<strong>' . get_value($file_data, 'controller') . '_model.php</strong>' ?></div>
			<div>&bull;&nbsp;<?php echo 'views/' . TEMPLATE . '/<strong>' . get_value($file_data, 'controller') . '</strong>/' . lang(' (diretório)') ?></div>
			
			<br />
			<div><?php echo lang('A versão deste módulo é <strong>padrão</strong> e <strong>simples</strong>. Para deixar este módulo com melhor acabamento, prossiga com as seguintes ações:') ?></div>
			<h6 class="inline top">&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_module_manager/administration/<?php echo $id_module ?>" target="_blank"><?php echo lang('Edite as configurações do módulo criado, no Painel de Administração deste módulo')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 3px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<div class="font_11 comment" style="margin:-10px 0 0 11px"><?php echo lang('Nesta tela você possui uma visão geral do módulo, suas permissões, ações, menus vinculados, etc.')?></div>
			<h6 class="inline top">&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_user" target="_blank"><?php echo lang('Aplique permissões deste módulo para os usuários do sistema')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 3px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<div class="font_11 comment" style="margin:-10px 0 0 11px"><?php echo lang('Na criação do módulo são definidas as permissões que ele possuirá (insert, update, delete, view, list, etc.). Entretanto, estas permissões são do módulo e devem ser aplicadas (ou não) para os usuários cadastrados.')?></div>
			<h6 class="inline top">&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_menu" target="_blank"><?php echo lang('Edite o menu de acesso criado para este módulo')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 3px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<div class="font_11 comment" style="margin:-10px 0 0 11px"><?php echo lang('Por padrão, o menu criado para este módulo entra diretamente no primeiro nível de menus do sistema. Altere a posição do menu editando suas configurações no módulo de gerência de menus.')?></div>
			<h6 class="inline top">&bull;&nbsp;<?php echo lang('Edite o arquivo controlador gerado') . ' (controllers/<strong>' . get_value($file_data, 'controller') . '.php</strong>)'?></a></h6>
			<div class="font_11 comment" style="margin:-10px 0 0 11px"><?php echo lang('Se este módulo for utilizado para um fim customizado, isto é, não for utilizar as estruturas internas de listagem e formulários, edite o arquivo controlador gerado (método <strong>index()</strong>). Esta opção é útil em módulos como painéis, dashboards, etc., ou que não sejam um CRUD simples.')?></div>
		</div>
	</div>
	
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo URL_ROOT ?>/acme_maker')"><?php echo lang('Ok, Voltar para o Módulo') ?></button></div>
	</div>
</div>