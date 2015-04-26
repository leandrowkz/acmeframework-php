<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo APP_NAME ?></title>
    <!-- Core CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- App CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootflat.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/app-styles.css" rel="stylesheet">

	<style>
		h1, h3, h4 { margin: 0 0 20px; }
		h5 { margin: 0 0 5px; }
		.panel-body {
			padding:25px;

       	}
	</style>

</head>

<body style="margin:30px">

	<div class="panel panel-default panel-body" style="border: 1px solid #eee">

		<h3 class="hidden-lg hidden-md"><?php echo lang('An error has been occurred.')?></h3>
		<h1 class="hidden-xs hidden-sm"><?php echo lang('An error has been occurred.')?></h1>
		<div class="text-danger" style="margin-bottom:20px">
            <h4><?php echo lang('Type') ?>: <?php echo get_class($exception); ?></h4>
            <h4><?php echo lang('Message') ?>: <?php echo $exception->getMessage(); ?></h4>
            <h4><?php echo lang('Filename') ?>: <?php echo $exception->getFile(); ?></h4>
            <h4><?php echo lang('Line Number') ?>: <?php echo $exception->getLine(); ?></h4>
		</div>

        <!--
        <php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
            <p>Backtrace:</p>
            <php foreach ($exception->getTrace() as $error): ?>

                <php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                    <p style="margin-left:10px">
                    File: <php echo $error['file']; ?><br />
                    Line: <php echo $error['line']; ?><br />
                    Function: <php echo $error['function']; ?>
                    </p>
                <php endif ?>

            <php endforeach ?>

        <php endif ?>
        -->

		<?php $url = $this->session->userdata('url_default') ? $this->session->userdata('url_default') : URL_ROOT; ?>
		<a href="<?php echo $url ?>" class="btn btn-success btn-lg"><?php echo lang('Initial page')?> <i class="fa fa-arrow-circle-right fa-fw"></i></a>

	</div>

</body>