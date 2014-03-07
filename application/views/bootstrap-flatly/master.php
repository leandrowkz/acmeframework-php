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
    <script src="<?php echo URL_JS ?>/plugins/bootbox/bootbox.min.js"></script>
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
            <?php echo $html ?>
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
