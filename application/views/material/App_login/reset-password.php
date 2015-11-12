<!DOCTYPE html>
<html>
<head>

    <?php echo $this->template->load_html_component('header-assets'); ?>

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

                        <?php

                        if( isset($success) ) :

                        echo message('success', '', $success); ?>

                        <a href="<?php echo URL_ROOT ?>" class="btn btn-lg btn-primary btn-block"><?php echo lang('Back') ?></a>

                        <?php else : ?>

                        <form role="form" action="<?php echo URL_ROOT ?>/app-login/reset-password/<?php echo $id_user ?>/<?php echo $key_access ?>/true" method="post">

                            <div class="form-group">
                                <label><?php echo lang('New password') ?></label>
                                <input class="form-control validate[required,minSize[6]]" value="" type="password" name="password" id="password" autofocus>
                            </div>

                            <div class="form-group">
                                <label><?php echo lang('Confirm password') ?></label>
                                <input class="form-control validate[required,minSize[6],equals[password]]" value="" type="password" name="password_repeat" id="password_repeat">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo lang('Change my password') ?> <i class="fa fa-fw fa-unlock-alt"></i></button>
                            </div>

                        </form>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        // ======================
        // Initialize Material.js
        // ======================
        $.material.init();

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
