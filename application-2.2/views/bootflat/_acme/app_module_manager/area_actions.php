
<button class="btn btn-sm btn-success" data-toggle="modal" style="margin: 20px 0" data-target="#modal-new-action"><?php echo lang('New action') ?> <i class="fa fa-plus-circle"></i></button>

<?php if( count($actions) > 0 ) { ?>
<div class="table-responsive" style="margin-top: -10px">
    
    <table class="table table-bordered">
        
        <thead>
            <tr>
                <th><?php echo lang('Action') ?></th>
                <th><?php echo lang('Link') ?></th>
                <th><?php echo lang('Order') ?></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            
            <?php 
            foreach($actions as $action) { 
            $id_action = get_value($action, 'id_module_action');
            ?>
            <tr id="tr-<?php echo $id_action ?>">
                <td><a data-toggle="modal" data-target="#modal-<?php echo $id_action ?>" href="#"><?php echo get_value($action, 'label')?></a></td>
                <td class="link"><?php echo get_value($action, 'link')?></td>
                <td style="width: 01%"><?php echo get_value($action, 'order_')?></td>
                <td class="text-right" style="width: 01%" title="<?php echo lang('Remove')?>"><a href="javascript:void(0)" id="<?php echo $id_action ?>"><i class="fa fa-times fa-fw"></i></a></td>
            </tr>
            <?php } ?>

        </tbody>

    </table>

</div>
<?php } else { ?>
<p class="text-muted"><em><?php echo lang('There is no actions for this module') ?></em></p>
<?php } ?>
    
<!-- now, modal actions -->
<?php 
foreach($actions as $action) { 
$id_action = get_value($action, 'id_module_action');
?>
<form action="<?php echo URL_ROOT ?>/app_module_manager/save_action/update" method="post">
    <div class="modal fade" id="modal-<?php echo $id_action ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit action')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />
                    <input type="hidden" class="id_module_action" value="<?php echo $id_action ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Action name') ?>*</label>
                        <input type="text" class="form-control validate[required] lbl" value="<?php echo get_value($action, 'label') ?>" />
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Link') ?>* </label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('If the action will be used inside a loop structure, then use {NUMBER OR COLUMN_NAME} to replace for the column value on each row')?>"></i>
                                <input type="text" class="form-control validate[required] link" value="<?php echo get_value($action, 'link') ?>" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Target') ?></label>
                                <input type="text" class="form-control target" value="<?php echo get_value($action, 'target') ?>" />
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Image URL') ?></label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('Use {URL_IMG} for example, to save the PHP URL_IMG constant value')?>"></i>
                                <input type="text" class="form-control url_img" value="<?php echo get_value($action, 'url_img') ?>" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Order') ?></label>
                                <input type="text" class="form-control order_" alt="integer" value="<?php echo get_value($action, 'order_') ?>" />
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close') ?></button>
                    <input type="submit" class="btn btn-primary" value="<?php echo lang('Save') ?>" />
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<?php } ?>

<!-- modal to new action -->
<form action="<?php echo URL_ROOT ?>/app_module_manager/save_action/insert" method="post" id="new-action">
    <div class="modal fade" id="modal-new-action" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('New action')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module" value="<?php echo $id_module ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Action name') ?>*</label>
                        <input type="text" class="form-control validate[required] lbl" value="" />
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            
                            <div class="form-group">
                                <label><?php echo lang('Link') ?>*</label>
                                <i class="cursor-pointer fa fa-question-circle fa-fw" data-toggle="popover" data-placement="right" data-content="<?php echo lang ('If the action will be used inside a loop structure, then use {NUMBER OR COLUMN_NAME} to replace for the column value on each row')?>"></i>
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
                    <input type="submit" class="btn btn-primary" value="<?php echo lang('Save') ?>" />
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/meiomask/meiomask.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>
    
    // =====
    // masks
    // =====
    $('input[type=text]').setMask();

    // ========
    // tooltips
    // ========
    $('table').tooltip({
        selector: "[data-toggle=tooltip]"
    });

    // ========
    // popovers
    // ========
    $('.modal').popover({
        selector: "[data-toggle=popover]"
    });

    // ============================
    // insert, edit action callback
    // ============================
    $.submit_callback = function (form, status) {
        
        // Validation is not right
        if( ! status)
            return false;

        // get id
        var id = form.attr('id');

        // ajax to save this fucking shit
        $.enable_loading();
        
        $.ajax({
            url: form.attr('action'),
            context: document.body,
            data : {
                'id_module_action' : form.find('.id_module_action').val(),
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
                    // close modal and alert
                    form.find('.modal-footer button').click();
                    bootbox.alert(json.error);
                    return false;
                }

                // close modal
                form.find('.modal-footer button').click();

                // Trigger event to close modal (load area again)
                form.find('.modal').on('hidden.bs.modal', function () {

                    // reload area, this function comes from config.php
                    $.load_area('actions');

                });
            }
        });

        // Prevent submit
        return false;
    };

    // ======================
    // remove action callback
    // ======================
    $('td.text-right a').click( function () {

        // get id
        var id = $(this).attr('id');
        
        // Confirm this shit
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected action ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // ajax to remove this fucking shit
            $.enable_loading();
            
            $.ajax({
                url: $('#URL_ROOT').val() + '/app_module_manager/save_action/delete',
                context: document.body,
                data: { 'id_module_action' : id },
                cache: false,
                type: 'POST',

                complete : function (response) {
                    
                    // Parse json to check errors
                    json = $.parseJSON(response.responseText);
                    
                    // Check return
                    if( ! json.return) { 
                        // close modal and alert
                        bootbox.alert(json.error);
                        return false;
                    }

                    // Reload area 
                    // this function comes from config.php
                    $.load_area('actions');

                    $.disable_loading();
                }
            });
            
        });

    });
    
    // ======================
    // cancel original submit
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