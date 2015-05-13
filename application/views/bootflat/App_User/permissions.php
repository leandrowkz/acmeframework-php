<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10">
            <h1>
                <?php echo lang($this->label) ?>
                <span><?php echo image($this->url_img) ?></span>
                <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
            </h1>
        </div>

        <div class="col-xs-2 col-sm-2">

            <div class="pull-right clearfix">

                <a href="<?php echo URL_ROOT ?>/app-user" class="pull-right clearfix btn btn-default">
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

            <a href="<?php echo URL_ROOT ?>/app-user" class="btn btn-md btn-default btn-block"><i class="fa fa-fw fa-arrow-circle-left"></i> <?php echo lang('Back') ?></a>

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

            <h3>Permissions</h3>

            <div class="permission" style="margin-bottom: 40px;">

                <div class="well">

                    <h4><?php echo get_value($permissions[0], 'module') ?></h4>

                    <?php
                    $i = 0;
                    $module = '';
                    foreach ($permissions as $permission) :
                    ?>

                    <?php if ($module != get_value($permission, 'module') && $i > 0) : ?>
                    </div>
                    <div class="permission" style="margin-bottom: 40px;">
                        <div class="well">
                        <h4><?php echo get_value($permission, 'module') ?></h4>
                    <?php endif ?>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="<?php echo get_value($permission, 'id_module_permission') ?>" <?php echo (get_value($permission, 'has_permission') == 'Y') ? 'checked="checked"' : ''; ?>>
                            <span><?php echo get_value($permission, 'permission') ?></span>
                            <span class="text-muted">// <?php echo get_value($permission, 'permission_description') ?></span>
                            <?php if(get_value($permission, 'permission_observation') != '') { ?>
                            <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_value($permission, 'permission_observation') ?>"></i>
                            <?php } ?>
                        </label>
                    </div>

                    <?php
                    $module = get_value($permission, 'module');
                    $i++;
                    endforeach;
                    ?>

            </div>

            </div>
            </div>

    </div>

</div>

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
        selector : '[data-toggle=tooltip]',
        container : 'body'
    });

    // ===========================
    // Click enable field checkbox
    // ===========================
    $('input[type="checkbox"]').on('click', function () {

        // Get id
        var id = $(this).attr('id');

        // Get operation
        var oper = $(this).is(':checked') ? 'enable' : 'disable';

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-user/save-permission/' + oper,
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
                    // Close modal and alert
                    bootbox.alert(json.error);
                    return false;
                }
            }
        });

    });

</script>
