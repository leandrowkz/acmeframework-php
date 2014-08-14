<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h1>
                <?php echo lang($this->label) ?>
                <span><?php echo image($this->url_img) ?></span>
                <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
            </h1>
        </div>
        
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

            <div class="pull-right clearfix">
                
                <a href="<?php echo URL_ROOT ?>/app_user" class="pull-right clearfix btn btn-primary">
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
            
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                
                <?php 

                $id_user = get_value($user, 'id_user');
                $url_img = get_value($user, 'url_img');

                // Adjust thumb
                if(basename($url_img) != '' && file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img)))
                    $url_img = tag_replace($url_img);
                else
                    $url_img = URL_IMG . '/user-unknown.png';
                ?>
                
                <img class="img-circular user-profile-img" src="<?php echo $url_img ?>" />

            </div>

        </div>

    </div>

    <div class="user-profile-main-content">

        <div class="row" id="user-profile-name">
            <div class="col-sm-12">
                <h1 style="margin-top:0"><?php echo get_value($user, 'name') ?></h1>
            </div>
        </div>
        
        <div class="row" style="margin-bottom: 30px ">
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

        <h3 style="margin: 0 0 30px 0"><?php echo lang('Permissions') ?></h3>
        
        <div class="permission" style="margin-bottom: 40px;">
            <h4><?php echo get_value($permissions[0], 'module') ?></h4>
        <?php 
        $i = 0;
        $module = '';
        foreach($permissions as $permission) { 
        ?>

        <?php if($module != get_value($permission, 'module') && $i > 0) { ?>
        </div>
        <div class="permission" style="margin-bottom: 40px;">
            <h4><?php echo get_value($permission, 'module') ?></h4>
        <?php } ?>

        <div class="checkbox">
            <label>
                <input type="checkbox" id="<?php echo get_value($permission, 'id_module_permission') ?>" <?php echo (get_value($permission, 'has_permission') == 'Y') ? 'checked="checked"' : ''; ?>> <?php echo get_value($permission, 'permission') ?> <span class="text-muted">// <?php echo get_value($permission, 'permission_description') ?></span>
                <?php if(get_value($permission, 'permission_observation') != '') { ?>
                <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_value($permission, 'permission_observation') ?>"></i>
                <?php } ?>
            </label>
        </div>

        <?php 
        $module = get_value($permission, 'module');
        $i++;
        } 
        ?>

    </div>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/icheck/flat/red.css" />

<script src="<?php echo URL_JS ?>/plugins/icheck/icheck.min.js"></script>

<script>

    // ichecks
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });

    // tooltips
    $('body').tooltip({ selector: "[data-toggle=tooltip]" });

    // click enable field checkbox
    $('input[type=checkbox]').on('ifChecked ifUnchecked', function () {

        // get id
        var id = $(this).attr('id');

        // get operation
        var oper = $(this).is(':checked') ? 'enable' : 'disable';

        // ajax to save this fucking shit
        $.enable_loading();
        
        $.ajax({
            url: $('#URL_ROOT').val() + '/app_user/save_permission/' + oper,
            context: document.body,
            data : { 
                'id_module_permission' : id ,
                'id_user' : <?php echo $id_user ?>
            },
            cache: false,
            type: 'POST',
            complete : function (response) { 
                
                $.disable_loading();
                
                // Parse json to check errors
                json = $.parseJSON(response.responseText);
                
                // Check return
                if( ! json.return) { 
                    // close modal and alert
                    bootbox.alert(json.error);
                    return false;
                } 
            }
        });

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
</style>