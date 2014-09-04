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

</head>

<body>

<?php echo app_settings_inputs(); ?>
    
    <div class="wrapper">

        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            
            <div class="navbar-header">
                
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- welcome/user-info -->
                <ul class="nav navbar-nav navbar-right">
                    <?php echo $this->template->load_user_info() ?>
                </ul>
                
                <!-- brand/logo -->
                <?php echo $this->template->load_logo_area() ?>

            </div>
            
            <div class="navbar-collapse collapse">
                
                <ul class="nav navbar-nav">
                    <?php echo $this->template->load_menu() ?>
                </ul>                
        
            </div>

        </div>

        <div id="page-wrapper">

            <?php echo $html ?>
        
        </div>
        <!-- /#page-wrapper -->
        
    </div>
    <!-- /#wrapper -->

    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

    <script>
        
        // Check session expires callback
        $.check_session = function() {
            
            $.ajax({
                url: $('#URL_ROOT').val() + '/app_access/check_session/',
                context: document.body,
                dataType : 'json',
                cache: false,
                type: 'POST',
                complete : function (data) {
                    json = $.parseJSON(data.responseText);
                    if( json.check_session === false ) {
                        $.redirect( $("#URL_ROOT").val() );
                    }
                }
            });
        };

        // Run at once
        $.check_session();

        // Run every 3 minutes
        setInterval(function () { $.check_session(); }, 180000);

    </script>

</body>

</html>
