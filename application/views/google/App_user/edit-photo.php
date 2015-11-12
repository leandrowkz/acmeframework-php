<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10">
            <h1>
                <?php echo lang('Profile') ?>
                <i class="fa fa-fw fa-user"></i>
                <small>// <?php echo lang('User information') ?></small>
            </h1>
        </div>

        <div class="col-xs-2 col-sm-2">

            <div class="pull-right clearfix">

                <a href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo get_value($user, 'id_user') ?>" class="pull-right clearfix btn btn-default">
                    <i class="fa fa-arrow-circle-left hidden-lg hidden-md"></i>
                    <div class="hidden-xs hidden-sm">
                        <i class="fa fa-arrow-circle-left"></i>
                        <span><?php echo lang('Back') ?></span>
                    </div>
                </a>

            </div>

        </div>

    </div>

</div>

<div class="module-body">

    <div class="row">

        <div class="col-sm-3 user-data">

            <?php

            $id_user = get_value($user, 'id_user');
            $url_img = get_value($user, 'url_img');
            $url_img_large = tag_replace(get_value($user, 'url_img_large'));

            // Adjust thumb
            if (basename($url_img) != '' && file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img)))
                $url_img = tag_replace($url_img);
            else
                $url_img = URL_IMG . '/user-unknown.png';

            ?>

            <div class="text-center user-img">
                <img src="<?php echo $url_img ?>" class="img-circle img-responsive" />
            </div>

            <h4 class="text-center name">

                <div><i class="fa fa-fw fa-envelope-o"></i> <?php echo get_value($user, 'email') ?></div>

            </h4>

            <a href="<?php echo URL_ROOT ?>/app-user/edit-profile/<?php echo $id_user ?>" class="btn btn-md btn-primary btn-block"><?php echo lang('Edit profile') ?> <i class="fa fa-fw fa-edit"></i></a>

            <a href="<?php echo URL_ROOT ?>/app-user/edit-photo/<?php echo $id_user ?>" class="btn btn-md btn-primary btn-block"><?php echo lang('Change photo') ?> <i class="fa fa-fw fa-picture-o"></i></a>

            <a href="<?php echo URL_ROOT ?>/app-user/change-password/<?php echo $id_user ?>" class="btn btn-md btn-warning btn-block"><?php echo lang('Change password') ?> <i class="fa fa-fw fa-unlock-alt"></i></a>

        </div>

        <div class="col-sm-9 user-profile">

            <h2><?php echo get_value($user, 'name') ?></h2>

            <span class="label label-info cursor-default inline" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('User group') ?>">
                <i class="fa fa-fw fa-group"></i>
                <?php echo get_value($user, 'user_group') ?>
            </span>

            &nbsp;

            <?php if (get_value($user, 'active') == 'Y') : ?>

            <span class="label label-success cursor-default inline" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('User status') ?>">
                <i class="fa fa-fw fa-check-circle"></i>
                <?php echo lang('Active') ?>
            </span>

            <?php else : ?>

            <span class="label label-danger cursor-default inline" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('User status') ?>">
                <i class="fa fa-fw fa-minus-circle "></i>
                <?php echo lang('Inactive') ?>
            </span>

            <?php endif ?>

            <div class="row" style="margin-top:20px">

                <?php $file_exists = file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img_large)) && basename($url_img_large) != '' ? true : false; ?>
                <?php if($file_exists) {?>
                <div class="col-sm-8 col-xs-12 text-center">
                    <div>
                    <img src="<?php echo $url_img_large ?>" class="img-responsive" id="img-user" style="margin-bottom:15px" />
                    </div>
                </div>
                <?php } ?>

                <div class="col-sm-<?php echo ($file_exists) ? '4' : '12'; ?> col-xs-12 text-center">

                    <?php if ($file_exists) : ?>

                    <button class="btn btn-success btn-block cut-and-save"><?php echo lang('Cut and save')?> <i class="fa fa-fw fa-crop"></i></button>

                    <h4 style="margin: 30px 0"><?php echo lang('or') ?></h4>

                    <?php endif ?>

                    <form action="<?php echo URL_ROOT ?>/app-user/upload-photo/<?php echo $id_user ?>" enctype="multipart/form-data" method="post" class="dropzone" id="sendFile">

                        <div class="fallback text-center">
                            <input class="btn btn-default btn-xs text-center" name="file" id="file" type="file" />
                            <a class="btn btn-default btn-lg" href="javascript:void(0)" class="send-file-fallback"><?php echo lang('Send') ?></a>
                        </div>

                    </form>

                    <iframe name="iframe-fallback" id="iframe-fallback" style="display:none"></iframe>

                    <div id="msg-return-container" class="text-left" style="margin-top:15px"></div>
                    <div id="msg-template-error" style="display:none"><?php echo message('danger', 'Ops!', '<span id="msg-content"></span>', true); ?></div>
                    <div id="msg-template-success" style="display:none"><?php echo message('success', lang('OK!'), '<span id="msg-content"></span>', true); ?></div>
                </div>

            </div>

            <div class="row" style="margin-top: 20px;">

                <div class="col-sm-12">

                    <div class="form-footer">

                        <?php if ($file_exists) : ?>

                        <button class="btn btn-success cut-and-save"><?php echo lang('Cut and save') ?> <i class="fa fa-fw fa-crop"></i></button>

                        <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo $id_user ?>"><?php echo lang('Cancel') ?></a>

                        <?php else : ?>

                        <a class="btn btn-default" style="margin-top:5px" href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo $id_user ?>"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Back') ?></a>

                        <?php endif ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Dropzone Plugin -->
<script src="<?php echo URL_JS ?>/dropzone/dropzone.js"></script>
<link  href="<?php echo URL_JS ?>/dropzone/dropzone.css" rel="stylesheet" type="text/css" />

<!-- IMGAreaselect Plugin -->
<script src="<?php echo URL_JS ?>/imgareaselect/scripts/jquery.imgareaselect.min.js"></script>
<link href="<?php echo URL_JS ?>/imgareaselect/css/imgareaselect-default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URL_JS ?>/imgareaselect/css/imgareaselect-animated.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URL_JS ?>/imgareaselect/css/imgareaselect-deprecated.css" rel="stylesheet" type="text/css" />

<style>

    .user-data { margin-top: 0px; }
    .user-data > a.btn { margin-bottom: 15px; }
    .user-data > div { padding: 0 0 15px; text-align: center; }
    .user-data img {
        margin: 0 auto;
        text-align: center;
        border: 5px solid #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        width: 170px !important;
    }
    .user-data .name {
        font-size: 14px;
        line-height: 35px;
        margin-bottom: 15px;
        color: #888;
    }
    .user-data .name > div { margin-bottom: 5px; }
    .user-data .name small { color: #aaa; word-break: break-all; }
    .user-data h4 { margin-bottom: 0; }

    .user-profile h2 { margin-left: -1px; }
    .user-profile .label { margin-bottom: 20px; font-size: 12px !important; padding: 5px}
    .user-profile .label:last-child { margin-right: 10px; }

</style>

<script>

    // ========
    // Tooltips
    // ========
    $('body').tooltip({
        selector: '[data-toggle=tooltip]',
        container: 'body'
    });

    // ============
    // Some configs
    // ============
    var max_upload_size = 4; // MB

    <?php if ($file_exists) : ?>

    // =====================
    // For loading selection
    // =====================
    var px2 = ($('#img-user').width() < 150) ? $('#img-user').width() : 150;
    var py2 = ($('#img-user').height() < 150) ? $('#img-user').height() : 150;

    // ===================
    // Initialize the crop
    // ===================
    var crop = $('#img-user').imgAreaSelect({ instance : true });

    // Set options for crop
    crop.setOptions({
        aspectRatio: '1:1',
        handles: true,
        fadeSpeed: 200,
        movable: true,
        x1 : 0,
        x2 : px2,
        y1 : 0,
        y2 : py2
    });

    // Update crop
    crop.update();

    // =======================
    // Re-enable crop function
    // =======================
    $.reenable_crop = function () {
        crop.setOptions({ hide : true });
        crop.update();

        crop.setOptions({ disable : true });
        crop.update();

        crop.setOptions({ enable : true });
        crop.update();
    };

    // ===============================
    // Re-enable crop on window resize
    // ===============================
    $( window ).resize(function () {
        $.reenable_crop();
    });

    // ===================
    // Button cut and save
    // ===================
    $.make_thumbnail = function() {

        // Actual selection (x1, y1, ...)
        selection = crop.getSelection();

        if ( ! selection.width || ! selection.height) {
            bootbox.alert("<?php echo lang('To cut the image, select an area of current image.')?>");
            return;
        }

        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-user/edit-thumbnail/<?php echo $id_user ?>',
            data: {
                w : $("#img-user").width(),
                h : $("#img-user").height(),
                sw : selection.width,
                sh : selection.height,
                x1 : selection.x1,
                x2 : selection.x2,
                y1 : selection.y1,
                y2 : selection.y2,
            },
            context: document.body,
            cache: false,
            type: 'POST',
            success: function(data) {
                $.redirect( $('#URL_ROOT').val() + '/app-user/profile/<?php echo $id_user ?>' );
            },
            complete : function () {
                $.disable_loading();
            }
        });
    };

    // ========================
    // Trigger for cut and save
    // ========================
    $('.cut-and-save').on('click', function() {
        $.make_thumbnail();
    });
    <?php endif ?>

    // =================
    // Dropzone (upload)
    // =================
    Dropzone.options.sendFile = {

        init: function() {

            this.on("error", function(file, errorMessage) {
                $("#msg-template-error #msg-content").html(errorMessage);
                $("#msg-return-container").html($("#msg-template-error").html());
            });

            this.on("success", function(file, response) {

                <?php if ( ! $file_exists) : ?>
                window.location.reload();
                return;
                <?php endif ?>

                // Add success message
                $("#msg-template-success #msg-content").html("<?php echo lang('File successfully sent.')?>");
                $("#msg-return-container").html($("#msg-template-success").html());

                // Change img on the fly
                $("#img-user").attr("src", "<?php echo URL_UPLOAD . '/' . $this->photos_dir ?>/" + response);

                // Reset crop crop
                $.reenable_crop();

                // And then remove all thumbs
                this.removeAllFiles();
            });

            this.on("sending", function(file) {
                this.removeAllFiles();
            });
        },

        maxFilesize: max_upload_size,

        addRemoveLinks : true,

        dictDefaultMessage : '<div class="cursor-pointer"><i class="fa fa-cloud-upload fa-fw" style="font-size:70px;margin:0"></i><div class="lead text-bold" style="margin:0"><?php echo lang('Send an image')?></div><div><?php echo lang('Click or drop on this area')?></div></div>',

        dictRemoveFile : "<?php echo lang('Remove')?>",

        paramName : 'file',

        forceFallback : false
    };

    // ==============================================
    // Fallback function to send file (cross-browser)
    // ==============================================
    $.send_file_fallback = function() {

        // Change form target
        $('form#sendFile').attr('target', 'iframe-fallback').submit();

        // Get initial text:
        var changed = false;
        var previous = $("#iframe-fallback").contents().find("body");

        // Create a function for what to do if there is a change:
        $.check = function() {

            if ($("#iframe-fallback").contents().find("body") != previous && changed == false) {

                // Upload error
                if($("#iframe-fallback").contents().find("body error").length > 0)
                {
                    $("#msg-template-error #msg-content").html($("#iframe-fallback").contents().find("body error").html());
                    $("#msg-return-container").html($("#msg-template-error").html());

                // That's right!
                } else {
                    $("#msg-template-success #msg-content").html("<?php echo lang('File successfully sent.')?>");
                    $("#msg-return-container").html($("#msg-template-success").html());

                    // change image on the fly
                    $("#img-user").attr("src", "<?php echo URL_UPLOAD . '/' . $this->photos_dir ?>/" + $("#iframe-fallback").contents().find("body").html());

                    // Reset crop crop
                    $.reenable_crop();
                }

                changed = true;
            }

            // Store what contents are for later comparison
            previous = $("#iframe-fallback").contents().find("body");
        }
        // Right click work around is to check every Xs
        setInterval(function() { $.check(); }, 500);
    }

    // ==============================
    // Trigger for send file fallback
    // ==============================
    $('.send-file-fallback').on('click', function() {
        $.send_file_fallback();
    });

    // ======================================================
    // Listener do input file (prevent to upload large files)
    // ======================================================
    $('#file').change(function() {

        var file = this.files[0];
        var size = Math.round(file.size / 1000000);

        // Max size
        if(size > max_upload_size) {
            $("#msg-template-error #msg-content").html("<?php echo lang('File is too large') ?> (" + size + " MB). " + "<?php echo lang('Max file size')?>: " + max_upload_size + " MB.");
            $("#msg-return-container").html($("#msg-template-error").html());
            $(this).val('');
        }
    });
</script>
