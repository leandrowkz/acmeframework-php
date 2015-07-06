<!DOCTYPE html>
<html>
<head>
    <?php echo $this->template->load_html_component('header-assets') ?>
</head>

<body>

    <!-- Loading layer -->
    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

    <!-- Application constants hidden inputs -->
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

                <!-- brand/logo -->
                <?php echo $this->template->load_logo_area() ?>

                <!-- welcome/user-info -->
                <ul class="nav navbar-nav navbar-right">
                    <?php echo $this->template->load_user_info() ?>
                </ul>

            </div>

            <div class="navbar-collapse collapse">

                <ul class="nav navbar-nav">
                    <?php echo $this->template->load_menu() ?>
                </ul>

            </div>

        </div>

        <!-- Content loaded by View -->
        <div id="page-wrapper"> <?php echo $html ?> </div>

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
