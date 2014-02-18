<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
			$("input:text").setMask();
		});		
	</script>
</head>
<body>
	<div id="modal_content">
	<?php if($error || get_value($form, 'dtt_inative') != '' || count($form) <= 0) { ?>
		<?php echo message('warning', lang('Atenção!'), lang('O formulário o qual o novo campo de filtro seria inserido está inativo. Habilite o uso deste formulário selecionando o checkbox e tente novamente.')); ?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="parent.close_modal()"><?php echo lang('ok')?></button></div>
			<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
		</div>
	<?php } else { ?>
		<!-- DESCRICAO DO FORMULARIO (MSG) -->
		<?php echo message('info', '', lang('Utilize o formulário abaixo para inserir um novo campo para o formulário de filtros. Campos com (*) são obrigatórios.')) ?>
		
		<!-- FORMULARIO -->
		<form id="form_default" name="form_default" action="<?php echo URL_ROOT ?>/acme_module_manager/ajax_modal_insert_form_field_process" method="post">
			<input type="hidden" name="id_module_form" id="id_module_form" value="<?php echo $id_module_form ?>" />
			<input type="hidden" name="id_module" id="id_module" value="<?php echo get_value($module, 'id_module') ?>" />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Propriedades do Campo') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Coluna (Tabela)')?>*</div>
				<div class="form_field">
					<input type="text" name="table_column" id="table_column" class="validate[required]" value="" style="width:150px" />
					<div class="font_11 comment" style="margin:7px 0 0 0;width:450px;"><span class="font_error"><?php echo lang('O nome do campo para o formulário de filtro deve possuir a informação da tabela (ou alias) a que pertence na consulta do módulo. Informe o nome do campo no seguinte formato: <strong><u>tabela_ou_alias.campo</u></strong>') ?></span><br /><br /><a href="javascript:void(0)" onclick="show_area('consulta_sql_modulo');"><?php echo lang('Exibir consulta SQL do módulo') ?></a></div>
					<div id="consulta_sql_modulo" style="display:none"><?php echo nl2br(get_value($module, 'sql_list'))?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Tipo')?>*</div>
				<div class="form_field">
					<select name="type" id="type" class="validate[required]" style="width:162px">
						<option value="" selected="selected"></option>
						<option value="text">text</option>
						<option value="textarea">textarea</option>
						<option value="file">file</option>
						<option value="radio">radio</option>
						<option value="select">select</option>
						<option value="password">password</option>
					</select>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulo de Exibição')?>*</div>
				<div class="form_field"><input type="text" name="lang_key_label" id="lang_key_label" class="validate[required]" value="" style="width:150px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Ordenação')?></div>
				<div class="form_field">
					<input type="text" name="order" id="order" value="" alt="integer" class="validate[integer]" style="width:100px" />
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('Ordem que o campo aparecerá na montagem do formulário.') ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Propriedades HTML') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('ID HTML')?>*</div>
				<div class="form_field"><input type="text" name="id_html" id="id_html" class="validate[required]" value="" style="width:150px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Classe HTML')?></div>
				<div class="form_field"><input type="text" name="class_html" id="class_html" value="" style="width:150px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Maxlength')?></div>
				<div class="form_field"><input type="text" name="maxlength" id="maxlength" value="" style="width:150px" /></div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Estilos (style)')?></div>
				<div class="form_field">
					<textarea name="style" id="style" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('Insira propriedades CSS de estilo neste campo uma ao lado da outra, separadas por ponto-e-vírgula. Não é necessário inserir a declaração style="".') ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Javascript e Eventos') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Javascript')?></div>
				<div class="form_field">
					<textarea name="javascript" id="javascript" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('Insira chamadas de funções e eventos javascript neste campo, como por exemplo:<br />onclick="do_something(this.value)"<br />onchange="free_me_please(this.value)"') ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Opções de Campo Tipo SELECT e RADIO') ?></h6>
			<hr />
			<div><?php echo lang('Preencha os campos abaixo caso o campo seja do tipo <strong>select</strong> ou <strong>radio</strong>, definindo as opções que este campo possuirá. O sistema dá preferência de montagem das opções quando um SQL de opções está definido, seguido por rótulos e valores.')?></div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('SQL de Opções (options)')?></div>
				<div class="form_field">
					<textarea name="options_sql" id="options_sql" class="script" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('O SQL a ser executado deve conter duas colunas, sendo uma delas o valor que ficará no <em>value</em> e outra o label da opção. Por exemplo:<br />SELECT VALUE, LABEL FROM TABLE') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Rótulos de Opções (options)')?></div>
				<div class="form_field">
					<textarea name="options_rotules" id="options_rotules" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('Opções devem ser inseridas separadas por ponto-e-vírgula. Deve existir o mesmo número de valores inseridos no campo abaixo (um complementa o outro).') ?></div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Valores de Opções (options)')?></div>
				<div class="form_field">
					<textarea name="options_values" id="options_values" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;"><?php echo lang('Valores devem ser inseridos separados por ponto-e-vírgula. Deve existir o mesmo número de opções inseridas no campo acima (um complementa o outro).') ?></div>
				</div>
			</div>
			
			<br />
			<br />
			<h6 class="font_shadow_gray"><?php echo lang('Máscaras e Validações') ?></h6>
			<hr />
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Máscaras')?></div>
				<div class="form_field">
					<textarea name="masks" id="masks" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;">
						<?php echo lang('Valores devem ser inseridos separados por ponto-e-vírgula. <a href="javascript:void" onclick="show_area(\'box_masks\')">Exibir máscaras</a>') ?>
						<div id="box_masks" style="display:none">
						<strong>phone:</strong> (99) 9999.9999<br />
						<strong>cpf:</strong> 999.999.999-99<br />
						<strong>cnpj:</strong> 99.999.999/9999-99<br />
						<strong>date:</strong> 39/19/9999<br />
						<strong>cep:</strong> 99999-999<br />
						<strong>hour:</strong> 29:59<br />
						<strong>time:</strong> 99:99<br />
						<strong>cc (credit card):</strong> 9999 9999 9999 9999<br />
						<strong>integer:</strong> 999999999999999999<br />
						<strong>numeric:</strong> 99.999.999.999.999<br />
						<strong>decimal:</strong> 99,999.999.999.999<br />
						</div>
					</div>
				</div>
			</div>
			<div id="form_line">
				<div class="form_label font_11 bold" style="width:150px"><?php echo lang('Validações')?></div>
				<div class="form_field">
					<textarea name="validations" id="validations" style="width:250px;height:80px"></textarea>
					<div class="comment font_11" style="margin:7px 0 0 0;width:450px;">
						<?php echo lang('Valores devem ser inseridos separados por ponto-e-vírgula. <a href="javascript:void" onclick="show_area(\'box_validations\')">Exibir validações</a>') ?>
						<div id="box_validations" style="display:none">
						<strong>required:</strong> <?php echo lang('campo obrigatório') ?><br />
						<strong>email:</strong> <?php echo lang('validador de email') ?><br />
						<strong>phone:</strong> <?php echo lang('validador de telefone') ?><br />
						<strong>url:</strong> <?php echo lang('URL válida/inválida') ?><br />
						<strong>number:</strong> <?php echo lang('double e float com negação ou não') ?><br />
						<strong>integer:</strong> <?php echo lang('inteiros') ?><br />
						<strong>ipv4:</strong> <?php echo lang('endereços de ip v4') ?><br />
						<strong>date:</strong> <?php echo lang('datas no formato DD/MM/AAAA') ?><br />
						<strong>onlyLetterSp:</strong> <?php echo lang('apenas letras e espaços') ?><br />
						<strong>onlyNumberSp:</strong> <?php echo lang('apenas números e espaços') ?><br />
						<strong>onlyLetterNumber:</strong> <?php echo lang('apenas letras e números, sem espaços') ?><br />
						<strong>equals[fieldID]:</strong> <?php echo lang('compara com o valor de outro campo (por exemplo, password)') ?><br />
						<strong>minCheckbox[7]:</strong> <?php echo lang('mínimo de checkbox a ser marcado') ?><br />
						<strong>maxCheckbox[7]:</strong> <?php echo lang('máximo de checkbox a ser marcado') ?><br />
						<strong>min[7]:</strong> <?php echo lang('valida quando o valor do campo é menor do que o parametro informado [7]') ?><br />
						<strong>max[7]:</strong> <?php echo lang('valida quando o valor do campo é maior do que o parametro informado [7]') ?><br />
						<strong>past[NOW or date YYYY-MM-DD]:</strong> <?php echo lang('verifica se o valor do elemento é uma data anterior à data informada como parametro') ?><br />
						<strong>future[NOW or date YYYY-MM-DD]:</strong> <?php echo lang('verifica se o valor do elemento é uma data posterior à data informada como parametro') ?><br />
						<strong>minSize[7]:</strong> <?php echo lang('verifica se o tamanho em caracteres do campo é maior do que o informado [7]') ?><br />
						<strong>maxSize[7]:</strong> <?php echo lang('verifica se o tamanho em caracteres do campo é menor do que o informado [7]') ?><br />
						</div>
				</div>
			</div>
			
			<div style="margin-top:35px">
				<hr />
				<div style="margin:10px 3px 0 0" class="inline top"><input type="submit" value="<?php echo lang('Salvar')?>" /></div>
				<div style="margin:18px 0px 0 0" class="inline top">ou <a href="javascript:void(0);" onclick="parent.close_modal();"><?php echo lang('cancelar') ?></a></div>
			</div>
		</form>
	<?php } ?>
	</div>
</body>
</html>
