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

            <br />

            <div class="row">

                <div class="col-sm-8 col-xs-12 user-info">

                    <form role="form" action="<?php echo URL_ROOT ?>/app-user/edit-profile/<?php echo $id_user ?>/true" method="post" style="margin-left: 2px;">

                        <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user ?>" />

                        <div class="form-group">
                            <label><?php echo lang('Name')?>*</label>
                            <input class="form-control validate[required]" value="<?php echo get_value($user, 'name') ?>" name="name" id="name" autofocus>
                        </div>

                        <div class="form-group">
                            <label><?php echo lang('Default language')?>*</label>
                            <select class="form-control validate[required]" name="lang_default" id="lang_default">
                                <option value="en_US" <?php echo (get_value($user, 'lang_default') == 'en_US') ? 'selected="selected"' : ''; ?>><?php echo lang('English')?></option>
                                <option value="pt_BR" <?php echo (get_value($user, 'lang_default') == 'pt_BR') ? 'selected="selected"' : ''; ?>><?php echo lang('Brazilian Portuguese')?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo lang('Description')?></label>
                            <textarea class="form-control" name="description" id="description" style="height: 100px;"><?php echo get_value($user, 'description') ?></textarea>
                        </div>

                        <div class="form-footer">
                            <button class="btn btn-success" type="submit"><?php echo lang('Save') ?> <i class="fa fa-fw fa-check-circle"></i></button>
                            <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo $id_user ?>"><?php echo lang('Cancel') ?></a>
                        </div>

                    </form>

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
        selector: '[data-toggle=tooltip]',
        container: 'body'
    });

    // ===============
    // Form validation
    // ===============
    $('form').validationEngine('attach', {promptPosition : 'bottomRight'});

    // ===========================================
    // Reposition form validation on window resize
    // ===========================================
    $( window ).resize( function () {
        $('form').validationEngine('updatePromptsPosition');
    });
</script>
