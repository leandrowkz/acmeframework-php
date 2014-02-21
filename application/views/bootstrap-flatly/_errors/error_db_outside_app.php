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

	<div class="panel panel-default panel-body">
		
		<h3 class="hidden-lg hidden-md"><?php echo lang('Ops! Erro no banco de dados')?></h3>
		<h1 class="hidden-xs hidden-sm"><?php echo lang('Ops! Erro no banco de dados')?></h1>
		<h4><?php echo lang('Não se preocupe, o problema já foi encaminhado para correção.')?></h4>
		<?php if(ENVIRONMENT != 'production') { ?>
		<div class="text-danger" style="margin-bottom:20px">
			<h5><strong><?php echo lang('Detalhes técnicos')?></strong></h5>
			<?php 
			if(is_array($message)) {
				foreach($message as $msg)
					echo '<div>> ' . $msg . '</div>';
			} else {
				echo '<div>> ' . $message . '</div>';
			}
			?>
		</div>
		<?php } ?>
		
		<a href="<?php echo URL_ROOT ?>" class="btn btn-success btn-lg"><?php echo lang('Página inicial')?> <i class="fa fa-arrow-circle-right fa-fw"></i></a>
	
	</div>

</body>

</html>