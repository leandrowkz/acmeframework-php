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

                        <form role="form" action="<?php echo URL_ROOT ?>/app-login/login-process" method="post">

                            <div class="form-group<?php echo ($bool_email_error === true) ? ' has-error' : ''; ?>">
                                <input class="form-control" placeholder="<?php echo lang('Email')?>" value="<?php echo $email_user; ?>" name="email" id="email" autofocus>
                                <?php if ($email_msg_error != '') { echo '<div class="text-danger" style="margin-top:3px">' . $email_msg_error . '</div>'; } ?>
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="<?php echo lang('Password') ?>" name="pass" id="pass" type="password" value="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-default btn-block"><?php echo lang('Enter')?> <i class="fa fa-fw fa-sign-in"></i></button>
                            </div>

                            <div class="text-center text-bold"><a href="<?php echo URL_ROOT ?>/app-login/forgot-password"><?php echo lang('Forgot your password ?')?></a></div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
