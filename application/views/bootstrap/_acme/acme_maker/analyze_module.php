<?php
	function show_file_errors($file = array())
	{
		$return = '';
		foreach($file as $key => $value)
		{
			if(is_array($value)) 
			{
				$return .= show_file_errors($value);
			} else {
				$return .= '&bull;&nbsp;' . $value . '<br />';
			}
		}
		return $return;
	}
?>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Maker'); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_maker.png" />
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Análise de Arquivo')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Análise de Arquivo') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT ?>/acme_maker/new_module/<?php echo $file_name ?>"><?php echo lang('Voltar para edição do arquivo')?></a>)</div>
			</div>
		</div>		
	</div>
	
	<div id="module_description">
		<table width="100%">
		<tr>
		<td>
			
			<?php if($validation === true) { ?>
			<h5 class="font_success"><?php echo lang('O arquivo') .' <strong>' . $file_name . '</strong> ' . lang('está devidamente preenchido. Revise nesta página como o módulo ficará e em seguida clique no botão <strong>"Ok, Gerar Módulo"</strong> localizado no término da página.') ?></h5>
			<br />
			<h6 class="font_warning"><?php echo lang('ATENÇÃO! Após a geração do módulo o arquivo XML será descartado.') ?></h6>
			<?php } else { ?>
			<div class="font_11" style="line-height:normal"><?php echo message('error', lang('ATENÇÃO! O arquivo') .' <strong>' . $file_name . '</strong> ' . lang('contém erros. Verifique os erros abaixo, corrija-os e tente novamente.'), '<span style="line-height:20px;">' . show_file_errors($validation) . '</span>'); ?></div>
			<br />
			<?php } ?>
		
			<br />
			<h5><?php echo lang('Dados do Módulo') ?></h5>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php echo (isset($validation['rotule'])) ? 'class="error"' : 'class="odd"'; ?>>
					<div id="label_view"><?php echo lang('Rótulo do Módulo') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'rotule')?></div>
				</div>
				<div <?php echo (isset($validation['table'])) ? 'class="error"' : ''; ?>>
					<div id="label_view"><?php echo lang('Tabela') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'table')?></div>
				</div>
				<div <?php echo (isset($validation['controller'])) ? 'class="error"' : 'class="odd"'; ?>>
					<div id="label_view"><?php echo lang('Controller') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'controller')?></div>
				</div>
				<div <?php echo (isset($validation['sql_list'])) ? 'class="error"' : ''; ?>>
					<div id="label_view"><?php echo lang('SQL de Listagem') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'sql_list')?></div>
				</div>
				<div <?php echo (isset($validation['items_per_page'])) ? 'class="error"' : 'class="odd"'; ?>>
					<div id="label_view"><?php echo lang('Itens por Página') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'items_per_page')?></div>
				</div>
				<div <?php echo (isset($validation['url_img'])) ? 'class="error"' : ''; ?>>
					<div id="label_view"><?php echo lang('URL de Imagem do Módulo') ?></div>
					<div id="field_view"><?php echo htmlentities(get_value($file_data, 'url_img'))?></div>
				</div>
				<div <?php echo (isset($validation['description'])) ? 'class="error"' : 'class="odd"'; ?>>
					<div id="label_view"><?php echo lang('Descrição do Módulo') ?></div>
					<div id="field_view"><?php echo get_value($file_data, 'description')?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Link Para o Módulo') ?></h5>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php echo (isset($validation['menu_access']['create_menu'])) ? 'class="error"' : 'class="odd"'; ?>>
					<div id="label_view"><?php echo lang('Criar Menu de Acesso para o módulo') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['menu_access'], 'create_menu')) == 'true') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php echo (isset($validation['menu_access']['apply_to_groups'])) ? 'class="error"' : ''; ?>>
					<div id="label_view"><?php echo lang('Aplicar para os Grupos') ?></div>
					<div id="field_view">
						<?php 					
						// Verifica a existencia dos grupos informados
						foreach(get_value($file_data['menu_access'], 'apply_to_groups') as $group) { echo '&bull;&nbsp;' . $group . '<br />'; }
						?>
					</div>
				</div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Formulários Deste Módulo') ?></h5>
			<?php if (get_value($file_data, 'table') == '') { ?>
			<div class="inline top font_error font_11" style="margin:3px 0 0 0"><?php echo lang('A criação dos formulários de <strong>Inserção</strong>, <strong>Edição</strong>, <strong>Deleção</strong>, e <strong>Visualização</strong> será ignorada, uma vez que o módulo a ser gerado não possui uma tabela.')?></div>
			<?php } ?>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php if(isset($validation['forms']['insert'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Inserção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'insert')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['update'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Edição') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'update')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['delete'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Deleção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'delete')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['view'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Visualização') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'view')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Permissões Deste Módulo') ?></h5>
			<?php if (get_value($file_data, 'table') == '') { ?>
			<div class="inline top font_error font_11" style="margin:3px 0 0 0"><?php echo lang('A criação automática de permissões para <strong>Inserção</strong>, <strong>Edição</strong>, <strong>Deleção</strong>, e <strong>Visualização</strong> será ignorada, uma vez que o módulo a ser gerado não possui uma tabela.')?></div>
			<?php } ?>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php if(isset($validation['forms']['insert'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Inserção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'insert')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['update'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Edição') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'update')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['delete'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Deleção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'delete')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['view'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Visualização') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'view')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<?php 
				$count_permissions = count($file_data['permissions']);
				for($i = 0; $i < $count_permissions; $i++) { 
				$class = ($i % 2 == 0) ? 'class="odd"' : '';
				?>
				<div <?php echo (isset($validation['permissions']['rotule'][$i]) || isset($validation['permissions']['description'][$i]) || isset($validation['permissions']['name'][$i])) ? 'class="error"' : $class; ?>>
					<div id="label_view"><?php echo (get_value($file_data['permissions'][$i], 'rotule') == '') ? '-' : get_value($file_data['permissions'][$i], 'rotule') ?></div>
					<div id="field_view">
						<?php echo (isset($validation['permissions']['rotule'][$i]) || isset($validation['permissions']['description'][$i]) || isset($validation['permissions']['name'][$i])) ? '<h6 class="font_error inline" style="margin:0;">' . lang('Não') . '</h6>' : '<h6 class="font_success inline" style="margin:0;">' . lang('Sim') . '</h6>'; ?></h6>
						<div class="inline" style="margin:-1px 0 0 5px;"><a href="javascript:void(0)" class="black" onclick="show_area('custom_permission_<?php echo $i ?>')"><?php echo lang('Exibir detalhes') ?></a></div>
						<div id="custom_permission_<?php echo $i ?>" style="display:none;" class="font_11">
							<strong>rotule: </strong><?php echo get_value($file_data['permissions'][$i], 'rotule')?><br />
							<strong>name: </strong><?php echo get_value($file_data['permissions'][$i], 'name')?><br />
							<strong>description: </strong><?php echo get_value($file_data['permissions'][$i], 'description')?><br />
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			
			<br />
			<br />
			<h5><?php echo lang('Ações de Registro Deste Módulo') ?></h5>
			<?php if (get_value($file_data, 'table') == '') { ?>
			<div class="inline top font_error font_11" style="margin:3px 0 0 0"><?php echo lang('A criação automática de ações para <strong>Edição</strong>, <strong>Deleção</strong>, e <strong>Visualização</strong> será ignorada, uma vez que o módulo a ser gerado não possui uma tabela.')?></div>
			<?php } ?>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php if(isset($validation['forms']['update'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Edição') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'update')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['delete'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Deleção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'delete')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<div <?php if(isset($validation['forms']['view'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo ''; } ?>>
					<div id="label_view"><?php echo lang('Visualização') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'view')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<?php 
				$count_actions = count($file_data['actions']);
				for($i = 0; $i < $count_actions; $i++) { 
				$class = ($i % 2 == 0) ? 'class="odd"' : '';
				?>
				<div <?php echo (isset($validation['actions']['rotule'][$i]) || isset($validation['actions']['description'][$i]) || isset($validation['actions']['link'][$i])) ? 'class="error"' : $class; ?>>
					<div id="label_view"><?php echo (get_value($file_data['actions'][$i], 'rotule') == '') ? '-' : get_value($file_data['actions'][$i], 'rotule') ?></div>
					<div id="field_view">
						<?php echo (isset($validation['actions']['rotule'][$i]) || isset($validation['actions']['description'][$i]) || isset($validation['actions']['link'][$i])) ? '<h6 class="font_error inline" style="margin:0;">' . lang('Não') . '</h6>' : '<h6 class="font_success inline" style="margin:0;">' . lang('Sim') . '</h6>'; ?></h6>
						<div class="inline" style="margin:-1px 0 0 5px;"><a href="javascript:void(0)" class="black" onclick="show_area('custom_action_<?php echo $i ?>')"><?php echo lang('Exibir detalhes') ?></a></div>
						<div id="custom_action_<?php echo $i ?>" style="display:none;" class="font_11">
							<strong>rotule: </strong><?php echo get_value($file_data['actions'][$i], 'rotule')?><br />
							<strong>link: </strong><?php echo htmlentities(get_value($file_data['actions'][$i], 'link'))?><br />
							<strong>target: </strong><?php echo get_value($file_data['actions'][$i], 'target')?><br />
							<strong>url_img: </strong><?php echo htmlentities(get_value($file_data['actions'][$i], 'url_img'))?><br />
							<strong>javascript: </strong><?php echo get_value($file_data['actions'][$i], 'javascript')?><br />
							<strong>description: </strong><?php echo get_value($file_data['actions'][$i], 'description')?><br />
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			
			
			<br />
			<br />
			<h5><?php echo lang('Menus Deste Módulo') ?></h5>
			<?php if (get_value($file_data, 'table') == '') { ?>
			<div class="inline top font_error font_11" style="margin:3px 0 0 0"><?php echo lang('A criação automática do menu de <strong>Inserção</strong> será ignorada, uma vez que o módulo a ser gerado não possui uma tabela.')?></div>
			<?php } ?>
			<hr style="margin-bottom:5px" />
			<div id="box_group_view">
				<div <?php if(isset($validation['forms']['insert'])) { echo 'class="error"'; } else if(get_value($file_data, 'table') == '') { echo 'class="warning"'; } else { echo 'class="odd"'; } ?>>
					<div id="label_view"><?php echo lang('Inserção') ?></div>
					<div id="field_view">
						<?php if(strtolower(get_value($file_data['forms'], 'insert')) == 'true' && get_value($file_data, 'table') != '') { ?>
						<h6 class="font_success" style="margin:0;"><?php echo lang('Sim') ?></h6>
						<?php } else { ?>
						<h6 class="font_error" style="margin:0;"><?php echo lang('Não') ?></h6>
						<?php } ?>
					</div>
				</div>
				<?php 
				$count_menus = count($file_data['menus']);
				for($i = 0; $i < $count_menus; $i++) { 
				$class = ($i % 2 == 0) ? '' : 'class="odd"';
				?>
				<div <?php echo (isset($validation['menus']['rotule'][$i]) || isset($validation['menus']['description'][$i]) || isset($validation['menus']['link'][$i])) ? 'class="error"' : $class; ?>>
					<div id="label_view"><?php echo (get_value($file_data['menus'][$i], 'rotule') == '') ? '-' : get_value($file_data['menus'][$i], 'rotule') ?></div>
					<div id="field_view">
						<?php echo (isset($validation['menus']['rotule'][$i]) || isset($validation['menus']['description'][$i]) || isset($validation['menus']['link'][$i])) ? '<h6 class="font_error inline" style="margin:0;">' . lang('Não') . '</h6>' : '<h6 class="font_success inline" style="margin:0;">' . lang('Sim') . '</h6>'; ?></h6>
						<div class="inline" style="margin:-1px 0 0 5px;"><a href="javascript:void(0)" class="black" onclick="show_area('custom_menu_<?php echo $i ?>')"><?php echo lang('Exibir detalhes') ?></a></div>
						<div id="custom_menu_<?php echo $i ?>" style="display:none;" class="font_11">
							<strong>rotule: </strong><?php echo get_value($file_data['menus'][$i], 'rotule')?><br />
							<strong>link: </strong><?php echo htmlentities(get_value($file_data['menus'][$i], 'link'))?><br />
							<strong>target: </strong><?php echo get_value($file_data['menus'][$i], 'target')?><br />
							<strong>url_img: </strong><?php echo htmlentities(get_value($file_data['menus'][$i], 'url_img'))?><br />
							<strong>javascript: </strong><?php echo get_value($file_data['menus'][$i], 'javascript')?><br />
							<strong>description: </strong><?php echo get_value($file_data['menus'][$i], 'description')?><br />
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			
		</td>
		<td width="300" style="padding-left:70px;vertical-align:top">
			<!-- GUIA RÁPIDO -->
			<?php echo $this->template->start_box(lang('Arquivos que Serão Criados'), URL_IMG . '/icon_info.png', 'width:300px;margin-top:0px');?>
				<div style="line-height:25px;">
				<?php if($validation === true) { ?>
					<h6>&bull;&nbsp;<?php echo 'controllers/' . get_value($file_data, 'controller') . '.php' ?></h6>
					<h6>&bull;&nbsp;<?php echo 'models/' . get_value($file_data, 'controller') . '_model.php' ?></h6>
					<h6>&bull;&nbsp;<?php echo 'views/' . TEMPLATE . '/' . get_value($file_data, 'controller') . '/' . lang(' (diretório)') ?></h6>
				<?php } else {?>
					<h6>&bull;&nbsp;<?php echo lang('Até este momento nenhum arquivo será criado.') ?></h6>
				<?php } ?>
				</div>
			<?php echo $this->template->end_box();?>
			
			<!-- AJUDA -->
			<?php echo $this->template->start_box(lang('Ajuda'), URL_IMG . '/icon_help.png', 'margin-top:50px');?>
				<h6><?php echo lang('Entenda o significado das possíveis cores de linhas:') ?></h6>
				<div class="warning font_11" style="line-height:18px;padding:5px 10px"><?php echo lang('Linhas nesta cor indicam atenção quanto ao item que está colorido. Entretanto, avisos deste tipo não impedem que o módulo ainda assim seja gerado.')?></div>
				<div class="error font_11" style="line-height:18px;padding:5px 10px;margin-top:10px"><?php echo lang('Linhas nesta cor indicam erros quanto ao item que está colorido. O erro está indicado na listagem de erros, no início da página. Linhas nesta cor impedem que o módulo seja criado - é necessário corrigir estes itens para que o módulo esteja em um formato válido.')?></div>
			<?php echo $this->template->end_box();?>
		</td>
		</tr>
		</table>
	</div>
	
	<div style="margin-top:35px">
		<hr />
		<?php if($validation === true) { ?>
		<form action="<?php echo $action_form ?>" method="post" name="form_default" onsubmit="enable_loading();">
		<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Ok, Gerar Módulo')?>" /></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_maker/new_module/<?php echo $file_name ?>">voltar</a></div>
		</form>
		<?php } else { ?>
		<div style="margin:10px 3px 0 0" class="inline top"><button onclick="window.location.href='<?php echo URL_ROOT ?>/acme_maker/new_module/<?php echo $file_name ?>'"><?php echo lang('Voltar e Corrigir Problemas')?></button></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_maker/new_module/<?php echo $file_name ?>">voltar</a></div>
		<?php } ?>
	</div>
</div>