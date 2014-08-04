<div class="row module-header">

	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		<h1><?php echo lang($this->label) ?>
		<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
		</h1>
	</div>
	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
</div>

<h3><?php echo lang('Constantes gerais') ?></h3>

<div class="row">
	<div class="col-sm-12 col-lg-8">
		

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>ENVIRONMENT</label>
				<i class="fa fa-question-circle fa-fw environment-help"></i>
			</div>
		    <div class="inline"><?php echo ENVIRONMENT ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>APP_NAME</label>
				<i class="fa fa-question-circle fa-fw app-name-help"></i>
			</div>
		    <div class="inline"><?php echo APP_NAME ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>TEMPLATE</label>
				<i class="fa fa-question-circle fa-fw template-help"></i>
			</div>
		    <div class="inline"><?php echo TEMPLATE ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>LANGUAGE</label>
				<i class="fa fa-question-circle fa-fw language-help"></i>
			</div>
		    <div class="inline"><?php echo LANGUAGE ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>EMAIL_FROM</label>
				<i class="fa fa-question-circle fa-fw email-from-help"></i>
			</div>
		    <div class="inline"><?php echo EMAIL_FROM ?></div>
		</div>
		
		<h3 style="margin: 40px 0 0"><?php echo lang('URLS') ?></h3>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_ROOT</label>
				<i class="fa fa-question-circle fa-fw url-root-help"></i>
			</div>
		    <div class="inline"><?php echo URL_ROOT ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_UPLOAD</label>
				<i class="fa fa-question-circle fa-fw url-upload-help"></i>
			</div>
		    <div class="inline"><?php echo URL_UPLOAD ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_TEMPLATE</label>
				<i class="fa fa-question-circle fa-fw url-template-help"></i>
			</div>
		    <div class="inline"><?php echo URL_TEMPLATE ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_INCLUDE</label>
				<i class="fa fa-question-circle fa-fw url-include-help"></i>
			</div>
		    <div class="inline"><?php echo URL_INCLUDE ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_CSS</label>
				<i class="fa fa-question-circle fa-fw url-css-help"></i>
			</div>
		    <div class="inline"><?php echo URL_CSS ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_JS</label>
				<i class="fa fa-question-circle fa-fw url-js-help"></i>
			</div>
		    <div class="inline"><?php echo URL_JS ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>URL_IMG</label>
				<i class="fa fa-question-circle fa-fw url-img-help"></i>
			</div>
		    <div class="inline"><?php echo URL_IMG ?></div>
		</div>

		<h3 style="margin: 40px 0 0"><?php echo lang('PATHS') ?></h3>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_TEMP</label>
				<i class="fa fa-question-circle fa-fw path-temp-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_TEMP ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_UPLOAD</label>
				<i class="fa fa-question-circle fa-fw path-upload-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_UPLOAD ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_INCLUDE</label>
				<i class="fa fa-question-circle fa-fw path-include-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_INCLUDE ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_CSS</label>
				<i class="fa fa-question-circle fa-fw path-css-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_CSS ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_JS</label>
				<i class="fa fa-question-circle fa-fw path-js-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_JS ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>PATH_IMG</label>
				<i class="fa fa-question-circle fa-fw path-img-help"></i>
			</div>
		    <div class="inline"><?php echo PATH_IMG ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px; word-break: break-all">
				<label>PATH_HTML_COMPONENTS</label>
				<i class="fa fa-question-circle fa-fw path-html-components-help"></i>
			</div>
		    <div class="inline" style="vertical-align:top"><?php echo PATH_HTML_COMPONENTS ?></div>
		</div>

		<h3 style="margin: 40px 0 0"><?php echo lang('Sessão') ?></h3>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>user_group</label>
				<i class="fa fa-question-circle fa-fw session-user-group-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('user_group') ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>user_name</label>
				<i class="fa fa-question-circle fa-fw session-user-name-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('user_name') ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>email</label>
				<i class="fa fa-question-circle fa-fw session-email-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('email') ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>user_img</label>
				<i class="fa fa-question-circle fa-fw session-user-img-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('user_img') ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>language</label>
				<i class="fa fa-question-circle fa-fw session-language-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('language') ?></div>
		</div>

		<div style="margin: 20px 0">
			<div class="inline" style="width: 150px">
				<label>url_default</label>
				<i class="fa fa-question-circle fa-fw session-url-default-help"></i>
			</div>
		    <div class="inline"><?php echo $this->session->userdata('url_default') ?></div>
		</div>				
	
	</div>

	<div class="col-sm-12 col-lg-4">

		<div class="panel panel-info">
    		<div class="panel-heading"><?php echo lang('Arquivos de configurações') ?></div>
    		<div class="panel-body">
    			<label><?php echo lang('Configurações da aplicação') ?>:</label>
    			<div><i class="fa fa-file-text-o fa-fw"></i> applications/config/<?php echo ENVIRONMENT ?>/app_settings.php</div>

    			<label style="margin-top: 20px"><?php echo lang('Banco de dados') ?>:</label>
    			<div><i class="fa fa-file-text-o fa-fw"></i> applications/config/<?php echo ENVIRONMENT ?>/database.php</div>

    			<label style="margin-top: 20px"><?php echo lang('Rotas (URLS)') ?>:</label>
    			<div><i class="fa fa-file-text-o fa-fw"></i> applications/config/<?php echo ENVIRONMENT ?>/routes.php</div>

    			<label style="margin-top: 20px"><?php echo lang('Configurações de email') ?>:</label>
    			<div><i class="fa fa-file-text-o fa-fw"></i> applications/config/<?php echo ENVIRONMENT ?>/email.php</div>
    		</div>
    	</div>

	</div>

</div>

<!-- html popovers content -->

<div class="code-app-name hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo APP_NAME; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#APP_NAME').val();</pre>
	</div>
</div>

<div class="code-environment hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo ENVIRONMENT; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#ENVIRONMENT').val();</pre>
	</div>
</div>

<div class="code-template hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo TEMPLATE; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#TEMPLATE').val();</pre>
	</div>
</div>

<div class="code-language hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo LANGUAGE; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#LANGUAGE').val();</pre>
	</div>
</div>

<div class="code-email-from hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo EMAIL_FROM; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#EMAIL_FROM').val();</pre>
	</div>
</div>

<div class="code-url-root hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_ROOT; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_ROOT').val();</pre>
	</div>
</div>

<div class="code-url-upload hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_UPLOAD; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_UPLOAD').val();</pre>
	</div>
</div>

<div class="code-url-template hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_TEMPLATE; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_TEMPLATE').val();</pre>
	</div>
</div>

<div class="code-url-include hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_INCLUDE; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_INCLUDE').val();</pre>
	</div>
</div>

<div class="code-url-css hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_CSS; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_CSS').val();</pre>
	</div>
</div>

<div class="code-url-js hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_JS; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_JS').val();</pre>
	</div>
</div>

<div class="code-url-img hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo URL_IMG; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#URL_IMG').val();</pre>
	</div>
</div>

<div class="code-path-temp hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_TEMP; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_TEMP').val();</pre>
	</div>
</div>

<div class="code-path-upload hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_UPLOAD; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_UPLOAD').val();</pre>
	</div>
</div>

<div class="code-path-include hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_INCLUDE; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_INCLUDE').val();</pre>
	</div>
</div>

<div class="code-path-css hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_CSS; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_CSS').val();</pre>
	</div>
</div>

<div class="code-path-js hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_JS; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_JS').val();</pre>
	</div>
</div>

<div class="code-path-img hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_IMG; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_IMG').val();</pre>
	</div>
</div>

<div class="code-path-html-components hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo PATH_HTML_COMPONENTS; ?&gt;</pre>
	</div>
	<div style="margin: 10px 0 0">
		<small><strong>JQuery</strong></small>
		<pre>$('#PATH_HTML_COMPONENTS').val();</pre>
	</div>
</div>

<div class="code-session-user-group hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('user_group'); ?&gt;</pre>
	</div>
</div>

<div class="code-session-user-name hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('user_name'); ?&gt;</pre>
	</div>
</div>

<div class="code-session-email hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('email'); ?&gt;</pre>
	</div>
</div>

<div class="code-session-user-img hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('user_img'); ?&gt;</pre>
	</div>
</div>

<div class="code-session-language hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('language'); ?&gt;</pre>
	</div>
</div>

<div class="code-session-url-default hide">
	<div>
		<small><strong>PHP</strong></small>
		<pre>&lt;?php echo $this->session->userdata('url_default'); ?&gt;</pre>
	</div>
</div>

<style>
	code { white-space: normal !important; }
	.panel-body div { word-break: break-all; }
	div.inline { word-break: break-all; }
</style>

<script>
	
	// popovers
    $('.environment-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-environment").html(); }
    });

    $('.app-name-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-app-name").html(); }
    });

    $('.template-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-template").html(); }
    });

    $('.language-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-language").html(); }
    });

    $('.email-from-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-email-from").html(); }
    });

    $('.url-root-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-root").html(); }
    });

    $('.url-upload-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-upload").html(); }
    });

    $('.url-template-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-template").html(); }
    });

    $('.url-include-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-include").html(); }
    });

    $('.url-css-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-css").html(); }
    });

    $('.url-js-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-js").html(); }
    });

    $('.url-img-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-url-img").html(); }
    });

    $('.path-temp-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-temp").html(); }
    });

    $('.path-upload-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-upload").html(); }
    });

    $('.path-include-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-include").html(); }
    });

    $('.path-css-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-css").html(); }
    });

    $('.path-js-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-js").html(); }
    });

    $('.path-img-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-img").html(); }
    });

    $('.path-html-components-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-path-html-components").html(); }
    });

    $('.session-user-group-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-user-group").html(); }
    });

    $('.session-user-name-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-user-name").html(); }
    });

    $('.session-email-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-email").html(); }
    });

    $('.session-user-img-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-user-img").html(); }
    });

    $('.session-language-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-language").html(); }
    });

    $('.session-url-default-help').popover( {
        trigger : 'hover',
        html: true,
        content: function () { return $(".code-session-url-default").html(); }
    });

</script>