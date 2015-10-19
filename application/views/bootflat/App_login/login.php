<!DOCTYPE html>
<html>
<head>

    <?php echo $this->template->load_html_component('header-assets') ?>

    <style type="text/css">

        .login-panel { margin-top: 30%; }
        .login-panel .btn-lg { font-weight: bold; font-size: 22px; }
        .login-panel .panel-heading { border-bottom: none; color: #fff; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); padding: 30px; }
        .login-panel .panel-heading img { max-width: 200px; }
        .login-panel .panel-heading h3 { margin: 0; }

    </style>

</head>

<body>

    <div class="container">

        <div class="row">

            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

                <div class="panel panel-primary login-panel">

                    <div class="panel-heading">
                        <div class="text-center">
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
