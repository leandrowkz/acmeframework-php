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

                        <?php 

                        if( isset($error) ) {
                        
                        echo message('error', '', $error); ?>

                        <a href="<?php echo URL_ROOT ?>/app_access/forgot_password" class="btn btn-lg btn-primary btn-block"><?php echo lang('Voltar') ?></a>

                        <?php } elseif( isset($success) ) { 

                        echo message('success', '', $success); ?>
                        
                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-primary btn-block"><?php echo lang('Voltar') ?></a>

                        <?php } else { ?>
                        <form role="form" action="<?php echo URL_ROOT ?>/app_access/forgot_password/true" method="post">

                            <h4 class="text-center" style="margin-bottom: 30px"><?php echo lang('Esqueceu sua senha ?') ?></h4>

                            <fieldset>
                                
                                <div class="form-group">
                                    <input class="form-control validate[required,custom[email]]" placeholder="<?php echo lang('Insira seu email') ?>" type="email" name="email" id="email" autofocus>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="validate_human" name="validate_human" class="validate[required]"> <?php echo lang('Sou um ser humano') ?>
                                        </label>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-xs-6">
                                        
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="<?php echo lang('Enviar') ?>" />
                                        </div>

                                    </div>
                                    
                                    <div class="col-xs-6">
                                        
                                        <div class="form-group">
                                            <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-default btn-block"><?php echo lang('Voltar') ?></a>
                                        </div>

                                    </div>  
                                </div>

                            </fieldset>
                        </form>
                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/jquery-1.10.2.js"></script>
<script src="<?php echo URL_JS ?>/bootstrap.min.js"></script>
<script src="<?php echo URL_JS ?>/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php ECHO LANGUAGE ?>.js"></script>

<script>
    // Validação de form
    $("form").validationEngine('attach', {promptPosition : "bottomRight"});

    // Validação de form tem que funcionar no resize
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });
</script>

</body>

</html>
