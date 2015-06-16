<!DOCTYPE html>
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
    <script src="<?php echo URL_JS ?>/meiomask/meiomask.min.js"></script>

    <!-- Plugins Section -->

    <!-- CSS Template - Override other styles -->
    <link href="<?php echo URL_TEMPLATE ?>/styles.css" rel="stylesheet" type="text/css" />

    <style type="text/css">

        .login-panel { margin-top: 30%; }
        .login-panel .btn-lg { font-weight: bold; font-size: 22px; }
        .login-panel .panel-heading { border-bottom: none; color: #fff; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); }
        .login-panel .panel-heading h3 { margin: 15px 0; }

    </style>

</head>

<body>

    <div class="container">

        <div class="row">

            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

                <div class="panel panel-primary login-panel">

                    <div class="panel-heading">
                        <div class="text-center" style="margin-bottom:25px">
                            <?php if( file_exists(PATH_IMG . '/logo.png')){ ?>
                                <img src="<?php echo URL_IMG ?>/logo.png" id="logo" />
                            <?php } else { ?>
                                <h3><?php echo APP_NAME ?></h3>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="panel-body" style="padding:25px;">

                        <?php

                        if( isset($error) ) {

                        echo message('error', '', $error); ?>

                        <a href="<?php echo URL_ROOT ?>/app-login/forgot-password" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php } elseif( isset($success) ) {

                        echo message('success', '', $success); ?>

                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php } else { ?>

                        <form role="form" action="<?php echo URL_ROOT ?>/app-login/forgot-password/true" method="post">

                            <h4 class="text-center" style="margin-bottom: 30px"><?php echo lang('Forgot your password ?') ?></h4>

                            <div class="form-group">
                                <input class="form-control validate[required,custom[email]]" placeholder="<?php echo lang('Enter your email') ?>" type="email" name="email" id="email" autofocus>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="validate_human" id="validate-human" class="validate[required]" value="Y" />
                                        <?php echo lang('I am human') ?>
                                    </label>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-xs-6">

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block" value="<?php echo lang('Send') ?>" />
                                    </div>

                                </div>

                                <div class="col-xs-6">

                                    <div class="form-group">
                                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-default btn-block"><?php echo lang('Back') ?></a>
                                    </div>

                                </div>
                            </div>

                        </form>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        // ===============
        // Form validation
        // ===============
        $('form').validationEngine('attach', { promptPosition : 'bottomRight' } );

        // =====================================
        // Resize adjusments for form validation
        // =====================================
        $( window ).resize( function () {
            $('form').validationEngine('updatePromptsPosition');
        });
    </script>

</body>

</html>
