<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h1>
                <?php echo lang('Groups') ?>
                <span><?php echo image($this->url_img) ?></span>
                <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
            </h1>
        </div>
        
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            
            <div class="btn-group pull-right clearfix">
                
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

    <div class="row" style="margin-bottom: 15px">

        <div class="col-sm-6 col-lg-5">

            <div class="input-group" style="margin-bottom: 15px">
                <input type="text" id="search-groups" class="form-control input-md" placeholder="<?php echo lang('Search groups') ?>" autofocus>
                <span class="input-group-addon input-sm"><i class="fa fa-search fa-fw"></i></span>
            </div>

        </div>

        <div class="col-sm-6 col-lg-7">

            <button class="btn btn-md btn-success pull-right" style="margin: 0 0 20px 0" data-toggle="modal" data-target="#modal-new-group"><?php echo lang('New group') ?> <i class="fa fa-plus-circle"></i></button>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-bordered">
            
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

                    <td>
                        <a data-toggle="modal" data-target="#modal-<?php echo get_value($group, 'id_user_group') ?>" href="#" class="label label-info group-name" data-placement="right" data-original-title="<?php echo lang('Click to edit') ?>"><?php echo get_value($group, 'name')?></a>
                    </td>
                    <td class="group-description"><?php echo get_value($group, 'description') ?></td>
                    <td class="text-right" style="width: 01%"><a href="javascript:void(0)" id="<?php echo get_value($group, 'id_user_group') ?>"><i class="fa fa-times fa-fw" data-placement="left" data-original-title="<?php echo lang('Remove') ?>"></i></a></td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<!-- now, modal groups -->
<?php 
foreach($groups as $group) { 
$id_group = get_value($group, 'id_user_group');
?>
<form action="<?php echo URL_ROOT ?>/app_user/save_group/update" id="<?php echo $id_group ?>" method="post">
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

<!-- modal to new group -->
<form action="<?php echo URL_ROOT ?>/app_user/save_group/insert" method="post" id="new-group">
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
                    <input type="submit" class="btn btn-primary" value="<?php echo lang('Save') ?>" />
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<style>
    .label { font-size: 100%; }
</style>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>
    // ========
    // tooltips
    // ========
    $('a.group-name, i').tooltip();

    // =================
    // input de pesquisa
    // =================
    $("#search-groups").keyup( function() {
        
        var exist = false;
        
        if($("#search-groups").val().length > 2) {
            
            $('.group').each( function() {
                $(this).hide();                             
            });
            
            var search = $("#search-groups").val().toLowerCase();       
            
            $('.group-name, .group-description').each( function(index) {
            
                var text = $(this).html().toLowerCase();
                
                if(text.indexOf(search) != -1) {
                    exist = true;
                    $(this).closest('.group').show();
                }
            });
            
            if(exist == false)
                return;
        
        } else if($("#search-groups").val().length <= 2 || $("#search-groups").val().length == '') {
            $('.group').each(function(index) { 
                $(this).show();
            });
        }
    });

    // ======================
    // cancel original submit
    // ======================
    $('form').submit(function () {
        return false;
    });

    // =======================
    // insert, update callback
    // =======================
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

                // close modal
                form.find('.modal-footer button').click();

                // Trigger event to close modal (load page again)
                form.find('.modal').on('hidden.bs.modal', function () {

                    // reload page
                    window.location.reload();

                });
            }
        });

        // Prevent submit
        return false;
    };

    // ===============
    // remove callback
    // ===============
    $('td.text-right a').click( function () {

        // get id
        var id = $(this).attr('id');
        
        // Confirm this shit
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected group ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // ajax to remove this fucking shit
            $.enable_loading();
            
            $.ajax({
                url: $('#URL_ROOT').val() + '/app_user/save_group/delete',
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
                        // close modal and alert
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

    // Reposition the alerts from form
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });
</script>