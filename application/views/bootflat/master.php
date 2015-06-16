<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo APP_NAME ?></title>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/jquery-2.1.3.min.js"></script>
    <script src="<?php echo URL_CSS ?>/bootstrap/js/bootstrap.min.js"></script>

    <!-- App Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/app-functions.js"></script>

    <!-- CSS Assets - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_CSS ?>/bootflat/css/bootflat.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_CSS ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins Section -->

    <!-- Bootbox Plugin -->
    <script src="<?php echo URL_JS ?>/bootbox/bootbox.min.js"></script>

    <!-- MagicSuggest Plugin -->
    <link href="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.js"></script>

    <!-- ValidationEngine Plugin -->
    <link href="<?php echo URL_JS ?>/validationEngine/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo URL_JS ?>/validationEngine/js/jquery.validationEngine.js"></script>
    <script src="<?php echo URL_JS ?>/validationEngine/js/languages/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

    <!-- Meiomask Plugin -->
    <script src="<?php echo URL_JS ?>/jquery-meiomask/meiomask.js"></script>

    <!-- Plugins Section -->

    <!-- CSS Template - Override other styles -->
    <link href="<?php echo URL_TEMPLATE ?>/styles.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Loading layer -->
    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

    <!-- Application constants hidden inputs -->
    <?php echo app_settings_inputs(); ?>

    <div class="wrapper">

        <div class="navbar navbar-default navbar-fixed-top" role="navigation">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- welcome/user-info -->
                <ul class="nav navbar-nav navbar-right">
                    <?php echo $this->template->load_user_info() ?>
                </ul>

                <!-- brand/logo -->
                <?php echo $this->template->load_logo_area() ?>

            </div>

            <div class="navbar-collapse collapse">

                <ul class="nav navbar-nav">
                    <?php echo $this->template->load_menu() ?>
                </ul>

            </div>

        </div>

        <!-- Content loaded by View -->
        <div id="page-wrapper"> <?php echo $html ?> </div>

    </div>

    <script>

        // ==============================
        // Check session expires callback
        // ==============================
        $.check_session = function() {

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-login/check-session/',
                context: document.body,
                dataType : 'json',
                cache: false,
                type: 'POST',
                complete : function (data) {
                    json = $.parseJSON(data.responseText);
                    if( json.check_session === false ) {
                        $.redirect( $("#URL_ROOT").val() );
                    }
                }
            });
        };

        // Run at once
        $.check_session();

        // Run every 3 minutes
        setInterval(function () { $.check_session(); }, 180000);

    </script>

</body>

</html>
