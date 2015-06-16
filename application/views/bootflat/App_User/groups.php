<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10">
            <h1>
                <?php echo lang('Groups') ?>
                <span><?php echo image($this->url_img) ?></span>
                <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
            </h1>
        </div>

        <div class="col-xs-2 col-sm-2">

            <div class="btn-group pull-right clearfix">

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

    <button class="btn btn-md btn-success btn-new" data-toggle="modal" data-target="#modal-new-group"><?php echo lang('New group') ?> <i class="fa fa-plus-circle"></i></button>

    <div class="table-responsive">

        <table class="table table-bordered" id="table-groups">

            <thead>
                <tr>
                    <th><?php echo lang('Group') ?></th>
                    <th><?php echo lang('Description') ?></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php foreach($groups as $group) { ?>

                <tr class="group">

                    <td><a href="javascript:void(0)" class="text-bold" data-toggle="modal" data-target="#modal-<?php echo get_value($group, 'id_user_group') ?>" data-placement="right" data-original-title="<?php echo lang('Click to edit') ?>"><?php echo get_value($group, 'name')?></a></td>
                    <td class="group-description"><?php echo get_value($group, 'description') ?></td>
                    <td class="text-right" style="width: 01%"><a href="javascript:void(0)" id="<?php echo get_value($group, 'id_user_group') ?>"><i class="fa fa-trash fa-fw" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Remove') ?>"></i></a></td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<!-- Modal groups -->
<?php
foreach($groups as $group) {
$id_group = get_value($group, 'id_user_group');
?>
<form action="<?php echo URL_ROOT ?>/app-user/save-group/update" id="<?php echo $id_group ?>" method="post">
    <div class="modal fade" id="modal-<?php echo $id_group ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit group')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_user_group" value="<?php echo $id_group ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Group') ?>*</label>
                        <input type="text" class="form-control validate[required] name" value="<?php echo get_value($group, 'name') ?>" />
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Description') ?>*</label>
                        <input type="text" class="form-control validate[required] description" value="<?php echo get_value($group, 'description') ?>" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close') ?></button>
                    <input type="submit" class="btn btn-success" value="<?php echo lang('Save') ?>" />
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<?php } ?>

<!-- Modal to new group -->
<form action="<?php echo URL_ROOT ?>/app-user/save-group/insert" method="post" id="new-group">
    <div class="modal fade" id="modal-new-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('New group')?></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label><?php echo lang('Group') ?>*</label>
                        <input type="text" class="form-control validate[required] name" value="" />
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Description') ?>*</label>
                        <input type="text" class="form-control validate[required] description" value="" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close') ?></button>
                    <input type="submit" class="btn btn-success" value="<?php echo lang('Save') ?>" />
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<!-- DataTables Plugin -->
<script src="<?php echo URL_JS ?>/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_JS ?>/dataTables/js/dataTables.bootstrap.js"></script>
<link href="<?php echo URL_JS ?>/dataTables/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />

<style>
    .module-body .btn-new { margin: 0 0 30px; }
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
    $('#table-groups').dataTable({
        language: {
            search: '<span class="input-group-addon input-md"><i class="fa fa-search fa-fw" data-original-title="" title=""></i></span>',
            lengthMenu:     "_MENU_ &nbsp;<?php echo lang('Entries')?>",
            info:           "<small class=\"text-muted\"><?php echo lang('Showing') ?> _START_ <?php echo lang('to') ?> _END_ <?php echo lang('of') ?> _TOTAL_ <?php echo lang('entries') ?></small>",
            infoEmpty:      "<small class=\"text-muted\"><?php echo lang('Showing') ?> 0 entries</small>",
            infoFiltered:   "<small class=\"text-muted\">(<?php echo lang('filtered from') ?> _MAX_ <?php echo lang('total entries') ?>)",
        },
        order: [[ 0, "asc" ]],
        columnDefs: [ { "orderable": false, "targets": [2] } ]
    });

    // ======================
    // Cancel original submit
    // ======================
    $('form').submit(function () {
        return false;
    });

    // =======================
    // Insert, update callback
    // =======================
    $.submit_callback = function (form, status) {

        // Validation is not right
        if( ! status)
            return false;

        // Get id
        var id = form.attr('id');

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: form.attr('action'),
            context: document.body,
            data : {
                'id_user_group' : form.find('.id_user_group').val(),
                'name' : form.find('.name').val(),
                'description' : form.find('.description').val()
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
                    form.find('.modal-footer button').click();
                    bootbox.alert(json.error);
                    return false;
                }

                // Close modal
                form.find('.modal-footer button').click();

                // Trigger event to close modal (load page again)
                form.find('.modal').on('hidden.bs.modal', function () {

                    // Reload page
                    window.location.reload();

                });
            }
        });

        // Prevent submit
        return false;
    };

    // ===============
    // Remove callback
    // ===============
    $('td.text-right a').click( function () {

        // Get id
        var id = $(this).attr('id');

        // Confirm
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected group ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-user/save-group/delete',
                context: document.body,
                data : { 'id_user_group' : id },
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

                    // Reload page
                    window.location.reload();
                }
            });
        });
    });

    // ============================
    // Set validations to all forms
    // ============================
    $('form').validationEngine('attach', {

        promptPosition : "bottomRight",
        scroll: false,
        onValidationComplete: function (form, status) { $.submit_callback(form, status); }
    });

    // ===============================
    // Reposition the alerts from form
    // ===============================
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });
</script>