<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h1>
                <?php echo lang('Profile') ?>
                <span><i class="fa fa-fw fa-user"></i></span>
                <small>// <?php echo lang('User information') ?></small>
            </h1>
        </div>
        
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

            <div class="pull-right clearfix">
                
                <a href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo get_value($user, 'id_user') ?>" class="pull-right clearfix btn btn-primary">
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

    <div class="user-profile-sidebar">
        
        <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-12 text-center">
                
                <?php 

                $id_user = get_value($user, 'id_user');
                $url_img = get_value($user, 'url_img');
                $url_img_large = tag_replace(get_value($user, 'url_img_large'));

                // Adjust thumb
                if(basename($url_img) != '' && file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img)))
                    $url_img = tag_replace($url_img);
                else
                    $url_img = URL_IMG . '/user-unknown.png';
                ?>

                <a href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>">
                    <img class="img-circular user-profile-img" src="<?php echo $url_img ?>" />
                </a>

            </div>
            
            <div class="user-profile-actions col-xs-6 col-sm-6 col-md-12">
                <a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_profile/<?php echo $id_user ?>"><i class="fa fa-edit fa-fw"></i> <?php echo lang('Edit profile') ?></a>
                <a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_photo/<?php echo $id_user ?>"><i class="fa fa-picture-o fa-fw"></i> <?php echo lang('Change image')?></a>
                <a class="btn btn-sm btn-warning btn-block" href="<?php echo URL_ROOT ?>/app_user/change_password/<?php echo $id_user ?>"><i class="fa fa-lock fa-fw"></i> <?php echo lang('Change password') ?></a>
            </div>

        </div>

    </div>

    <div class="user-profile-main-content">

        <div class="row" id="user-profile-name">
            <div class="col-sm-12">
                <h1 style="margin-top: 0"><?php echo get_value($user, 'name') ?></h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-top" id="user-profile-badges">
                <div style="vertical-align:top;display:inline-block;margin-top:-1px">
                    <div class="label label-info cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Group') ?>"><?php echo get_value($user, 'user_group') ?></div>
                    <?php if(get_value($user, 'active') == 'Y'){ ?>
                    <div class="label label-success"><i class="fa fa-check-circle fa-fw"></i> <?php echo lang('Active') ?></div>
                    <?php } else { ?>
                    <div class="label label-danger"><i class="fa fa-minus-circle fa-fw"></i> <?php echo lang('Inactive') ?></div>
                    <?php } ?>
                </div>
                <div style="display:inline-block;"><i class="fa fa-calendar fa-fw"></i> <?php echo lang('Member since:') . ' ' . get_value($user, 'log_dtt_ins') ?></div>
            </div>
        </div>

        <h3 style="margin: 30px 0 30px 0"><?php echo lang('Change image')?></h3>

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
                
                <?php if($file_exists) {?>
                <button class="btn btn-primary btn-block" onclick="make_thumbnail()"><?php echo lang('Cut and save')?></button>
                <p class="lead" style="margin:10px 0 20px 0"><?php echo lang('or') ?></p>
                <?php } ?>
                
                <form action="<?php echo URL_ROOT ?>/app_user/upload_photo/<?php echo $id_user ?>" enctype="multipart/form-data" method="post" class="dropzone" id="sendFile">
                    
                    <div class="fallback text-center">
                        <input class="btn btn-default btn-xs text-center" name="file" id="file" type="file" />
                        <a class="btn btn-default btn-lg" href="javascript:void(0)" onclick="send_file_fallback()"><?php echo lang('Send') ?></a>
                    </div>

                </form>

                <iframe name="iframe-fallback" id="iframe-fallback" style="display:none"></iframe>

                <div id="msg-return-container" class="text-left" style="margin-top:15px"></div>
                <div id="msg-template-error" style="display:none"><?php echo message('danger', 'Ops!', '<span id="msg-content"></span>', true); ?></div>
                <div id="msg-template-success" style="display:none"><?php echo message('success', lang('OK!'), '<span id="msg-content"></span>', true); ?></div>
            </div>

        </div>

        <div class="row bottom-group-buttons">
            
            <div class="col-sm-12">
                <?php if($file_exists) { ?>
                <button class="btn btn-primary" onclick="make_thumbnail()"><?php echo lang('Cut and save') ?></button>
                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><?php echo lang('Cancel') ?></a>
                <?php } else { ?>
                <a class="btn btn-primary" style="margin-top:5px" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Back') ?></a>
                <?php } ?>
            </div>

        </div>

    </div>

</div>

<script src="<?php echo URL_JS ?>/plugins/dropzone/dropzone.js"></script>
<script src="<?php echo URL_JS ?>/plugins/imgareaselect/jquery.imgareaselect.js"></script>
<script src="<?php echo URL_JS ?>/plugins/imgareaselect/jquery.imgareaselect.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/dropzone/dropzone.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-animated.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-deprecated.css" />

<script>
    // Some configs
    var max_upload_size = 4; // MB

    // tooltips
    $('.user-profile-main-content').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    <?php if($file_exists) { ?>
    
    // for loading selection
    var px2 = ($('#img-user').width() < 150) ? $('#img-user').width() : 150;
    var py2 = ($('#img-user').height() < 150) ? $('#img-user').height() : 150;

    // instantiate the crop
    var api = $('#img-user').imgAreaSelect({ instance : true });
    api.setOptions({ 
        aspectRatio: '1:1', 
        handles: true, 
        fadeSpeed: 200,
        movable: true,
        x1 : 0,
        x2 : px2,
        y1 : 0,
        y2 : py2
    });
    api.update();

    // Re-enable crop on window resize
    $( window ).resize(function () {

        api.setOptions({ hide : true });
        api.update();

        api.setOptions({ disable : true });
        api.update();

        api.setOptions({ enable : true });
        api.update();

    });

    // Button cut and save
    function make_thumbnail() {
        
        // actual selection (x1, y1, ...)
        selection = api.getSelection();

        if(!selection.width || !selection.height) {
            bootbox.alert("<?php echo lang('To cut the image, select an area of current image.')?>");
            return; 
        }

        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app_user/edit_thumbnail/<?php echo $id_user ?>',
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
                
                $.redirect( $('#URL_ROOT').val() + '/app_user/profile/<?php echo $id_user ?>' );

            },
            complete : function () {
                
                $.disable_loading();
            
            }
        });
    }
    <?php } ?>

    // dropzone (upload)
    Dropzone.options.sendFile = {
        init: function() {

            this.on("error", function(file, errorMessage) {
                $("#msg-template-error #msg-content").html(errorMessage); 
                $("#msg-return-container").html($("#msg-template-error").html());
            });

            this.on("success", function(file, response) {
                
                <?php if(!$file_exists) { ?>
                window.location.reload();
                return;
                <?php } ?>
                
                // add success message
                $("#msg-template-success #msg-content").html("<?php echo lang('File successfully sent.')?>"); 
                $("#msg-return-container").html($("#msg-template-success").html());

                // Change img on the fly
                $("#img-user").attr("src", "<?php echo URL_UPLOAD . '/' . $this->photos_dir ?>/" + response);

                // Reset crop api
                api.setOptions({ hide : true });
                api.update();

                api.setOptions({ disable : true });
                api.update();

                api.setOptions({ enable : true });
                api.update();

                // And then remove all thumbs
                this.removeAllFiles();
                
            });

            this.on("sending", function(file) {
                this.removeAllFiles();
            });
        },

        maxFilesize: max_upload_size,

        addRemoveLinks : true,

        dictDefaultMessage : '<div class="cursor-pointer"><i class="fa fa-cloud-upload fa-fw" style="font-size:70px;margin:0"></i><div class="lead" style="margin:0"><?php echo lang('Send an image')?></div><div><?php echo lang('Click or drop on this area')?></div></div>',
        
        dictRemoveFile : "<?php echo lang('Remove')?>",

        paramName : "file",

        forceFallback : false
    };

    // Fallback function to send file (cross-browser)
    function send_file_fallback() {

        // change form target
        $('form#sendFile').attr('target', 'iframe-fallback').submit();
        
        // Get initial text:
        var changed = false;
        var previous = $("#iframe-fallback").contents().find("body");

        // Create a function for what to do if there is a change:
        $check = function() {
        
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

                    // Reset crop api
                    api.setOptions({ hide : true });
                    api.update();

                    api.setOptions({ disable : true });
                    api.update();

                    api.setOptions({ enable : true });
                    api.update();
                }

                changed = true;

            }
            
            // Store what contents are for later comparison
            previous = $("#iframe-fallback").contents().find("body");

        }

        // Right click work around is to check every Xs
        setInterval(function() { $check(); }, 500);
    }

    // listener do input file (prevent to upload large files)
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

<style>
    #user-profile-badges {
        line-height:30px;
    }

    .user-profile-actions {
        margin-top: 20px;
    }

    .user-profile-actions a {
        margin-bottom: 10px !important;
    }

    .user-profile-img {
        width: 140px;
        height: 140px;
        background-size: cover;
        border-radius: 100px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
    }

    .user-profile-sidebar {
        width:150px;
        position:absolute;
    }

    .user-profile-main-content {
        margin-left:180px;
    }

    /* Mobile devices */
    @media(max-width: 768px){

        #user-profile-name h1 {
            text-align: center;
            font-size:30px;
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name a {
            display:none;
        }

        #user-profile-badges {
            text-align:center;
        }

        .user-profile-sidebar {
            width:100%;
            position:relative;
        }

        .user-profile-main-content {
            margin-left:0;
        }

        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 120px;
            width: 120px;
        }

        .list-user-info {
            margin: 2px 0 0 105px !important
        }
    }

    /* Mobile portrait */
    @media(max-width: 480px){
        .user-profile-sidebar {
            width:100%;
        }

        .dropdown-user {
            left:0;
            margin-right:-25px !important;
        }

        #user-profile-name h1 {
            text-align: center;
            font-size:30px;
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name button {
            display:none;
        }

        #user-profile-badges {
            text-align:center;
        }


        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 110px;
            width: 110px;
        }
    }

    /* Tablet and large desktops */
    @media(min-width: 768px) and (max-width: 991px) {
        .user-profile-sidebar {
            width:100%;
            position:relative;
        }

        .user-profile-main-content {
            margin-left:0;
        }

        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 120px;
            width: 120px;
        }

        #user-profile-name h1  {
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name button {
            margin: 35px 0 0 0 !important;
        }
    }
<style>