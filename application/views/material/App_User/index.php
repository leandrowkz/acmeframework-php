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

                    <li><a href="<?php echo URL_ROOT ?>/app-user/new-user"><i class="fa fa-user-plus fa-fw"></i> <?php echo lang('New user')?></a></li>
                    <li><a href="<?php echo URL_ROOT ?>/app-user/groups"><i class="fa fa-group fa-fw"></i> <?php echo lang('User Groups')?></a></li>

                    <?php
                    foreach ($this->menus as $menu) :

                    // build link
                    $link = tag_replace(get_value($menu, 'link'));
                    $target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
                    $label = lang(get_value($menu, 'label'));
                    $img = image(get_value($menu, 'url_img'));

                    ?>
                    <li><a href="<?php echo $link ?>" <?php echo $target ?>><?php echo $img . ' ' . $label ?></a></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    </div>

</div>

<div class="module-body">

    <div class="table-responsive">

        <div class="dataTables_wrapper form-inline" role="grid">

            <table class="table table-bordered dataTable no-footer" id="table-users">

                <thead>

                    <tr class="row">

                        <th></th>
                        <th><?php echo lang('Name') ?></th>
                        <th><?php echo lang('Email') ?></th>
                        <th><?php echo lang('Group') ?></th>
                        <th><?php echo lang('Status') ?></th>
                        <th></th>
                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    foreach($users as $user) {

                    // User variables
                    $url_img = get_value($user, 'url_img');
                    $id_user = get_value($user, 'id_user');
                    $group = get_value($user, 'user_group');
                    $name = get_value($user, 'name');
                    $active = get_value($user, 'dtt_inative') != '' ? 'N' : 'Y';
                    $email = get_value($user, 'email');

                    // Adjust thumb
                    if(basename($url_img) != '' && file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img)))
                        $url_img = tag_replace($url_img);
                    else
                        $url_img = URL_IMG . '/user-unknown.png';
                    ?>
                    <tr class="row">

                        <td style="width: 01%">
                            <img class="img-circular" style="max-width: 35px; max-height: 35px" src="<?php echo $url_img ?>" />
                        </td>
                        <td>
                            <a href="<?php echo URL_ROOT ?>/app-user/edit/<?php echo $id_user ?>" class="text-bold">
                                <?php echo $name ?>
                            </a>
                        </td>
                        <td><i class="fa fa-fw fa-envelope-o"></i> <?php echo $email ?></td>
                        <td><div class="label label-info cursor-default user-group"><?php echo $group ?></div></td>
                        <td>
                            <?php if($active == 'Y'){ ?>
                            <div class="label label-success"><i class="fa fa-check-circle fa-fw"></i> <?php echo lang('Active') ?></div>
                            <?php } else { ?>
                            <div class="label label-danger"><i class="fa fa-minus-circle fa-fw"></i> <?php echo lang('Inactive') ?></div>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="width: 01%">
                            <a href="<?php echo URL_ROOT ?>/app-user/permissions/<?php echo $id_user ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Permissions') ?>">
                                <i class="fa fa-fw fa-shield"></i>
                            </a>
                        </td>
                        <td class="text-center" style="width: 01%">
                            <a href="javascript:void(0)" class="reset-pass" id="<?php echo $id_user ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Reset password') ?>">
                                <i class="fa fa-fw fa-unlock-alt"></i>
                            </a>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- DataTables Plugin -->
<script src="<?php echo URL_JS ?>/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_JS ?>/dataTables/js/dataTables.bootstrap.js"></script>
<link href="<?php echo URL_JS ?>/dataTables/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />

<style>

    #table-users td { padding-top: 17px !important; }
    #table-users td:first-child img {

        border: 2px solid #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        margin-top: -5px !important;
        width: 30px;
        border-radius: 100%;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
    }

</style>

<script>

    // ========
    // Tooltips
    // ========
    $('body').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // ==========
    // DataTables
    // ==========
    $('#table-users').dataTable({
        language: {
            search: '<span class="input-group-addon input-md"><i class="fa fa-search fa-fw" data-original-title="" title=""></i></span>',
            lengthMenu:     "_MENU_ &nbsp;<?php echo lang('Entries')?>",
            info:           "<small class=\"text-muted\"><?php echo lang('Showing') ?> _START_ <?php echo lang('to') ?> _END_ <?php echo lang('of') ?> _TOTAL_ <?php echo lang('entries') ?></small>",
            infoEmpty:      "<small class=\"text-muted\"><?php echo lang('Showing') ?> 0 entries</small>",
            infoFiltered:   "<small class=\"text-muted\">(<?php echo lang('filtered from') ?> _MAX_ <?php echo lang('total entries') ?>)",
        },
        order: [[ 1, "asc" ]],
        columnDefs: [ { "orderable": false, "targets": [0, 5, 6] } ]
    });

    // =======================
    // Reset password callback
    // =======================
    $('#table-users').on('click', '.reset-pass', function () {

        // Get user id
        var id = $(this).attr('id');

        // Confirm
        bootbox.confirm("<?php echo lang('An email message containing all steps to reset password will be forwarded for the selected user. Are you sure to procced ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to call a reset password
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-user/reset-password/' + id,
                context: document.body,
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

                    // Alert ok
                    bootbox.alert("<?php echo lang('Ok! The email message was forwarded to the selected user.') ?>");
                }
            });
        });
    });

</script>