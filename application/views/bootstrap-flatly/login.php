<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo APP_NAME ?></title>

<!-- Core CSS - Include with every page -->
<link href="<?php echo URL_CSS ?>/bootstrap.css" rel="stylesheet">
<link href="<?php echo URL_CSS ?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- ACME CSS - Include with every page -->
<link href="<?php echo URL_CSS ?>/app-core.css" rel="stylesheet">
<link href="<?php echo URL_CSS ?>/app-pages.css" rel="stylesheet">
<link href="<?php echo URL_CSS ?>/app-mobile-portrait.css" rel="stylesheet">
<link href="<?php echo URL_CSS ?>/app-mobile-landscape.css" rel="stylesheet">
<link href="<?php echo URL_CSS ?>/app-tablet-desktop.css" rel="stylesheet">

</head>

<body style="background-color:#f8f8f8;">

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
                                    <input class="form-control" placeholder="<?php echo lang('E-mail')?>" value="<?php echo $email_user; ?>" name="email" id="email" autofocus>
                                    <?php if ($email_msg_error != '') { echo '<div class="text-danger" style="margin-top:3px">' . $email_msg_error . '</div>'; } ?>
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php echo lang('Senha') ?>" name="pass" id="pass" type="password" value="">
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-primary btn-block" value="Entrar" />
                                </div>
                                
                                <div class="text-center"><a href="<?php echo URL_ROOT ?>/app_access/forgot_password"><?php echo lang('Esqueceu sua senha?')?></a></div>
                            
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
