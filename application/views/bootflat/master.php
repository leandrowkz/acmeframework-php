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
    
    <div id="wrapper">

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

                    <!--
                
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Notifications <i class="fa fa-wrench"></i></a></li>
                            <li class="dropdown dropdown-submenu">
                                <a href="#">Edit Account </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Page with comments</a></li>
                                    <li><a href="#">Page with comments disabled</a></li>
                                    <li class="dropdown dropdown-submenu">
                                        <a href="#">More</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">3rd level link more options</a></li>
                                            <li><a href="#">3rd level link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li><i class="fa"></i><a href="#" class="dropdown-toggle" data-toggle="dropdown">Logout <i class="fa fa-power-off padding-left-ten-px red-text"></i></a>
                            </li>
                        </ul>
                    </li>

                </ul>
                -->
                
        
            </div>

        </div>

        <div id="page-wrapper">

            <?php echo $html ?>
        
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


<div class="loading-layer"></div>
<div class="loading-box"><h4 style="vertical-align:middle !important"><?php echo lang('Carregando...')?></h4></div>

<script>

    $check_session = function() {
        
        $.ajax({
            url: $('#URL_ROOT').val() + '/app_access/check_session/',
            context: document.body,
            dataType : 'json',
            cache: false,
            async: false,
            type: 'POST',
            complete : function (data) {
                json = $.parseJSON(data.responseText);
                if( json.check_session === false ) {
                    redirect($("#URL_ROOT").val());
                }
            }
        });
    };

    // Run at once
    $check_session();

    // Run every 3 minutes
    setInterval(function () { $check_session(); }, 180000);

</script>

</body>

</html>
