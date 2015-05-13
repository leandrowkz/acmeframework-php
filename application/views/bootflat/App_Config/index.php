<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10">
            <h1>
                <?php echo lang($this->label) ?>
                <span><?php echo image($this->url_img) ?></span>
                <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
            </h1>
        </div>

        <?php if ( count($this->menus) > 0 ) {?>

        <div class="col-xs-2 col-sm-2">

            <div class="btn-group pull-right clearfix">

                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-fw fa-cogs hidden-lg hidden-md"></i>
                    <div class="hidden-xs hidden-sm">
                        <i class="fa fa-fw fa-cogs"></i>
                        <span><?php echo lang('Actions') ?></span>
                        <span class="caret"></span>
                    </div>
                </button>

                <ul class="dropdown-menu">
                    <?php
                    foreach ($this->menus as $menu) {

                    // Build link
                    $link = tag_replace(get_value($menu, 'link'));
                    $target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
                    $label = lang(get_value($menu, 'label'));
                    $img = image(get_value($menu, 'url_img'));

                    ?>
                    <li><a href="<?php echo $link ?>" <?php echo $target ?>><?php echo $img . ' ' . $label ?></a></li>
                    <?php } ?>
                </ul>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<div class="module-body">

    <div class="row">

        <div class="col-sm-7 col-lg-7">

            <div class="input-group" style="margin-bottom: 30px">
                <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                <input id="search-module" type="search" class="form-control" placeholder="<?php echo lang('Search settings') ?>" autofocus="autofocus" />
            </div>

            <div class="list-group">

                <a href="javascript:void(0)" class="list-group-item acme-version">
                    <h1 class="pull-left"><i class="fa fa-fw fa-wrench"></i></h1>
                    <span class="label label-primary pull-right"><?php echo lang('General') ?></span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('ACME version') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo ACME_VERSION ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/core/ACME_Core.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item app-name">
                    <h1 class="pull-left"><i class="fa fa-fw fa-info-circle"></i></h1>
                    <span class="label label-primary pull-right">General</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Application name') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo APP_NAME ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/database.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item environment">
                    <h1 class="pull-left"><i class="fa fa-fw fa-building"></i></h1>
                    <span class="label label-primary pull-right">General</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Environment') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo ENVIRONMENT ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/database.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item database-driver">
                    <h1 class="pull-left"><i class="fa fa-fw fa-database"></i></h1>
                    <span class="label label-default pull-right">Database</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Database driver') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo DB_DRIVER ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/database.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item language">
                    <h1 class="pull-left"><i class="fa fa-fw fa-language"></i></h1>
                    <span class="label label-primary pull-right">General</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Application language') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo LANGUAGE ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item template">
                    <h1 class="pull-left"><i class="fa fa-fw fa-gift"></i></h1>
                    <span class="label label-primary pull-right">General</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Current template') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo TEMPLATE ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item email-from">
                    <h1 class="pull-left"><i class="fa fa-fw fa-envelope"></i></h1>
                    <span class="label label-primary pull-right">General</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Email "from"') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo EMAIL_FROM ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-root">
                    <h1 class="pull-left"><i class="fa fa-fw fa-terminal"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL application/project root') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_ROOT ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-upload">
                    <h1 class="pull-left"><i class="fa fa-fw fa-upload"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL uploads') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_UPLOAD ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-include">
                    <h1 class="pull-left"><i class="fa fa-fw fa-cube"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL template') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_TEMPLATE ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-include">
                    <h1 class="pull-left"><i class="fa fa-fw fa-tasks"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL Assets') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_ASSETS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-css">
                    <h1 class="pull-left"><i class="fa fa-fw fa-magic"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL css') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_CSS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-js">
                    <h1 class="pull-left"><i class="fa fa-fw fa-code"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL js') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_JS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item url-img">
                    <h1 class="pull-left"><i class="fa fa-fw fa-picture-o"></i></h1>
                    <span class="label label-danger pull-right">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL images') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo URL_IMG ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-temp">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Temporary path') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_TEMP ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-upload">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Uploads path') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_UPLOAD ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-include">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Assets path') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_ASSETS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-css">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Path css') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_CSS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-js">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Path js') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_JS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-img">
                    <h1 class="pull-left"><i class="fa fa-fw fa-angle-double-right"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('Path images') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_IMG ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item path-html-components">
                    <h1 class="pull-left"><i class="fa fa-fw fa-puzzle-piece"></i></h1>
                    <span class="label label-info pull-right">Path</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('HTML components path') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo PATH_HTML_COMPONENTS ?></div>
                        <div class="text-muted"><small><?php echo lang('File')?>: application/config/<?php echo ENVIRONMENT ?>/app_settings.php</small></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-url-default">
                    <h1 class="pull-left"><i class="fa fa-fw fa-home"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <span class="label label-danger pull-right" style="margin-right: 5px">URL</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL user home') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('url_default') ?></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-user-group">
                    <h1 class="pull-left clearfix"><i class="fa fa-fw fa-users"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('User group') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('user_group') ?></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-id-user">
                    <h1 class="pull-left"><i class="fa fa-fw fa-compass"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('User ID') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('id_user') ?></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-user-name">
                    <h1 class="pull-left"><i class="fa fa-fw fa-child"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('User name') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('user_name') ?></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-email">
                    <h1 class="pull-left"><i class="fa fa-fw fa-envelope-o"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('User email') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('email') ?></div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-user-img">
                    <h1 class="pull-left"><i class="fa fa-fw fa-picture-o"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('URL user image') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div>
                            <?php
                            if( $this->session->userdata('user_img') == '')
                                echo lang('No image');
                            else
                                echo $this->session->userdata('user_img');
                            ?>
                        </div>
                    </div>
                </a>

                <a href="javascript:void(0)" class="list-group-item session-language">
                    <h1 class="pull-left"><i class="fa fa-fw fa-language"></i></h1>
                    <span class="label label-warning pull-right">Session</span>
                    <h5 class="list-group-item-heading">
                        <span><?php echo lang('User language') ?></span>
                    </h5>
                    <div class="list-group-item-text">
                        <div><?php echo $this->session->userdata('language') ?></div>
                    </div>
                </a>

            </div>

        </div>

        <div class="col-sm-5 col-lg-5">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <?php echo lang('Settings files') ?>
                    <i class="fa fa-fw fa-cogs"></i>
                </div>

                <div class="panel-body">
                    <label><?php echo lang('Application settings') ?></label>
                    <div>application/config/<?php echo ENVIRONMENT ?>/<strong>app_settings.php</strong></div>

                    <label style="margin-top: 20px"><?php echo lang('Databases') ?></label>
                    <div>application/config/<?php echo ENVIRONMENT ?>/<strong>database.php</strong></div>

                    <label style="margin-top: 20px"><?php echo lang('Routes (URLs)') ?></label>
                    <div>application/config/<?php echo ENVIRONMENT ?>/<strong>routes.php</strong></div>

                    <label style="margin-top: 20px"><?php echo lang('Email settings') ?></label>
                    <div>application/config/<?php echo ENVIRONMENT ?>/<strong>email.php</strong></div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- HTML popovers content  -->
<div class="code-acme-version hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo ACME_VERSION; ?&gt;</pre>
    </div>
</div>

<div class="code-app-name hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo APP_NAME; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#APP_NAME').val();</pre>
    </div>
</div>

<div class="code-environment hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo ENVIRONMENT; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#ENVIRONMENT').val();</pre>
    </div>
</div>

<div class="code-database-driver hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo DB_DRIVER; ?&gt;</pre>
    </div>
</div>

<div class="code-template hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo TEMPLATE; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#TEMPLATE').val();</pre>
    </div>
</div>

<div class="code-language hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo LANGUAGE; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#LANGUAGE').val();</pre>
    </div>
</div>

<div class="code-email-from hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo EMAIL_FROM; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#EMAIL_FROM').val();</pre>
    </div>
</div>

<div class="code-url-root hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_ROOT; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_ROOT').val();</pre>
    </div>
</div>

<div class="code-url-upload hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_UPLOAD; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_UPLOAD').val();</pre>
    </div>
</div>

<div class="code-url-template hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_TEMPLATE; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_TEMPLATE').val();</pre>
    </div>
</div>

<div class="code-url-include hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_INCLUDE; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_INCLUDE').val();</pre>
    </div>
</div>

<div class="code-url-css hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_CSS; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_CSS').val();</pre>
    </div>
</div>

<div class="code-url-js hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_JS; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_JS').val();</pre>
    </div>
</div>

<div class="code-url-img hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo URL_IMG; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#URL_IMG').val();</pre>
    </div>
</div>

<div class="code-path-temp hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_TEMP; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_TEMP').val();</pre>
    </div>
</div>

<div class="code-path-upload hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_UPLOAD; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_UPLOAD').val();</pre>
    </div>
</div>

<div class="code-path-include hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_INCLUDE; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_INCLUDE').val();</pre>
    </div>
</div>

<div class="code-path-css hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_CSS; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_CSS').val();</pre>
    </div>
</div>

<div class="code-path-js hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_JS; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_JS').val();</pre>
    </div>
</div>

<div class="code-path-img hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_IMG; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_IMG').val();</pre>
    </div>
</div>

<div class="code-path-html-components hide">
    <div>
        <small><strong>PHP (<?php echo lang('as a constant') ?>)</strong></small>
        <pre>&lt;?php echo PATH_HTML_COMPONENTS; ?&gt;</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong>JQuery</strong></small>
        <pre>$('#PATH_HTML_COMPONENTS').val();</pre>
    </div>
</div>

<div class="code-session-user-group hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('user_group'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-id-user hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('id_user'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-user-name hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('user_name'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-email hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('email'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-user-img hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('user_img'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-language hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('language'); ?&gt;</pre>
    </div>
</div>

<div class="code-session-url-default hide">
    <div>
        <small><strong>PHP</strong></small>
        <pre>&lt;?php echo $this->session->userdata('url_default'); ?&gt;</pre>
    </div>
</div>

<style>

    .list-group-item { cursor: default; }
    .list-group-item-heading { margin-bottom: 5px }
    .list-group-item-text { word-break: break-all; }
    .list-group-item-text .text-muted { margin-top: 5px; word-break: break-all; }
    .list-group-item-heading .label { font-size: 100%; }
    .list-group-item h1 { font-size: 40px; margin: -2px 10px 17px -5px; }
    .panel-body > div { word-break: break-all; }

</style>

<script>

    // ========
    // Popovers
    // ========
    $('.list-group-item').popover( {
        trigger : 'hover',
        title :  '<?php echo lang('Example of use') ?>:',
        container: 'body',
        html: true,
        content: function () {
            var cls = $(this).attr('class').replace('list-group-item ', '');
            return $('.code-' + cls).html();
        }
    });

    // =============
    // Module search
    // =============
    $("#search-module").keyup( function() {

        var exist = false;

        if($("#search-module").val().length > 2) {

            $('.list-group-item').each( function() {
                $(this).hide();
            });

            var search = $("#search-module").val().toLowerCase();

            $('.list-group-item-heading, .list-group-item-text > div:first-child, .list-group-item .label').each( function(index) {

                var text = $(this).html().toLowerCase();

                if(text.indexOf(search) != -1) {
                    exist = true;
                    $(this).closest('.list-group-item').show();
                }
            });

            if(exist == false)
                return;

        } else if($("#search-module").val().length <= 2 || $("#search-module").val().length == '') {
            $('.list-group-item').each(function(index) {
                $(this).show();
            });
        }
    });

</script>