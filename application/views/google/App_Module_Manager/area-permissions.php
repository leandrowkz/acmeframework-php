
<button class="btn btn-sm btn-success" style="margin: 30px 0 0" data-toggle="modal" data-target="#modal-new-permission"><?php echo lang('New permission') ?> <i class="fa fa-plus-circle"></i></button>

<?php if( count($permissions) > 0 ) { ?>

<div class="table-responsive">

    <table class="table table-bordered" id="table-permissions">

        <thead>
            <tr>
                <th><?php echo lang('Permission') ?></th>
                <th><?php echo lang('Description') ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>

           	<?php
           	foreach($permissions as $permission) :
           	$id_permission = get_value($permission, 'id_module_permission');
           	?>
          	<tr id="tr-<?php echo $id_permission ?>">
                <td>
                	<a href="javascript:void(0)" class="text-bold" data-toggle="modal" data-target="#modal-<?php echo $id_permission ?>"><?php echo get_value($permission, 'permission')?></a>
                	<?php if(get_value($permission, 'description') != '') { ?>
                	<i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_value($permission, 'description') ?>"></i>
                	<?php } ?>
               	</td>
                <td class="lbl"><?php echo get_value($permission, 'label')?></td>
                <td class="text-right" style="width: 01%">
                    <a href="javascript:void(0)" id="<?php echo $id_permission ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Remove')?>"><i class="fa fa-trash fa-fw"></i></a>
                </td>
            </tr>

            <?php endforeach; ?>

	    </tbody>

	</table>

</div>
<?php } else { ?>
<div class="well" style="margin-top: 30px;"><span class="text-muted text-italic"><?php echo lang('There is no permissions for this module') ?></span></div>
<?php } ?>

<!-- Modal permissions -->
<?php
foreach($permissions as $permission) {
$id_permission = get_value($permission, 'id_module_permission');
?>
<form action="<?php echo URL_ROOT ?>/app-module-manager/save-permission/update" id="<?php echo $id_permission ?>" method="post">
	<div class="modal fade" id="modal-<?php echo $id_permission ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit permission')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />
                    <input type="hidden" class="id_module_permission" value="<?php echo $id_permission ?>" />

                	<div class="form-group">
                		<label><?php echo lang('Permission') ?>*</label>
                		<input type="text" class="form-control validate[required] permission" value="<?php echo get_value($permission, 'permission') ?>" />
                	</div>

                	<div class="form-group">
                		<label><?php echo lang('Description') ?>*</label>
                		<input type="text" class="form-control validate[required] lbl" value="<?php echo get_value($permission, 'label') ?>" />
                	</div>

                    <div class="form-group">
                        <label><?php echo lang('Observations') ?></label>
                        <input type="text" class="form-control description" value="<?php echo get_value($permission, 'description') ?>" />
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

<!-- Modal to new permission -->
<form action="<?php echo URL_ROOT ?>/app-module-manager/save-permission/insert" method="post" id="new-permission">
    <div class="modal fade" id="modal-new-permission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('New permission')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Permission') ?>*</label>
                        <input type="text" class="form-control validate[required] permission" value="" />
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Description') ?>*</label>
                        <input type="text" class="form-control validate[required] lbl" value="" />
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Observations') ?></label>
                        <input type="text" class="form-control description" value="" />
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

<script>

	// ========
    // Tooltips
    // ========
    $('table').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // ==========
    // DataTables
    // ==========
    $('#table-permissions').dataTable({
        info : false,
        paging: false,
        searching : false,
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
                'id_module_permission' : form.find('.id_module_permission').val(),
                'id_module' : form.find('.id_module').val(),
                'permission' : form.find('.permission').val(),
                'label' : form.find('.lbl').val(),
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

                // Trigger event to close modal (load area again)
                form.find('.modal').on('hidden.bs.modal', function () {

                    // Reload area, this function comes from config.php
                    $.load_area('permissions');

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

        // Confirm this shit
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected module permission?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-module-manager/save-permission/delete',
                context: document.body,
                data : { 'id_module_permission' : id },
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

                    // Reload area
                    $.load_area('permissions');
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

</script>