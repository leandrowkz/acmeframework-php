/**
* functions.global.css
*
* Arquivo de funções globais da aplicação. Entende-se uma função global aquela que possui uma 
* funcionalidade ampla/genérica que pode ser utilizada em mais de um lugar, não dependendo de uma
* regra especificada em uma página de visualização. Por exemplo, a função redirect(url) está 
* localizada neste arquivo justamente por sua amplitude.
*		
* @since 		15/08/2012
* @location		js.functions.global.js
*
* ================================================================================================		
*/

/**
* ajax_change_language()
* Altera a linguagem atual da aplicação. Espera-se que em algum lugar da página exista um select
* com id 'combo_language' com os valores de linguagem permitidos.
* @return void
*/
function ajax_change_language()
{
	// Habilita loading
	enable_loading();
	
	var url_ajax = $('#URL_ROOT').val() + '/acme_session/ajax_change_language/' + $('#combo_language').val();
	
	$.ajax({
		url: url_ajax,
		context: document.body,
		cache: false,
		async: false,
		type: 'POST',
		success: function(data)
		{
			window.location.reload();
		}
	});
	
	// Desabilita o loading
	disable_loading();
}

/**
* enable_form_validations()
* Habilita validações de formulário na página inteira. É necessário que o script 
* jquery.validationengine.js e jquery.validationengine.pt_BR.js estejam inclusos e que um 
* formulario de id form_default ou form_filter estejam criados.
* @return void
*/
function enable_form_validations()
{
	if($("#form_filter").length > 0)
	{
		$("#form_filter").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
	}
	if($("#form_default").length > 0)
	{
		$("#form_default").validationEngine({ inlineValidation:false , promptPosition : "centerRight", scroll : true });
	}
}

/**
* enable_masks()
* Habilita máscaras na página inteira. É necessário que o script jquery.meiomask.js esteja incluso.
* @return void
*/
function enable_masks()
{
	$('input:text').setMask();
}

/**
* redirect()
* Redireciona página para url encaminhada.
* @param string url
* @return void
*/
function redirect(url)
{
	window.location.href = url;
}

/**
* set_form_filter_action()
* Seta o action do formulário de filtros e dispara o submit (necessário para utilização de paginação).
* Caso o formulário nao exista, então cria-o em tempo real.
* @param string url
* @return void
*/
function set_form_filter_action(url)
{
	if($('#form_filter').length <= 1)
	{
		$('body').append('<form action="" method="post" name="form_filter" id="form_filter"></form>');
	}
	$('#form_filter').attr('action', url);
	$('#form_filter').submit();
}

/**
* show_filter()
* Habilita, desabilita formulário de filtro.
* @return void
*/
function show_filter()
{
	if($('#form_filter').is(':visible') ) {
		$('#form_filter').hide();
	} else {
		$('#form_filter').show();
	}
}

/**
* show_area()
* Collapsa uma area de id indicado. Espera-se que exista uma imagem de id igual ao id 
* encaminhado + _img para que se possa fazer a troca da imagem do bullet.
* @param string id_area
* @return void
*/
function show_area(id)
{
	if($('#' + id).is(":visible"))
	{
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("minus", "plus");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).hide();
	} else {
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("plus", "minus");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).show();
	}
}

/**
* show_area_slide()
* Collapsa uma area de id indicado utilizando efeito slideUp/Down. Espera-se que exista uma imagem 
* de id igual ao id encaminhado + _img para que se possa fazer a troca da imagem do bullet (utiliza
* bullet arrow).
* @param string id_area
* @return void
*/
function show_area_slide(id)
{
	if($('#' + id).is(":visible"))
	{
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("down", "right");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).slideUp({speed: 50});
	} else {
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("right", "down");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).slideDown({speed: 50});
	}
}

/**
* show_area_slide_custom()
* Collapsa uma area de id indicado utilizando efeito customizado, passado como parametro. Espera-se que exista uma imagem 
* de id igual ao id encaminhado + _img para que se possa fazer a troca da imagem do bullet (utiliza
* bullet arrow).
* @param string id_area
* @param string effect_in
* @param string effect_out
* @return void
*/
function show_area_slide_custom(id)
{
	// alert(id);
	if($('#' + id).is(":visible"))
	{
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("down", "right");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).hide(250);
		// $('#' + id).effect('slide', { direction: 'left', mode: 'hide' }, 250);
	    // $('#' + id).animate({display: 'toogle'}, 1500);
	    // $('#' + id).animate({display: 'none'}, 1000);
	} else {
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("right", "down");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).show(250);
		// $('#' + id).effect('slide', { direction: 'right', mode: 'show' }, 250);
	    // $('#' + id).animate({display: 'block'}, 1000);
	    // $('#' + id).animate({display: 'show'}, 1500);
		//$('#' + id).hide('hide', { direction: effect_out }, 250);
	}
}

/**
* show_area_fade()
* Collapsa uma area de id indicado utilizando efeito fadeIn/Out. Espera-se que exista uma imagem 
* de id igual ao id encaminhado + _img para que se possa fazer a troca da imagem do bullet (utiliza
* bullet arrow).
* @param string id_area
* @return void
*/
function show_area_fade(id)
{
	if($('#' + id).is(":visible"))
	{
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("down", "right");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).fadeOut({speed: 50});
	} else {
		if($('#' + id + '_img').length > 0)
		{
			var src = $('#' + id + '_img').attr('src').replace("right", "down");
			$('#' + id + '_img').attr("src", src);
		}
		$('#' + id).fadeIn({speed: 50});
	}
}

/**
* get_checked_value()
* Coleta o valor de um checkbox que está marcado, através do nome do elemento check.
* @param string name
* @return mixed value
*/
function get_checked_value(name)
{
	var retorno;
	$('input[name="' + name + '"]').each(function(){
		if($(this).is(':checked'))
		{ 
			retorno = $(this).val(); 
		}
	});
	return retorno;
}

/**
* open_modal()
* Cria uma modal on the fly colocando conteudo dentro dela. Espera-se que o script jquery.modal.js
* esteja incluso.
* @param string titulo
* @param string conteudo
* @param string imagem
* @param int width
* @param int height
* @param boolean close
* @return void
*/
function open_modal(titulo, conteudo, imagem, width, height, close)
{
	var html  = '';
	var style_modal = '';
	var style_content = '';
	
	// Seta altura e largura
	height = (height != '' && height != null) ? height : 650;
	width = (width  != '' && width  != null) ? width : 800;
	style_modal = ' style="width:' + width + 'px;height:' + height + 'px"';
	style_content = ' style="height:' + (height - 80) + 'px !important;"';
	
	// Seta o boolean para close
	var bool_close = (close == false) ? false : true;
	
	// Img to close
	var close_img  = (close == false) ? '' : '<img src="' + $("#URL_IMG").val() + '/icon_close.png" id="img_close" class="img_close" title="Fechar" />';
	
	// Inicializa html da janela modal
	html += '<div class="modal" id="modal"' + style_modal + '>';
	html += '<div id="header">' + close_img;
	html += (imagem != undefined && imagem != null && imagem != '') ? '<img src="' + imagem + '" />' : '';
	html += '<h6>' + titulo  + '</h6></div>';
	html += '<div id="content" ' + style_content + '>' + conteudo + '</div><div id="footer"></div>';
	html += '</div>';
	
	// Inicializa a própria janela modal
	$.modal(html, {opacity: 60, zIndex: 10000, closeClass: 'img_close', escClose: bool_close, position: [0,0], close: bool_close});
}

/**
* iframe_modal()
* Cria uma modal on the fly colocando o conteudo de uma URL encaminhada em uma pagina iframe. 
* Espera-se que o script jquery.modal.js esteja incluso.
* @param string titulo
* @param string conteudo
* @param string imagem
* @param int width
* @param int height
* @param boolean close
* @return void
*/
function iframe_modal(titulo, url_param, imagem, width, height, close)
{
	var html  = '';
	var style_modal = '';
	var style_content = '';
	
	// Seta altura e largura
	height = (height != '' && height != null) ? height : 650;
	width = (width  != '' && width  != null) ? width : 800;
	style_modal = ' style="width:' + width + 'px;height:' + height + 'px"';
	style_content = ' style="height:' + (height - 80) + 'px !important;"';
	
	// Seta o boolean para close
	var bool_close = (close == false) ? false : true;
	
	// Img to close
	var close_img  = (close == false) ? '' : '<img src="' + $("#URL_IMG").val() + '/icon_close.png" id="img_close" class="img_close" title="Fechar" />';
	
	// Inicializa html da janela modal
	html += '<div class="modal" id="modal"' + style_modal + '>';
	html += '<div id="header">' + close_img;
	html += (imagem != undefined && imagem != null && imagem != '') ? '<img src="' + imagem + '" />' : '';
	html += '<h6>' + titulo  + '</h6></div>';
	html += '<div id="content" ' + style_content + '><iframe src="' + url_param + '" style="width:100%;height:' + (height - 80) + 'px !important;max-height:670px;border:0px solid green;z-index:10006;position:relative" align="left" frameborder="no"></iframe></div><div id="footer"></div>';
	html += '</div>';
	
	// Inicializa a própria janela modal
	$.modal(html, {opacity: 60, zIndex: 10000, closeClass: 'img_close', escClose: bool_close, position: [0,0], close: bool_close});
}

/**
* ajax_modal()
* Cria uma modal on the fly carregando em ajax o conteudo de uma URL para seu interior. 
* Espera-se que o script jquery.modal.js esteja incluso.
* @param string titulo
* @param string url
* @param string imagem
* @param int width
* @param int height
* @param boolean close
* @return void
*/
function ajax_modal(titulo, url_param, imagem, width, height, close)
{
	var html  = '';
	var style_modal = '';
	var style_content = '';
	
	// Habilita loading
	enable_loading();

	// Dispara o ajax da url
	$.ajax({
		url: url_param,
		context: document.body,
		cache: false,
		async: false,
		// data: 'email=' + prUser,
		type: 'POST',
		success: function(data){
			// alert(txt);
			// Seta altura e largura
			height = (height != '' && height != null) ? height : 650;
			width = (width  != '' && width  != null) ? width : 800;
			style_modal = ' style="width:' + width + 'px;height:' + height + 'px"';
			style_content = ' style="height:' + (height - 80) + 'px !important;"';
			
			// Seta o boolean para close
			var bool_close = (close == false) ? false : true;
			
			// Img to close
			var close_img  = (close == false) ? '' : '<img src="' + $("#URL_IMG").val() + '/icon_close.png" id="img_close" class="img_close" title="Fechar" />';
			
			// Inicializa html da janela modal
			html += '<div class="modal" id="modal"' + style_modal + '>';
			html += '<div id="header">' + close_img;
			html += (imagem != undefined && imagem != null && imagem != '') ? '<img src="' + imagem + '" />' : '';
			html += '<h6>' + titulo  + '</h6></div>';
			html += '<div id="content" ' + style_content + '>' + data + '</div><div id="footer"></div>';
			html += '</div>';
			
			// Inicializa a própria janela modal
			$.modal(html, {opacity: 60, zIndex: 10000, closeClass: 'img_close', position: [0,0], escClose: bool_close, close: bool_close});
			
			// Desabilita o loading
			disable_loading();
		}
	});
}

/**
* close_modal()
* Destrói a janela modal corrente da tela.
* @return void
*/
function close_modal()
{
	// Linha utilizada para fechamento de dialog quando chamada por iframe
	$.modal.close();
	
	// Linha utilizada para fechamento de dialog quando chamada por ajax ou conteudo
	$('#simplemodal-overlay').remove();
	$('#simplemodal-container').remove();
}

/**
* enable_loading()
* Habilita layer de loading.
* @return void
*/
function enable_loading()
{
	// Append do conteudo no body
	if($("#loading_layer").length <= 0)
	{
		$('body').append('<div id="loading_layer" style=\'position:absolute\'></div><div id="loading_box"><div id="canvas_loader" class="inline top" style="margin:7px 5px 0 0;"></div><h4 class="inline top font_shadow_black" style="color:#ddd;vertical-align:middle !important">Carregando...</h4></div>');
		
		// Cria loader
		var cl = new CanvasLoader('canvas_loader');
		cl.setColor('#d6d6d6'); // default is '#000000'
		cl.setDiameter(26); // default is 40
		cl.setDensity(68); // default is 40
		cl.setRange(1.0); // default is 1.3
		cl.setFPS(29); // default is 24
		cl.show(); // Hidden by default
		
		// This bit is only for positioning - not necessary
		/*
		var loaderObj = document.getElementById("canvasLoader");
  		loaderObj.style.position = "absolute";
  		loaderObj.style["top"] = cl.getDiameter() * -0.5 + "px";
  		loaderObj.style["left"] = cl.getDiameter() * -0.5 + "px";
		*/

		
		$("#loading_layer").show(); 
		$("#loading_box").show(); 
	} else {
		$("#loading_layer").show(); 
		$("#loading_box").show(); 
	}
}

/**
* enable_loading()
* Desabilita loading.
* @return void
*/
function disable_loading()
{
	// Verifica se o elemento existe, para fazer display:none;
	if($("#loading_layer").length > 0)
	{
		$("#loading_layer").hide();
		$("#loading_box").hide();
	}
}

/**
* check_browser_compatibilty()
* Verifica a compatibilidade de browser, caso seja uma das versões não compativel,
* indica ao usuario que ele deve fazer atualizacao do browser atual ou download de
* um outro browser.
* @return boolean is_compatible
*/
function check_browser_compatibilty()
{
	// Varre toda a estrutura de browser, verificando se o 
	// browser atual está dentro das versões comportadas
	var browser  = $.browser;
	var titulo   = 'Você deve atualizar o seu navegador'; 
	var conteudo  = '';
	var navegador = '';
	var version   = '';
	var is_compatible = true;
	
	if(browser.msie == true && browser.version <= 7)
	{
		navegador = '<strong>Internet Explorer</strong>';
		version   = browser.version;
		conteudo  = '<strong>Atenção!</strong> Detectamos que você está utilizando um navegador que não é totalmente compatível com as funcionalidades deste portal.<br /><br />';
		conteudo += 'Você está utilizando o navegador ' + navegador + ' na versão ' + version + ', contudo, somente existe compatibilidade para este navegador a partir da versão 8.0.<br /><br />Recomendamos a você as seguintes sugestões:<br />';
		conteudo += '<strong>1) Atualizar seu navegador para uma versão mais recente (Recomendável):</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_internet_explorer.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://windows.microsoft.com/pt-BR/internet-explorer/downloads/ie" target="_blank">Atualização para Internet Explorer</a>';
		conteudo += '</div>';
		conteudo += '<br />';
		conteudo += '<strong>2) Fazer download e instalação de um dos seguintes navegadores:</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_firefox.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://br.mozdev.org/firefox/download/" target="_blank">Mozilla Firefox</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_opera.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.opera.com/download/" target="_blank">Opera Browser</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_safari.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.apple.com/br/safari/download/" target="_blank">Apple Safari</a>';
		conteudo += '</div>';
		open_modal(titulo, conteudo, $('#URL_IMG').val() + '/icon_warning.png', 340, 500, false);
		
		// Seta o body para hide, para nao exibir scroll com conteudo quebrado
		$('#page_content').hide();
		is_compatible = false;
	}
	
	if(browser.mozilla == true && browser.version < 4)
	{
		navegador = '<strong>Mozilla Firefox</strong>';
		version   = browser.version;
		conteudo  = '<strong>Atenção!</strong> Detectamos que você está utilizando um navegador que não é totalmente compatível com as funcionalidades deste portal.<br /><br />';
		conteudo += 'Você está utilizando o navegador ' + navegador + ' na versão ' + version + ', contudo, somente existe compatibilidade para este navegador a partir da versão 4.0.<br /><br />Recomendamos a você as seguintes sugestões:<br />';
		conteudo += '<strong>1) Atualizar seu navegador para uma versão mais recente (Recomendável):</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_firefox.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://br.mozdev.org/firefox/download/" target="_blank">Atualização para Mozilla Firefox</a>';
		conteudo += '</div>';
		conteudo += '<br />';
		conteudo += '<strong>2) Fazer download e instalação de um dos seguintes navegadores:</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_internet_explorer.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://windows.microsoft.com/pt-BR/internet-explorer/downloads/ie" target="_blank">Internet Explorer</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_opera.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.opera.com/download/" target="_blank">Opera Browser</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_safari.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.apple.com/br/safari/download/" target="_blank">Apple Safari</a>';
		conteudo += '</div>';
		open_modal(titulo, conteudo, $('#URL_IMG').val() + '/icon_warning.png', 340, 500, false);
		
		// Seta o body para hide, para nao exibir scroll com conteudo quebrado
		$('#page_content').hide();
		is_compatible = false;
	}
	
	if(browser.opera == true && browser.version < 11)
	{
		navegador = '<strong>Opera Browser</strong>';
		version   = browser.version;
		conteudo  = '<strong>Atenção!</strong> Detectamos que você está utilizando um navegador que não é totalmente compatível com as funcionalidades deste portal.<br /><br />';
		conteudo += 'Você está utilizando o navegador ' + navegador + ' na versão ' + version + ', contudo, somente existe compatibilidade para este navegador a partir da versão 11.0.<br /><br />Recomendamos a você as seguintes sugestões:<br />';
		conteudo += '<strong>1) Atualizar seu navegador para uma versão mais recente (Recomendável):</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_opera.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.opera.com/download/" target="_blank">Atualização para Opera Browser</a>';
		conteudo += '</div>';
		conteudo += '<br />';
		conteudo += '<strong>2) Fazer download e instalação de um dos seguintes navegadores:</strong><br />';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_internet_explorer.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://windows.microsoft.com/pt-BR/internet-explorer/downloads/ie" target="_blank">Internet Explorer</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_firefox.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://br.mozdev.org/firefox/download/" target="_blank">Mozilla Firefox</a>';
		conteudo += '</div>';
		conteudo += '<div style="height:20px;">';
		conteudo += '<img src="' + $('#URL_IMG').val() + 'icon_safari.png" style="float:left;margin:2px 5px 0 0;" />';
		conteudo += '<a href="http://www.apple.com/br/safari/download/" target="_blank">Apple Safari</a>';
		conteudo += '</div>';
		open_modal(titulo, conteudo, $('#URL_IMG').val() + '/icon_warning.png', 340, 500, false);
		
		// Seta o body para hide, para nao exibir scroll com conteudo quebrado
		$('#page_content').hide();
		is_compatible = false;
	}
	
	return is_compatible;
}

/**
* round_number()
* Arredonda um numero em duas casas decimais.
* @param double rnum
* @return double rnum
*/
function round_number(rnum)
{
	return Math.round(rnum*Math.pow(10,2))/Math.pow(10,2);
}

/**
* to_moeda()
* Passa um numero para formato moeda.
* @param double num
* @return string rnum
*/
function to_moeda(num) 
{
    x = 0;
    if(num<0) {
		num = Math.abs(num);
		x = 1;
	}
	if(isNaN(num)) num = "0";
		cents = Math.floor((num*100+0.5)%100);

	num = Math.floor((num*100+0.5)/100).toString();

	if(cents < 10) cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
	
	ret = num + ',' + cents;
	if (x == 1) ret = ' - ' + ret; return ret;
}

/**
* to_float()
* Passa um numero para formato float, recebido como moeda.
* @param string moeda
* @return double rnum
*/
function to_float(moeda)
{
	moeda = moeda.replace(".","");
	moeda = moeda.replace(",",".");
	return parseFloat(moeda);
}

/**
* get_enter()
* Dispara uma funcao quando a tecla pressionada é 13 (enter).
* @param string event
* @param string function_eval
* @return void
*/
function get_enter(event, function_eval)
{
	if(event.which == 13) {	eval(function_eval); /*event.preventDefault();*/ }
}

/**
* download_excel()
* Cria um iframe em tempo real onde o target será uma página que exporta um arquivo excel.
* @param string url_export
* @return void
*/
function download_excel(url_export)
{
	$("body").append('<iframe src="' + url_export + '" style="display:none"></iframe>');
}

/**
* download_file()
* Cria um iframe em tempo real onde o target será uma página que exporta um file.
* @param string url_export
* @return void
*/
function download_file(url_export)
{
	$("body").append('<iframe src="' + url_export + '" style="display:none"></iframe>');
}

/**
* verify_login()
* Regra para Validação de login (unico) para validate jquery (formularios). Quando esta validação
* é utilizada em formulários, esta função é disparada retornando true ou false para o objeto
* que faz validação de formulário.
* @param object field
* @param object rules
* @param object i
* @param object options
* @return boolean
*/
function verify_login(field, rules, i, options)
{
	var retorno = false;
	
	$.ajax({
		url: $('#URL_ROOT').val() + '/acme_user/verify_login/' + field.val(),
		context: document.body,
		cache: false,
		async: false,
		// data: 'email=' + prUser,
		type: 'POST',
		success: function(json){
			json = JSON.parse(json);
			
			// alert(options.allrules.verify_login.alertText);
			if(json.user_exists == true)
			{
				retorno = true;
			}
		}
	});
	
	if(retorno)
		return options.allrules.verify_login.alertText;
}