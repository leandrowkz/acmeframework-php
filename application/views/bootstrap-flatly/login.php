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

<body>

<div id="fullscreen_bg" class="fullscreen_bg" style="background-image:url(<?php echo URL_IMG ?>/bg-15.png)">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-body" style="padding:25px;">
                    <div class="text-center" style="margin-bottom:25px"><img src="<?php echo URL_IMG ?>/logo-black-200.png" style="max-width:140px"/></div>
                    <form role="form" action="<?php echo URL_ROOT ?>/app_access/login_process" method="post">
                        <fieldset>
                            <div class="form-group<?php echo ($bool_user_error === true) ? ' has-error' : ''; ?>">
                                <input class="form-control" placeholder="<?php echo lang('E-mail ou usuário')?>" value="<?php echo $login_user; ?>" name="user" id="user" autofocus>
                                <?php if ($login_msg_error != '') { echo '<div class="text-danger" style="margin-top:3px">' . $login_msg_error . '</div>'; } ?>
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
