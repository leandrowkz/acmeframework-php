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
		html, body { background-color:#f8f8f8; height:auto; }
		h1, h3, h4 { margin: 0 0 20px; }
		h5 { margin: 0 0 5px; }
		.panel-body { 
			padding:25px;

       	}
	</style>

</head>

<body style="margin:30px">

	<div class="row">

		<div class="col-md-8 col-md-offset-2 text-center">

			<div class="panel panel-default panel-body" style="border: 1px solid #eee">
				
				<h1 style="font-size:90px"><?php echo lang('404')?></h1>
				
				<h3 class="hidden-lg hidden-md"><?php echo lang('Esta página não existe')?></h3>
				
				<h1 class="hidden-xs hidden-sm"><?php echo lang('Esta página não existe :(')?></h1>
				
				<h4><?php echo lang('Verifique o endereço digitado e tente novamente.')?></h4>
						
				<?php $url = $this->session->userdata('url_default') ? $this->session->userdata('url_default') : URL_ROOT; ?>
				<a href="<?php echo $url ?>" class="btn btn-success btn-lg"><?php echo lang('Página inicial')?> <i class="fa fa-arrow-circle-right fa-fw"></i></a>
			
			</div>
		
		</div>

	</div>

</body>

</html>