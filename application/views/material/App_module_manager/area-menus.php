
<button class="btn btn-sm btn-success" data-toggle="modal" style="margin: 30px 0 0" data-target="#modal-new-menu"><?php echo lang('New menu') ?> <i class="fa fa-plus-circle"></i></button>

<?php if( count($menus) > 0 ) { ?>

<div class="table-responsive">

    <table class="table table-bordered" id="table-menus">

        <thead>
            <tr>
                <th><?php echo lang('Menu') ?></th>
                <th><?php echo lang('Link') ?></th>
                <th><?php echo lang('Order') ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>

           	<?php
           	foreach($menus as $menu) :
           	$id_menu = get_value($menu, 'id_module_menu');
           	?>
          	<tr id="tr-<?php echo $id_menu ?>">
                <td><a href="javascript:void(0)" class="text-bold" data-toggle="modal" data-target="#modal-<?php echo $id_menu ?>"><?php echo get_value($menu, 'label')?></a></td>
                <td class="link"><?php echo get_value($menu, 'link')?></td>
                <td style="width: 01%"><?php echo get_value($menu, 'order_')?></td>
                <td class="text-right" style="width: 01%">
                    <a href="javascript:void(0)" id="<?php echo $id_menu ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo lang('Remove')?>"><i class="fa fa-trash fa-fw"></i></a>
                </td>
            </tr>

            <?php endforeach; ?>

	    </tbody>

	</table>

</div>
<?php } else { ?>
<div class="well" style="margin-top: 30px;"><span class="text-muted text-italic"><?php echo lang('There is no menus for this module') ?></span></div>
<?php } ?>

<!-- Now, modal menus -->
<?php
foreach($menus as $menu) {
$id_menu = get_value($menu, 'id_module_menu');
?>
<form menu="<?php echo URL_ROOT ?>/app-module-manager/save-menu/update" method="post">
	<div class="modal fade" id="modal-<?php echo $id_menu ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit menu')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />
                    <input type="hidden" class="id_module_menu" value="<?php echo $id_menu ?>" />

                	<div class="form-group">
                		<label><?php echo lang('Label') ?>*</label>
                		<input type="text" class="form-control validate[required] lbl" value="<?php echo get_value($menu, 'label') ?>" />
                	</div>

                    <div class="row">
                        <div class="col-sm-8">

                        	<div class="form-group">
                        		<label><?php echo lang('Link') ?>* </label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('Use {URL_ROOT} for example, to save the PHP URL_ROOT constant value')?>"></i>
                                <input type="text" class="form-control validate[required] link" value="<?php echo get_value($menu, 'link') ?>" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Target') ?></label>
                                <input type="text" class="form-control target" value="<?php echo get_value($menu, 'target') ?>" />
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Image URL') ?></label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('Use {URL_IMG} for example, to save the PHP URL_IMG constant value')?>"></i>
                                <input type="text" class="form-control url_img" value="<?php echo get_value($menu, 'url_img') ?>" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Order') ?></label>
                                <input type="text" class="form-control order_" alt="integer" value="<?php echo get_value($menu, 'order_') ?>" />
                            </div>

                        </div>
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

<!-- Modal to new menu -->
<form menu="<?php echo URL_ROOT ?>/app-module-manager/save-menu/insert" method="post" id="new-menu">
    <div class="modal fade" id="modal-new-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('New menu')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Label') ?>*</label>
                        <input type="text" class="form-control validate[required] lbl" value="" />
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Link') ?>*</label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('Use {URL_ROOT} for example, to save the PHP URL_ROOT constant value')?>"></i>
                                <input type="text" class="form-control validate[required] link" value="" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Target') ?></label>
                                <input type="text" class="form-control target" value="" />
                            </div>

                        </div>
                    </div>

                     <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Image URL') ?></label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('Use {URL_IMG} for example, to save the PHP URL_IMG constant value')?>"></i>
                                <input type="text" class="form-control url_img" value="" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Order') ?></label>
                                <input type="text" class="form-control order_" alt="integer" value="" />
                            </div>

                        </div>
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
    // Meiomask
    // ========
    $('input[type=text]').setMask();

	// ========
    // Tooltips
    // ========
    $('table').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // ========
    // Popovers
    // ========
    $('.modal').popover({
        selector: "[data-toggle=popover]"
    });

    // ==========
    // DataTables
    // ==========
    $('#table-menus').dataTable({
        info : false,
        paging: false,
        searching : false,
        order: [[ 0, "asc" ]],
        columnDefs: [ { "orderable": false, "targets": [3] } ]
    });

    // ==========================
    // Insert, edit menu callback
    // ==========================
    $.submit_callback = function (form, status) {

    	// Validation is not right
    	if( ! status)
    		return false;

        // Get id
        var id = form.attr('id');

		// Ajax to save this fucking shit
		$.enable_loading();

    	$.ajax({
            url: form.attr('menu'),
            context: document.body,
            data : {
                'id_module_menu' : form.find('.id_module_menu').val(),
                'id_module' : form.find('.id_module').val(),
                'label' : form.find('.lbl').val(),
                'link' : form.find('.link').val(),
                'target' : form.find('.target').val(),
                'url_img' : form.find('.url_img').val(),
                'order_' : form.find('.order_').val()
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
            		form.find('.modal-footer button').click();
            		bootbox.alert(json.error);
            		return false;
            	}

	            // Close modal
	            form.find('.modal-footer button').click();

                // Trigger event to close modal (load area again)
                form.find('.modal').on('hidden.bs.modal', function () {

                    // Reload area, this function comes from config.php
                    $.load_area('menus');

                });
            }
        });

        // Prevent submit
    	return false;
    };

    // ====================
    // Remove menu callback
    // ====================
    $('td.text-right a').click( function () {

        // Get id
        var id = $(this).attr('id');

        // Confirm
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected module menu ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-module-manager/save-menu/delete',
                context: document.body,
                data: { 'id_module_menu' : id },
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

                    // Reload area
                    // This function comes from config.php
                    $.load_area('menus');
                }
            });

        });

    });

    // ======================
    // Cancel original submit
    // ======================
    $('form').submit(function () {
        return false;
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