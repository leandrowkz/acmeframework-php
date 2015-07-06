<!DOCTYPE html>
<html>
<head>
    <?php echo $this->template->load_html_component('header-assets') ?>
</head>

<body class="skin-blue sidebar-mini
            <?php echo $this->input->cookie('body-layout') == '' ? 'fixed' : $this->input->cookie('body-layout') ?>
            <?php echo $this->input->cookie('sidebar-collapse') ?>">

    <!-- Loading layer -->
    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

    <!-- Application constants hidden inputs -->
    <?php echo app_settings_inputs(); ?>

    <div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <?php echo $this->template->load_logo_area() ?>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <!-- User info -->
            <?php echo $this->template->load_user_info() ?>
        </nav>

    </header>

    <aside class="main-sidebar">

        <!-- Sidebar -->
        <section class="sidebar">

            <!-- Sidebar user panel -->
            <div class="user-panel">
                <?php
                // User first name
                $first_name = get_value(explode(' ', $this->session->userdata('user_name')), '0');

                // Image adjustment (in case that image doesnt exist)
                $user_img = $this->session->userdata('user_img');
                $user_img = ( ! file_exists(PATH_UPLOAD . '/user-photos/' . basename($user_img)) || basename($user_img) == '') ? URL_IMG . '/user-unknown.png' : $user_img;
                ?>
                <div class="pull-left image">
                    <img src="<?php echo $user_img ?>" class="img-circle" />
                </div>
                <div class="pull-left info">
                    <p>
                        <?php echo $first_name ?>
                        <br />
                        <small><a href="javascript:void(0)"><i class="fa fa-circle text-success"></i> Online</a></small>
                    </p>
                </div>
            </div>

            <!-- Sidebar menu -->
            <ul class="sidebar-menu">

                <li class="header"><?php echo lang('MAIN NAVIGATION') ?></li>

                <?php echo $this->template->load_menu() ?>

            </ul>

        </section>
        <!-- /.sidebar -->

    </aside>

      <!-- Content Wrapper. Contains page content -->
        <!--

            <div class="navbar-collapse collapse">

                <ul class="nav navbar-nav">

                </ul>

            </div>

        </div> -->

    <!-- Content loaded by View -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content"><?php echo $html ?></section>

    </div>

    </div>

    </div>

    <script>

        // ==============================
        // Check session expires callback
        // ==============================
        $.check_session = function() {

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-login/check-session/',
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
