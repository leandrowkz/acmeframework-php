<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo APP_NAME ?></title>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/jquery-1.10.2.js"></script>
    <script src="<?php echo URL_JS ?>/bootstrap.min.js"></script>
    <script src="<?php echo URL_JS ?>/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- App Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/app-functions.js"></script>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- App CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/app-core.css" rel="stylesheet">
	<link href="<?php echo URL_CSS ?>/app-pages.css" rel="stylesheet">
	<link href="<?php echo URL_CSS ?>/app-mobile-portrait.css" rel="stylesheet">
	<link href="<?php echo URL_CSS ?>/app-mobile-landscape.css" rel="stylesheet">
	<link href="<?php echo URL_CSS ?>/app-tablet-desktop.css" rel="stylesheet">

	<style>
		html, body { background-color:#f8f8f8; height:auto !important; }
		h1, h3, h4 { margin: 0 0 20px; }
		h5 { margin: 0 0 5px; }
		.panel-body { 
			padding:25px;
       	}
	</style>

</head>

<body>

<?php echo app_settings_inputs(); ?>
    
    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only"><?php echo lang('Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $this->template->load_logo_area() ?>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php echo $this->template->load_user_info() ?>
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
        <!-- /.navbar-static-top -->

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php echo $this->template->load_menu() ?>
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->

        <div id="page-wrapper">
				
			<h3 class="hidden-lg hidden-md"><?php echo lang('Ops! Erro no banco de dados')?></h3>
			<h1 class="hidden-xs hidden-sm"><?php echo lang('Ops! Erro no banco de dados')?></h1>
			<h4><?php echo lang('Não se preocupe, o problema já foi encaminhado para correção.')?></h4>
			<?php if(ENVIRONMENT != 'production') { ?>
			<div class="text-danger" style="margin-bottom:20px">
				<h5><strong><?php echo lang('Detalhes técnicos')?></strong></h5>
				<?php 
				if(is_array($message)) {
					foreach($message as $msg)
						if($msg != '')
							echo '<div>> ' . $msg . '</div>';
				} else {
					echo '<div>> ' . $message . '</div>';
				}
				?>
			</div>
			<?php } ?>
			
			<a href="<?php $this->session->userdata('url_default') ?>" class="btn btn-success btn-lg"><?php echo lang('Página inicial')?> <i class="fa fa-home fa-fw"></i></a>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<div class="loading-layer"></div>
<div class="loading-box"><h4 style="vertical-align:middle !important"><?php echo lang('Carregando...')?></h4></div>

<script>

    $check_session = function() {
        
        $.ajax({
            url: $('#URL_ROOT').val() + '/app_access/check_session/',
            context: document.body,
            dataType : 'json',
            cache: false,
            async: false,
            type: 'POST',
            complete : function (data) {
                json = $.parseJSON(data.responseText);
                if( json.check_session === false ) {
                    redirect($("#URL_ROOT").val());
                }
            }
        });
    };

    // Run at once
    $check_session();

    // Run every 3 minutes
    setInterval(function () { $check_session(); }, 180000);

</script>

</body>

</html>
