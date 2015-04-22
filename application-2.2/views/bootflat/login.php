<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo APP_NAME ?></title>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/jquery-1.10.2.js"></script>
    <script src="<?php echo URL_JS ?>/bootstrap.js"></script>
    <script src="<?php echo URL_JS ?>/plugins/bootbox/bootbox.min.js"></script>

    <!-- App Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/app-functions.js"></script>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- App CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootflat.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/app-styles.css" rel="stylesheet">

    <style>
        img#logo {
            max-width: 200px;
        }

        @media(min-width:768px) {
            .login-panel {
                margin-top: 30%;
            }
        }

        .fullscreen_bg {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-size: cover;
            background-position: 50% 50%;
        }
    </style>
</head>

<body>

<div id="fullscreen_bg" class="fullscreen_bg">

    <div class="container">

        <div class="row">
            
            <div class="col-md-4 col-md-offset-4">

                <div class="login-panel panel panel-default" style="border: 1px solid #eee">
                    
                    <div class="panel-body" style="padding:25px;">
                        
                        <div class="text-center" style="margin-bottom:25px">
                            <?php if( file_exists(PATH_IMG . '/logo.png')){ ?>
                                <img src="<?php echo URL_IMG ?>/logo.png" id="logo" />
                            <?php } else { ?>
                                <h3><?php echo APP_NAME ?></h3>
                            <?php } ?>
                        </div>

                        <form role="form" action="<?php echo URL_ROOT ?>/app_access/login_process" method="post">
                            <fieldset>
                                
                                <div class="form-group<?php echo ($bool_email_error === true) ? ' has-error' : ''; ?>">
                                    <input class="form-control" placeholder="<?php echo lang('Email')?>" value="<?php echo $email_user; ?>" name="email" id="email" autofocus>
                                    <?php if ($email_msg_error != '') { echo '<div class="text-danger" style="margin-top:3px">' . $email_msg_error . '</div>'; } ?>
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php echo lang('Password') ?>" name="pass" id="pass" type="password" value="">
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-primary btn-block" value="<?php echo lang('Enter')?>" />
                                </div>
                                
                                <div class="text-center"><a href="<?php echo URL_ROOT ?>/app_access/forgot_password"><?php echo lang('Forgot your password ?')?></a></div>
                            
                            </fieldset>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
