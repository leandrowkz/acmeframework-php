<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Maker'); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_maker.png" />
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Novo Módulo')?>">
				<img class="inline top" src="<?php echo URL_IMG ?>/icon_insert.png" />
				<h6 class="inline top"><a href="<?php echo URL_ROOT ?>/acme_maker/new_module"><?php echo lang('Novo Módulo')?></a></h6>
			</div>
		</div>		
	</div>
	
	<!-- GUIA RÁPIDO -->
	<?php echo $this->template->start_box(lang('Guia Rápido'), URL_IMG . '/icon_help.png', 'width:300px;float:right;margin:5px 0 0 30px');?>
		<div style="line-height:25px;">
			<h6 class="inline top">&bull;&nbsp;<a href="http://www.w3.org/XML" target="_blank"><?php echo lang('Leia mais sobre o formato XML')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<h6 class="inline top">&bull;&nbsp;<a href="http://www.acmeengine.org/documentation/more-about-acme-engine/what-are-modules" target="_blank"><?php echo lang('Documentação: O que são Módulos ?')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<h6 class="inline top">&bull;&nbsp;<a href="http://www.acmeengine.org/documentation/tutorials/how-to-make-a-module"><?php echo lang('Tutorial: criando um módulo básico')?></a></h6>
			<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
			<h6>&bull;&nbsp;<a href="<?php echo URL_ROOT ?>/acme_maker/new_module"><?php echo lang('Criar um novo módulo')?></a></h6>
		</div>
	<?php echo $this->template->end_box();?>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description">
		<h5><?php echo lang('Seja bem-vindo ao construtor de módulos, ou simplesmente Maker.') ?></h5>
		<div><?php echo lang('Você gerenciará nesta página a construção de novos módulos, além de apoio e pesquisa para isso.') ?></div>
		<div>
			<?php echo lang('A criação de módulos utiliza regras pré-definidas escritas em um arquivo do tipo <strong>xml</strong> (configuração). Para saber mais sobre isso, consulte a') . ' <a href="http://www.acmeengine.org/documentation/more-about-acme-engine/default-modules/acme-maker" target="_blank">' . lang('documentação sobre isso') . '</a>'; ?>
			<div class="inline top" style="margin:0px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" />.</div>
		</div>
		<div><?php echo lang('Para iniciar a construção de um novo módulo, clique no link <strong>Novo Módulo</strong>, acima.') ?></div>
	</div>
	
	<!-- LISTAGEM DE DADOS -->
	<div style="margin-top:50px">
		<h5><?php echo lang('Módulos pendentes de Finalização')?></h5>
		<hr style="margin-bottom:5px;" />
		<div style="line-height:20px"><?php echo lang('Lista de módulos não finalizados. Utilize os ícones da esquerda para cancelar ou continuar a criação destes módulos.') ?></div>
		<?php if(count($files) > 0) {?>
		<table class="table_sorter" style="margin-top:10px;">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th><h6><?php echo lang('Arquivo') ?></h6></th>
				<th><h6><?php echo lang('Criado em') ?></h6></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($files as $file) { ?>
			<tr>
				<td style="width:01%;vertical-align:top">
					<a href="<?php echo URL_ROOT ?>/acme_maker/new_module/<?php echo get_value($file, 'name') ?>" title="<?php echo lang('Continuar Construção')?>"><img src="<?php echo URL_IMG ?>/icon_procced_creation.png" /></a>
				</td>
				<td style="width:01%;vertical-align:top">
					<a href="javascript:void(0)" onclick="ajax_delete_module_file('<?php echo get_value($file, 'name') ?>')" title="<?php echo lang('Deletar Arquivo')?>"><img src="<?php echo URL_IMG ?>/icon_delete.png" /></a>
				</td>
				<td style="width:01%;vertical-align:top">
					<a href="<?php echo URL_ROOT ?>/application/temp/acme/<?php echo get_value($file, 'name') ?>" title="<?php echo lang('Visualizar Arquivo')?>" target="_blank"><img src="<?php echo URL_IMG ?>/icon_attach.png" /></a>
				</td>
				<td style="width:47%"><?php echo 'application/temp/acme/<strong>' . get_value($file, 'name') . '</strong>' ?></td>
				<td style="width:48%"><?php echo get_value($file, 'date_creation') ?></td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<?php } else { ?>
		<?php echo message('info', LANG('Nenhum Arquivo Encontrado') , lang('Nenhum módulo pendente de finalização.'), false, 'margin-top:10px'); ?>
		<?php } ?>
	</div>
</div>