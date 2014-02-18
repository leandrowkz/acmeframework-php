<?php echo $this->template->load_js_file('jquery.autosize.js') ?>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		// Validação e máscaras
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
		$("textarea").autoresize();
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Maker'); ?></a></h2>
			<img src="<?php echo URL_TEMPLATE ?>/_acme/_includes/img/module_acme_maker.png" />
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" title="<?php echo lang('Novo Módulo')?>" style="margin:-7px 0 0 -15px">
				<h4 class="inline top font_shadow_gray"> > <?php echo lang('Novo Módulo') ?></h4>
				<div class="inline top comment" style="margin:12px 0 0 8px">(<a href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('Voltar para o módulo')?></a>)</div>
			</div>
		</div>
	</div>
	
	<!-- DESCRICAO -->
	<div id="module_description">
		<div><?php echo lang('Criar um módulo através de um arquivo de definições é simples e fácil. Basta que você saiba as regras de escrita do arquivo e como um módulo funciona.') ?></div>
		<div><?php echo lang('Você deverá preencher o campo abaixo, informando o conteúdo do arquivo. Após definido você deverá clicar em <strong>Salvar e Analisar</strong> para que o construtor faça uma avaliação do conteúdo informado.')?></div>
		<div><?php echo lang('Caso o arquivo esteja correto, confirme as informações e pronto! <strong>Seu módulo deverá estar gerado e funcionando</strong>.') ?></div>
		<div><?php echo lang('Você também pode definir as configurações parciais do módulo e continuar sua construção posteriormente. Neste caso você deverá clicar em <strong>Salvar</strong>, apenas.') ?></div>
		<br />
		<h5><?php echo lang('Acesso Rápido') ?>:</h5>
		<h6 class="inline top">&bull;&nbsp;<a href="http://pt.wikipedia.org/wiki/INI_(formato_de_arquivo)" target="_blank"><?php echo lang('Leia mais sobre o formato INI')?></a></h6>
		<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div><br />
		<h6 class="inline top">&bull;&nbsp;<a href="javascript:void(0)"><?php echo lang('Como um módulo funciona')?></a></h6>
		<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div><br />
		<h6 class="inline top">&bull;&nbsp;<a href="javascript:void(0)"><?php echo lang('Documentação: Criação de módulos')?></a></h6>
		<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div><br />
		<h6 class="inline top">&bull;&nbsp;<a href="javascript:void(0)"><?php echo lang('Tutorial: criando um módulo básico')?></a></h6>
		<div class="inline top" style="margin:9px 0 0 1px"><img src="<?php echo URL_IMG ?>/icon_bullet_external_link.gif" /></div>
	</div>
	
	<form name="form_default" id="form_default" action="<?php echo URL_ROOT ?>/acme_maker/new_module_process" method="post">
	<input type="hidden" name="file_name" id="file_name" value="<?php echo $file_name ?>">
	<table style="margin-top:-30px">
	<tr>
		<td width="99%">
			<!-- CAMPO TEXTAREA -->
			<div style="margin-top:50px">
				<h5><?php echo lang('Definições do Módulo (formato de arquivo .ini)')?></h5>
				<hr style="margin-bottom:5px;" />
				<div style="margin:10px 0 15px 0;line-height:20px"><?php echo lang('Utilize o campo abaixo para definir o módulo que será criado. Caso procure praticidade, utilize um esqueleto de estrutura de arquivo de módulo selecionando a opção na caixa ao lado. Após preenchido, clique no botão <strong>Salvar e Analisar</strong> no final da página.') ?></div>
				<?php if($file_name != '') { ?>
				<h6><?php echo lang('Nome gerado para o arquivo: ') . $file_name; ?></h6>
				<?php } ?>
				<textarea class="font_13 script validate[required]" name="ini_file" id="ini_file" style="line-height:18px !important;overflow:hidden;width:100%;min-height:200px"><?php echo $content; ?></textarea>
			</div>
		</td>
		<td width="300" style="padding-left:40px;">
			<!-- GUIA RÁPIDO -->
			<?php echo $this->template->start_box(lang('Controles'), URL_IMG . '/icon_cog.png', 'width:300px;float:right;margin:79px 0 0 30px;clear:both');?>
				<div style="line-height:25px;">
					<h6>&bull;&nbsp;<a href="javascript:void(0)" onclick="ajax_copy_skeleton_module_file();"><?php echo lang('Adicionar Esqueleto de arquivo')?></a></h6>
					<h6>&bull;&nbsp;<a href="javascript:void(0)" onclick="ajax_copy_skeleton_custom_section('menu');"><?php echo lang('Adicionar Menu Customizado')?></a></h6>
					<h6>&bull;&nbsp;<a href="javascript:void(0)" onclick="ajax_copy_skeleton_custom_section('permission');"><?php echo lang('Adicionar Permissão Customizada')?></a></h6>
					<h6>&bull;&nbsp;<a href="javascript:void(0)" onclick="ajax_copy_skeleton_custom_section('action');"><?php echo lang('Adicionar Ação Customizada')?></a></h6>
					<h6>&bull;&nbsp;<a href="javascript:void(0)" onclick="clear_ini_file();"><?php echo lang('Apagar conteúdo')?></a></h6>
				</div>
			<?php echo $this->template->end_box();?>
		</td>
	</tr>
	</table>
	<div style="margin-top:35px">
		<hr />
		<div style="margin:10px 10px 0 0" class="inline top"><input type="submit" name="btn_action" value="<?php echo lang('Salvar')?>" /></div>
		<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" name="btn_action" value="<?php echo lang('Salvar e Analisar')?>" /></div>
		<div style="margin:18px 0px 0 0" class="inline top">ou <a href="<?php echo URL_ROOT ?>/acme_maker"><?php echo lang('cancelar') ?></a></div>
	</div>
	</form>
</div>