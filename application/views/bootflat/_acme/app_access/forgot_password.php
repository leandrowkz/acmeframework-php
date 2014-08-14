<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

                        <?php 

                        if( isset($error) ) {
                        
                        echo message('error', '', $error); ?>

                        <a href="<?php echo URL_ROOT ?>/app_access/forgot_password" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php } elseif( isset($success) ) { 

                        echo message('success', '', $success); ?>
                        
                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php } else { ?>
                        <form role="form" action="<?php echo URL_ROOT ?>/app_access/forgot_password/true" method="post">

                            <h4 class="text-center" style="margin-bottom: 30px"><?php echo lang('Forgot your password ?') ?></h4>

                            <fieldset>
                                
                                <div class="form-group">
                                    <input class="form-control validate[required,custom[email]]" placeholder="<?php echo lang('Enter your email') ?>" type="email" name="email" id="email" autofocus>
                                    
                                    <div class="checkbox" style="margin-top: 15px">
                                        <label>
                                            <input type="checkbox" id="validate_human" name="validate_human" class="validate[required]"> <?php echo lang('I am a human being') ?>
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

                            </fieldset>
                        </form>
                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/icheck/flat/red.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php ECHO LANGUAGE ?>.js"></script>

<script>
    // Validação de form
    $("form").validationEngine('attach', {promptPosition : "bottomRight"});

    // Validação de form tem que funcionar no resize
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });

    // ichecks
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });
</script>

</body>

</html>
