<!DOCTYPE html>
<html>
<head>

    <?php echo $this->template->load_html_component('header-assets') ?>

    <style>
        body { padding: 30px; }
        h1, h2, h3, h4, h5 { margin: 0 0 30px; }
        .panel-body { padding: 30px; }
        .btn { font-size: 30px; }
    </style>

</head>

<body>

    <div class="row">

    <div class="col-sm-8 col-sm-offset-2">

    <div class="panel panel-default text-center">

        <div class="panel-body">

			<h1 style="font-size: 120px; margin-bottom: 20px"><?php echo lang('404')?></h1>

			<h2 class="hidden-lg hidden-md"><?php echo lang('Page not found.')?></h2>

			<h2 class="hidden-xs hidden-sm"><?php echo lang('Page not found.')?></h2>

			<h4><?php echo lang('Check URL and try it again.')?></h4>

			<?php $url = $this->session->userdata('url_default') ? $this->session->userdata('url_default') : URL_ROOT; ?>
			<a href="<?php echo $url ?>" class="btn btn-success btn-lg"><?php echo lang('Home page')?> <i class="fa fa-arrow-circle-right fa-fw"></i></a>

		</div>

    </div>

    </div>

	</div>

</body>

</html>
