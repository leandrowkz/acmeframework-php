<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10">
            <h1>
                <?php echo lang($this->label) ?>

                <span><?php echo image($this->url_img) ?></span>

                <?php if( count ($logs) >= 1000 ) { ?>
                <i class="fa fa-fw fa-exclamation-circle text-danger" data-placement="right" data-original-title="<?php echo lang('For security reasons you are seeing only 1000 records.')?>"></i>
                <?php } ?>

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

                    <li><a href="<?php echo URL_ROOT ?>/app-log"><i class="fa fa-fw fa-refresh"></i> <?php echo lang('Refresh')?></a></li>
                    <li><a href="javascript:void(0)" class="remove-all"><i class="fa fa-fw fa-warning"></i> <?php echo lang('Remove all errors')?></a></li>

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

        <table class="table table-bordered no-footer" id="table-logs">

            <thead>

                <tr class="row">

                    <th><?php echo lang('Description') ?></th>
                    <th><?php echo lang('Log type') ?></th>
                    <th><?php echo lang('By user') ?></th>
                    <th><?php echo lang('Date') ?></th>
                    <th></th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($logs as $log) : ?>

                <?php $label = get_value($log, 'log_type') == 'error' ? 'danger' : 'info'; ?>

                <tr class="row">

                    <td>
                        <strong>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-<?php echo get_value($log, 'log_type') ?>-<?php echo get_value($log, 'id_log') ?>">
                            <?php echo get_value($log, 'log_description') ?>
                        </a>
                        </strong>
                    </td>
                    <td><span class="label label-<?php echo $label?> log-type"><?php echo lang(ucwords(get_value($log, 'log_type')))?></span></td>
                    <td><?php echo get_value($log, 'email') ?></td>
                    <td><?php echo get_value($log, 'log_dtt_ins') ?></td>
                    <td class="text-right" style="width: 01%">
                        <a href="javascript:void(0)" class="remove-log" type="<?php echo get_value($log, 'log_type') ?>" id="<?php echo get_value($log, 'id_log') ?>"><i class="fa fa-trash fa-fw" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Remove') ?>"></i></a>
                        </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- now, modal logs -->
<?php foreach($logs as $log) : ?>
<div class="modal fade" id="modal-<?php echo get_value($log, 'log_type')?>-<?php echo get_value($log, 'id_log') ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <?php $label = get_value($log, 'log_type') == 'error' ? 'danger' : 'info'; ?>

            <?php
            switch(strtolower(get_value($log, 'action')))
            {
                case 'error_db':
                $type = 'DB error';
                break;

                case 'error_php':
                $type = 'PHP error';
                break;

                case 'error_general':
                $type = 'General error';
                break;

                default:
                $type = ucwords(get_value($log, 'action'));
                break;
            }
            ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo lang('Log details')?>
                </h4>
            </div>

            <div class="modal-body">

                <div class="form-group" style="margin-bottom: 10px">

                    <div class="label label-modal label-<?php echo $label ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Log type')?>"><?php echo lang(ucwords(get_value($log, 'log_type'))) ?></div>

                    <div class="label label-modal label-<?php echo $label ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang(ucwords(get_value($log, 'log_type'))) . ' ' . lang('type')?>"><?php echo lang($type) ?></div>

                    <div class="label label-modal label-primary" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('User that triggered this log')?>">
                        <i class="fa fa-fw fa-user"></i>
                        <?php echo get_value($log, 'email') ?>
                    </div>

                    <div class="label label-modal label-normal" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Log date')?>">
                        <i class="fa fa-fw fa-calendar"></i>
                        <?php echo get_value($log, 'log_dtt_ins') ?>
                    </div>

                    <div class="label label-modal label-normal" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo get_value($log, 'device_name') . ' ' . get_value($log, 'device_version') . ' ' . get_value($log, 'platform') ?>">
                        <i class="fa fa-fw fa-desktop"></i>
                    </div>

                </div>

                <div class="form-group">
                    <label><?php echo lang('Browser') ?></label>
                    <div>
                        <?php echo get_value($log, 'browser_name') ?> <?php echo get_value($log, 'browser_version') ?>
                        <?php echo lang('on IP')?>
                        <?php echo get_value($log, 'ip_address') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo lang('Message') ?></label>
                    <div><?php echo get_value($log, 'message') ?></div>
                </div>

                <div class="form-group">

                    <?php if($label == 'info' && get_value($log, 'table_name') != '') {?>
                    <div class="row">
                    <div class="col-sm-8">
                    <?php } ?>

                    <label><?php echo lang('Additional data') ?></label>
                    <div>
                        <?php
                        if( get_value($log, 'additional_data') != '') {
                            echo get_value($log, 'additional_data');
                        } else {
                        ?>
                        <span class="text-muted"><em><?php echo lang('There is no additional data') ?></em></span>
                        <?php } ?>
                    </div>

                    <?php if($label == 'info' && get_value($log, 'table_name') != '') {?>
                    </div>
                    <div class="col-sm-4">
                    <label><?php echo lang('Table') ?></label>
                    <div><?php echo get_value($log, 'table_name') ?></div>
                    </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label><?php echo lang('User agent') ?></label>
                    <div><?php echo get_value($log, 'user_agent') ?></div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close') ?></button>
            </div>

        </div>
        <!-- /.modal-content -->

    </div>
    <!-- /.modal-dialog -->

</div>
<?php endforeach; ?>

<!-- DataTables Plugin -->
<script src="<?php echo URL_JS ?>/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_JS ?>/dataTables/js/dataTables.bootstrap.js"></script>
<link href="<?php echo URL_JS ?>/dataTables/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />

<style>

    div.label-modal {
        font-size: 100%;
        cursor: default;
        display: inline-block;
        margin-bottom: 10px;
        padding: 7px;
    }

    .form-group div { word-break: break-all }

</style>

<script>
    // ========
    // Tooltips
    // ========
    $('body').tooltip({
        selector: '[data-toggle=tooltip]',
        container: 'body'
    });

    // ==========
    // DataTables
    // ==========
    $('#table-logs').dataTable({
        language: {
            search: '<span class="input-group-addon input-md"><i class="fa fa-search fa-fw" data-original-title="" title=""></i></span>',
            lengthMenu:     "_MENU_ &nbsp;<?php echo lang('Entries')?>",
            info:           "<small class=\"text-muted\"><?php echo lang('Showing') ?> _START_ <?php echo lang('to') ?> _END_ <?php echo lang('of') ?> _TOTAL_ <?php echo lang('entries') ?></small>",
            infoEmpty:      "<small class=\"text-muted\"><?php echo lang('Showing') ?> 0 entries</small>",
            infoFiltered:   "<small class=\"text-muted\">(<?php echo lang('filtered from') ?> _MAX_ <?php echo lang('total entries') ?>)",
        },
        order: [[ 0, "asc" ]],
        columnDefs: [ { "orderable": false, "targets": [4] } ]
    });

    // ===============
    // Remove callback
    // ===============
    $('#table-logs').on('click', '.remove-log', function () {

        // Get log id
        var id = $(this).attr('id');
        var type = $(this).attr('type');

        // Confirm
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected log ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this fucking shit
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-log/save/' + type + '/delete',
                context: document.body,
                data : { 'id_log' : id },
                cache: false,
                type: 'POST',

                complete : function (response) {

                    // Parse json to check errors
                    json = $.parseJSON(response.responseText);

                    // Check return
                    if( ! json.return) {

                        $.disable_loading();

                        // Close modal and alert
                        bootbox.alert(json.error);
                        return false;
                    }

                    // Reload page
                    window.location.reload();
                }
            });
        });
    });

    // ==============================
    // Remove all log errors callback
    // ==============================
    $('.remove-all').click( function () {

        // Get log type
        var type = 'error';

        // Confirm
        bootbox.confirm("<?php echo addslashes(str_replace("\n", '', message('warning', lang('Warning!'), lang('All error logs will be deleted. Are you sure to remove all error logs ?')))) ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this fucking shit
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-log/save/' + type + '/delete-all',
                context: document.body,
                cache: false,
                type: 'POST',

                complete : function (response) {

                    console.log(response.responseText);

                    // Parse json to check errors
                    json = $.parseJSON(response.responseText);

                    // Check return
                    if( ! json.return) {

                        $.disable_loading();

                        // Close modal and alert
                        bootbox.alert(json.error);
                        return false;
                    }

                    // Reload page
                    window.location.reload();
                }
            });
        });
    });

</script>