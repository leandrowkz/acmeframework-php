
<h4 style="margin-top: 20px"><?php echo lang('Formulário de inserção') ?></h4>

<div style="margin: 20px 0">

    <div class="inline" style="width: 150px"><label><?php echo lang('Situação') ?></label></div>
    <div class="inline">
        <?php if( get_value($form, 'dtt_inative') == '' && count($form) > 0) { ?>
        <span class="text-success"><?php echo lang('Habilitado')?></span>
        <button class="btn btn-danger btn-xs"><?php echo lang('Desabilitar') ?></button>
        <?php } else { ?>
        <span class="text-danger"><?php echo lang('Desabilitado')?></span>
        <button class="btn btn-success btn-xs"><?php echo lang('Habilitar') ?></button>
        <?php } ?>
    </div>

</div>

<div style="margin: 20px 0">

    <div class="inline" style="width: 150px">
        <label><?php echo lang('Menu vinculado') ?> </label>
        <i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Menu do módulo que aponta para este formulário') ?>"></i>
    </div>
    <div class="inline">
        <?php if( count($menu) > 0) { ?>
        <span class="text-success"><?php echo lang('Habilitado')?> </span>
        <button class="btn btn-danger btn-xs"><?php echo lang('Desabilitar') ?></button>
        <?php } else { ?>
        <span class="text-danger"><?php echo lang('Desabilitado')?> </span>
        <button class="btn btn-success btn-xs"><?php echo lang('Habilitar') ?></button>
        <?php } ?>
    </div>

</div>

<div style="margin: 20px 0">

    <div class="inline" style="width: 150px"><label><?php echo lang('URL do form') ?></label></div>
    <div class="inline">
        <span>{URL_ROOT}/<?php echo get_value($module, 'controller') ?>/form/insert </span>
        <button class="btn btn-primary btn-xs"><?php echo lang('Dados do form') ?></button>
    </div>

</div>

<h4 style="margin-top: 40px"><?php echo lang('Campos do formulário') ?></h4>

<div class="table-responsive">
    
    <table class="table">
        
        <thead>
            <tr>
                <th><?php echo lang('Tabela.coluna') ?></th>
                <th><?php echo lang('Label') ?></th>
                <th><?php echo lang('Tipo') ?></th>
                <th><?php echo lang('Ordenação') ?></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
           	
           	<?php 
            foreach($fields as $field) { 
                $id_field = get_value($field, 'id_field');
                $dtt_inative = get_value($field, 'dtt_inative');
           	?>
          	<tr>
                <td>
                    <?php echo get_value($field, 'column_name')?>
                    <?php if(get_value($field, 'column_key') == 'PRI') { ?>
                    <i class="fa fa-exclamation-triangle fa-fw text-warning"></i>
                    <?php } ?>
                </td>
                <td><?php echo get_value($field, 'label')?></td>
                <td><?php echo get_value($field, 'type')?></td>
                <td style="width: 01%"><?php echo get_value($field, 'order_') ?></td>
                <td style="width: 01%"><input type="checkbox" class="field" id="<?php echo $id_field ?>" <?php echo ($dtt_inative == '' && $id_field != '') ? 'checked="checked"' : ''; ?> /></td>
            </tr>
            <?php } ?>

	    </tbody>

	</table>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>
	
	// tooltips
    $('div, table').tooltip( { selector: "[data-toggle=tooltip]", container: "body" } );

    // cancel original submit
    $('form').submit(function () {
        return false;
    });

    // submit callback (update or insert)
    var submit_callback = function (form, status) {
    	
    	// Validation is not right
    	if( ! status)
    		return false;

        // get id
        var id = form.attr('id');

		// ajax to save this fucking shit
		enable_loading();
    	
    	$.ajax({
            url: form.attr('action'),
            context: document.body,
            data : {
                'permission' : form.find('input.permission').val(),
                'label' : form.find('input.lbl').val(),
                'id_module' : form.find('input.id_module').val(),
                'description' : form.find('input.description').val()
            },
            cache: false,
            async: false,
            type: 'POST',

            complete : function (response) {
                
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
                $('#modal-' + id).on('hidden.bs.modal', function () {

                    // reload area, this function comes from config.php
                    $.load_area('permissions');

                });
            }
        });

        disable_loading();

        // Prevent submit
    	return false;
    };

    // remove callback
    $('td.text-right a').click( function () {

        // get id
        var id = $(this).attr('id');
        
        // Confirm this shit
        bootbox.confirm("<?php echo lang('Deseja realmente remover a permissão selecionada ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // ajax to remove this fucking shit
            enable_loading();
            
            $.ajax({
                url: $('#URL_ROOT').val() + '/app_module_manager/save_permission/' + id + '/remove',
                context: document.body,
                cache: false,
                async: false,
                type: 'POST',

                complete : function (response) {
                    
                    // Parse json to check errors
                    json = $.parseJSON(response.responseText);
                    
                    // Check return
                    if( ! json.return) { 
                        // close modal and alert
                        form.find('.modal-footer button').click();
                        bootbox.alert(json.error);
                        return false;
                    }

                    // Reload area 
                    // this function comes from config.php
                    $.load_area('permissions');
                }
            });

            disable_loading();
            
        });

    });

    // Set validations to all forms
    $('form').validationEngine('attach', {
        
        promptPosition : "bottomRight",
        scroll: false,
        onValidationComplete: function (form, status) { submit_callback(form, status); }

    });

</script>