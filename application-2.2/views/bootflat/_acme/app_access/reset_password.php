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

                        if( isset($success) ) { 

                        echo message('success', '', $success); ?>
                        
                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php } else { ?>

                        <form role="form" action="<?php echo URL_ROOT ?>/app_access/reset_password/<?php echo $id_user ?>/<?php echo $key_access ?>/true" method="post">
                            <fieldset>
                                
                                <div class="form-group">
                                    <label><?php echo lang('New password') ?></label>
                                    <input class="form-control validate[required,minSize[6]]" value="" type="password" name="password" id="password" autofocus>
                                </div>

                                <div class="form-group">
                                    <label><?php echo lang('Confirm password') ?></label>
                                    <input class="form-control validate[required,minSize[6],equals[password]]" value="" type="password" name="password_repeat" id="password_repeat">
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-primary btn-block" value="<?php echo lang('OK, Change my password') ?>" />
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
