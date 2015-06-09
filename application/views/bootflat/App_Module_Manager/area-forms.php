
<div style="margin: 30px 0 0 2px">

    <h4 style="margin-left: 1px"><?php echo lang('Form') ?> <?php echo lang(strtoupper($operation)) ?></h4>

    <?php if (get_value($module, 'table_name') != '') : ?>

    <div class="well">

        <div style="margin: 0 0 20px">

            <div class="inline" style="width: 150px"><label><?php echo lang('Status') ?></label></div>

            <div class="inline activate-form">

                <?php
                if (get_value($form, 'dtt_inative') == '') :
                    $checked = 'checked="checked"';
                    $status = 'ON';
                else :
                    $checked = '';
                    $status = 'OFF';
                endif;
                ?>

                <span style="width: 35px" class="inline"><strong><?php echo $status ?></strong></span>

                <label class="toggle inline">
                    <input type="checkbox" class="enable-form" <?php echo $checked ?> />
                    <span class="handle"></span>
                </label>

            </div>

        </div>

        <div style="margin: 0 0 20px">

            <div class="inline" style="width: 150px">
                <label><?php echo lang('Linked ' . $pointer_label) ?> </label>
                <i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Linked ' . $pointer_label . ' on module list that points to this form') ?>"></i>
            </div>

            <div class="inline activate-pointer">

                <?php
                if (count($pointer) > 0) :
                    $checked = 'checked="checked"';
                    $status = 'ON';
                else :
                    $checked = '';
                    $status = 'OFF';
                endif;
                ?>

                <span style="width: 35px" class="inline"><strong><?php echo $status ?></strong></span>

                <label class="toggle inline">
                    <input type="checkbox" class="enable-pointer" data-pointer-label="<?php echo $pointer_label ?>" <?php echo $checked ?> />
                    <span class="handle"></span>
                </label>

            </div>

        </div>

        <div style="margin: 0">

            <div class="inline" style="width: 150px"><label><?php echo lang('Form URL') ?></label></div>

            <div class="inline">

                <span>{URL_ROOT}/<?php echo str_replace('_', '-', strtolower( get_value($module, 'controller' ))) ?>/form/<?php echo $operation ?> </span>

                &nbsp;

                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-edit-form-<?php echo $operation ?>">
                    <?php echo lang('Edit form') ?>
                    <i class="fa fa-fw fa-edit"></i>
                </button>

            </div>

        </div>

        <!-- Module data modal form -->
        <form class="edit-form">

            <div class="modal fade" id="modal-edit-form-<?php echo $operation ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit form')?></h4>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" class="id_module_form" value="<?php echo get_value($form, 'id_module_form') ?>" />

                            <div class="form-group">
                                <label><?php echo lang('Action') ?></label>
                                <input type="text" class="form-control action" value="<?php echo get_value($form, 'action') ?>" />
                            </div>

                            <div class="form-group">
                                <label><?php echo lang('Method') ?></label>
                                <input type="text" class="form-control method" value="<?php echo get_value($form, 'method') ?>" />
                            </div>

                            <div class="form-group">
                                <label><?php echo lang('Enctype') ?></label>
                                <input type="text" class="form-control enctype" value="<?php echo get_value($form, 'enctype') ?>" />
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

    </div>

</div>

<h4 style="margin: 30px 0 15px 2px"><?php echo lang('Form fields') ?></h4>

<div class="table-responsive">

    <table class="table table-bordered" id="table-fields-<?php echo $operation ?>">

        <thead>
            <tr>
                <th><?php echo lang('Table.column') ?></th>
                <th><?php echo lang('Label') ?></th>
                <th><?php echo lang('Type') ?></th>
                <th><?php echo lang('Order') ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;

            foreach ($fields as $field) :

            $id_field = get_value($field, 'id_module_form_field');
            $dtt_inative = get_value($field, 'dtt_inative');

            ?>
            <tr id="tr-<?php echo $i ?>">
                <td>
                    <input type="hidden" class="column_name" value="<?php echo get_value($field, 'column_name') ?>" />
                    <?php if($id_field != '') {?>
                    <a href="javascript:void(0)" class="text-bold" title="<?php echo lang('Edit') ?>" data-toggle="modal" data-target="#modal-edit-field-<?php echo $operation . '-' . $i ?>"><?php echo get_value($field, 'column_name') ?></a>
                    <?php } else { echo get_value($field, 'column_name'); } ?>
                    <?php if(get_value($field, 'column_key') == 'PRI') { ?>
                    <i class="fa fa-key fa-fw text-warning" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Primary key') ?>"></i>
                    <?php } ?>
                </td>
                <td><?php echo get_value($field, 'label') ?></td>
                <td><?php echo get_value($field, 'type')?></td>
                <td style="width: 01%"><?php echo get_value($field, 'order_') ?></td>
                <td style="width: 01%">
                    <input type="checkbox" class="enable-field" id="field-<?php echo $i ?>" <?php echo ($dtt_inative == '' && $id_field != '') ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>
            <?php $i++; endforeach; ?>

        </tbody>

    </table>

</div>

<!-- Modals to edit fields -->
<?php
$i = 0;
foreach ($fields as $field) :
?>
<form class="edit-field">

    <div class="modal fade" id="modal-edit-field-<?php echo $operation . '-' . $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit field')?></h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" class="id_module_form_field" value="<?php echo get_value($field, 'id_module_form_field') ?>" />

                    <div class="form-group">
                        <label><?php echo lang('Label') ?>*</label>
                        <input type="text" class="form-control validate[required] lbl" value="<?php echo get_value($field, 'label') ?>" />
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Table.column') ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_value($module, 'table_name') ?>.</span>
                            <input type="text" class="form-control table_column" value="<?php echo get_value($field, 'table_column') ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Type') ?>*</label>
                                <select class="form-control validate[required] type">
                                    <option value="text" <?php echo (get_value($field, 'type') == 'text') ? 'selected="selected"' : ''; ?>>input text</option>
                                    <option value="password" <?php echo (get_value($field, 'type') == 'password') ? 'selected="selected"' : ''; ?>>input password</option>
                                    <option value="textarea" <?php echo (get_value($field, 'type') == 'textarea') ? 'selected="selected"' : ''; ?>>textarea</option>
                                    <option value="file" <?php echo (get_value($field, 'type') == 'file') ? 'selected="selected"' : ''; ?>>file</option>
                                    <option value="checkbox" <?php echo (get_value($field, 'type') == 'checkbox') ? 'selected="selected"' : ''; ?>>checkbox</option>
                                    <option value="radio" <?php echo (get_value($field, 'type') == 'radio') ? 'selected="selected"' : ''; ?>>radio</option>
                                    <option value="select" <?php echo (get_value($field, 'type') == 'select') ? 'selected="selected"' : ''; ?>>select</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Order') ?></label>
                                <input type="text" class="form-control order_" alt="integer" value="<?php echo get_value($field, 'order_') ?>" />
                            </div>

                        </div>
                    </div>

                    <h4 class="ap-opener" style="margin-top: 20px">
                        <a href="javascript:void(0)"><?php echo lang('Additional properties') ?></a>
                        <i class="fa fa-arrow-circle-right fa-fw"></i>
                    </h4>
                    <hr style="margin: 10px 0" />

                    <div class="additional-properties" style="display: none">

                        <div class="form-group">
                            <label><?php echo lang('Description') ?></label>
                            <input type="text" class="form-control description" value="<?php echo get_value($field, 'description') ?>" />
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label><?php echo lang('ID HTML') ?></label>
                                    <input type="text" class="form-control id_html" value="<?php echo get_value($field, 'id_html') ?>" />
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label><?php echo lang('Class HTML') ?></label>
                                    <input type="text" class="form-control class_html" value="<?php echo get_value($field, 'class_html') ?>" />
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9">

                                <div class="form-group">
                                    <label><?php echo lang('Style HTML') ?></label>
                                    <i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Enter any CSS property separated by semicolon. It is not necessary put the style= declaration') ?>"></i>
                                    <input type="text" class="form-control style" value="<?php echo get_value($field, 'style') ?>" />
                                </div>

                            </div>

                            <div class="col-sm-3">

                                <div class="form-group">
                                    <label><?php echo lang('Maxlength') ?></label>
                                    <input type="text" class="form-control maxlength" alt="integer" value="<?php echo get_value($field, 'maxlength') ?>" />
                                </div>

                            </div>
                        </div>

                        <h5 class="text-muted"><?php echo lang('For fields Select, Checkbox and Radio') ?></h5>

                        <div class="form-group">
                            <label><?php echo lang('JSON options') ?></label>
                            <i class="popover-json fa fa-question-circle fa-fw cursor-pointer"></i>
                            <textarea class="form-control options_json"><?php echo get_value($field, 'options_json') ?></textarea>
                            <div class="list-json hide">
                                <small>
                                    <div><?php echo lang('Example:') ?></div>
                                    <pre>[ { "CAMPO1" : "VALOR 1" }, { "CAMPO2" : "VALOR 2" } ]</pre>
                                </small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo lang('SQL query options') ?></label>
                            <i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('The SQL to be executed must has two columns, one of them being the value that will be placed on HTML value attribute and another one that will be placed on label option. For example: SELECT VALUE, LABEL FROM TABLE') ?>"></i>
                            <textarea class="form-control options_sql"><?php echo get_value($field, 'options_sql') ?></textarea>
                        </div>

                    </div>

                    <h4 class="js-opener" style="margin-top: 60px">
                        <a href="javascript:void(0)"><?php echo lang('Javascript, masks and validations') ?></a>
                        <i class="fa fa-arrow-circle-right fa-fw"></i>
                    </h4>
                    <hr style="margin: 10px 0" />

                    <div class="js-properties" style="display: none">

                        <div class="form-group">
                            <label><?php echo lang('Javascript') ?></label>
                            <i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Example: onclick=do_something( this.value ), onchange=free_me_please( this.value )') ?>"></i>
                            <textarea class="form-control javascript"><?php echo get_value($field, 'javascript') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label><?php echo lang('Masks') ?></label>
                                    <i class="popover-masks fa fa-question-circle fa-fw cursor-pointer"></i>
                                    <a href="https://github.com/fabiomcosta/jquery-meiomask" tabindex="-1" target="_blank" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('See Meiomask docs') ?>"><i class="fa fa-fw fa-book"></i></a>
                                    <textarea class="form-control masks"><?php echo get_value($field, 'masks') ?></textarea>
                                    <div class="list-masks hide">
                                        <h6 class="text-bold"><?php echo lang("Enter masks separated by semicolon ';'") ?></h6>
                                        <hr />
                                        <div style="max-height: 170px; overflow-y: auto">
                                        <small>
                                            <div><strong>phone:</strong> (99) 99999-9999</div>
                                            <div><strong>phone-us:</strong> (999) 999-9999</div>
                                            <div><strong>cpf:</strong> 999.999.999-99</div>
                                            <div><strong>cnpj:</strong> 99.999.999/9999-99</div>
                                            <div><strong>date:</strong> 9999-19-39</div>
                                            <div><strong>date-us:</strong> 19/39/9999</div>
                                            <div><strong>cep:</strong> 99999-999</div>
                                            <div><strong>time:</strong> 99:99</div>
                                            <div><strong>hour:</strong> 29:59</div>
                                            <div><strong>credit-card:</strong> 9999 9999 9999 9999</div>
                                            <div><strong>integer:</strong> 99999999999999999</div>
                                            <div><strong>decimal:</strong> 999999999999999.99</div>
                                        </small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label><?php echo lang('Validations') ?></label>

                                    <i class="popover-validations fa fa-question-circle fa-fw cursor-pointer"></i>
                                    <a href="http://posabsolute.github.io/jQuery-Validation-Engine/" tabindex="-1" target="_blank" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('See Validation Engine docs') ?>"><i class="fa fa-fw fa-book"></i></a>
                                    <textarea class="form-control validations"><?php echo get_value($field, 'validations') ?></textarea>
                                    <div class="list-validations hide">
                                        <h6 class="text-bold"><?php echo lang("Enter validations separated by semicolon ';'") ?></h6>
                                        <hr />
                                        <div style="max-height: 170px; overflow-y: auto">
                                        <small>
                                            <div><strong>phone:</strong> <?php echo lang('Almost all phone numbers validator') ?></div>
                                            <div><strong>phone-us:</strong> <?php echo lang('Almost all phone numbers validator') ?></div>
                                            <div><strong>cpf:</strong> <?php echo lang('CPF validator') ?></div>
                                            <div><strong>cnpj:</strong> <?php echo lang('CNPJ validator') ?></div>
                                            <div><strong>date:</strong> <?php echo lang('dates on format YYYY-MM-DD') ?></div>
                                            <div><strong>date-us:</strong> <?php echo lang('dates on format MM/DD/YYYY') ?></div>
                                            <div><strong>cep:</strong> <?php echo lang('CEP validator') ?></div>
                                            <div><strong>time:</strong> <?php echo lang('time validator') ?></div>
                                            <div><strong>hour:</strong> <?php echo lang('hour validator') ?></div>
                                            <div><strong>credit-card:</strong> <?php echo lang('credit card format validator') ?></div>
                                            <div><strong>integer:</strong> <?php echo lang('integer numbers') ?></div>
                                            <div><strong>decimal:</strong> <?php echo lang('double/float values') ?></div>
                                            <hr />
                                            <div><strong>required:</strong> <?php echo lang('mandatory field') ?></div>
                                            <div><strong>minSize[7]:</strong> <?php echo lang('size of field value must be at least the same of the given parameter [7]') ?></div>
                                            <div><strong>maxSize[7]:</strong> <?php echo lang('size of field value must be max of the given parameter [7]') ?></div>
                                            <div><strong>min[7]:</strong> <?php echo lang('check if the field value is less than the given parameter [7]') ?></div>
                                            <div><strong>max[7]:</strong> <?php echo lang('check if the field value is more than the given parameter [7]') ?></div>
                                            <div><strong>past[NOW or date YYYY-MM-DD]:</strong> <?php echo lang('check if value is in the past of given date') ?></div>
                                            <div><strong>future[NOW or date YYYY-MM-DD]:</strong> <?php echo lang('check if value is in the future of given date') ?></div>
                                            <div><strong>minCheckbox[7]:</strong> <?php echo lang('min checkboxes to be checked') ?></div>
                                            <div><strong>maxCheckbox[7]:</strong> <?php echo lang('max checkboxes to be checked') ?></div>
                                            <div><strong>equals[field-id]:</strong> <?php echo lang('compare the value with another field id value, like password') ?></div>
                                            <div><strong>email:</strong> <?php echo lang('email validator') ?></div>
                                            <div><strong>fullname:</strong> <?php echo lang('Name and surname validator') ?></div>
                                            <div><strong>zip:</strong> <?php echo lang('ZIP Code validator') ?></div>
                                            <div><strong>ipv4:</strong> <?php echo lang('IP addresses') ?></div>
                                            <div><strong>url:</strong> <?php echo lang('URL validator') ?></div>
                                            <div><strong>onlyNumberSp:</strong> <?php echo lang('only numbers') ?></div>
                                            <div><strong>onlyLetterSp:</strong> <?php echo lang('only letters') ?></div>
                                            <div><strong>onlyLetterAccentSp:</strong> <?php echo lang('only letters (accent allowed)') ?></div>
                                            <div><strong>onlyLetterNumber:</strong> <?php echo lang('only letters and numbers, no spacing') ?></div>
                                            <div><strong>className:</strong> <?php echo lang('Valid class name') ?></div>
                                        </small>
                                        </div>
                                    </div>
                                </div>

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
<?php $i++; endforeach; ?>

<?php else: ?>

<div class="well" style="margin-top: 30px;"><span class="text-muted text-italic"><?php echo lang('There is no table for this module') ?></span></div>

<?php endif; ?>

<style>
    #table-fields-<?php echo $operation ?> { margin: 0 !important ;}
</style>

<script>

    // ========
    // Meiomask
    // ========
    $('input[type="text"]').setMask();

    // ======================
    // Cancel original submit
    // ======================
    $('form').submit(function () {
        return false;
    });

    // ==========
    // DataTables
    // ==========
    $('#table-fields-<?php echo $operation ?>').dataTable({
        info : false,
        paging: false,
        searching : false,
        aaSorting: [],
        columnDefs: [ { 'orderable': false, 'targets': [4] } ]
    });

    // =============================
    // Submit callback (update form)
    // =============================
    $.edit_form_submit_callback = function (form, status) {

        // Validation is not right
        if( ! status)
            return false;

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/save-form/update',
            context: document.body,
            data : {
                'id_module_form' : form.find('.id_module_form').val(),
                'action' : form.find('.action').val(),
                'method' : form.find('.method').val(),
                'enctype' : form.find('.enctype').val()
            },
            cache: false,
            type: 'POST',

            complete : function (response) {
                $.disable_loading();
                $.callbak_edit_response_complete(response, form);
            }
        });

        // Prevent submit
        return false;
    };

    // ==============================
    // Submit callback (update field)
    // ==============================
    $.edit_field_submit_callback = function (form, status) {

        // Validation is not right
        if( ! status)
            return false;

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/save-form-field/update',
            context: document.body,
            data : {
                'id_module_form_field' : form.find('input.id_module_form_field').val(),
                'label' : form.find('.lbl').val(),
                'table_column' : form.find('.table_column').val(),
                'order_' : form.find('.order_').val(),
                'type' : form.find('.type').val(),
                'description' : form.find('.description').val(),
                'id_html' : form.find('.id_html').val(),
                'class_html' : form.find('.class_html').val(),
                'style' : form.find('.style').val(),
                'maxlength' : form.find('.maxlength').val(),
                'options_sql' : form.find('.options_sql').val(),
                'options_json' : form.find('.options_json').val(),
                'javascript' : form.find('.javascript').val(),
                'masks' : form.find('.masks').val(),
                'validations' : form.find('.validations').val()
            },
            cache: false,
            type: 'POST',

            complete : function (response) {
                $.disable_loading();
                $.callbak_edit_response_complete(response, form);
            }
        });

        // Prevent submit
        return false;
    };

    // =======================================================================
    // Callback ajax complete (after enable field, enable form, enable action)
    // =======================================================================
    $.callbak_enable_response_complete = function (response) {

        // Parse json to check errors
        json = $.parseJSON(response.responseText);

        // Check return
        if( ! json.return) {
            // Close modal and alert
            bootbox.alert(json.error);
            return false;
        }

        // Reload area, this function comes from config.php
        $.load_area('form-<?php echo $operation ?>');
    };

    // ====================================================
    // Callback ajax complete (after edit field, edit form)
    // ====================================================
    $.callbak_edit_response_complete = function (response, form) {

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
            $.load_area('form-<?php echo $operation ?>');
        });
    };

    // ====================================
    // Click enable pointer checkbox toggle
    // ====================================
    $('.enable-pointer').click( function () {

        // Get pointer type
        var pointer_label = $(this).attr('data-pointer-label');

        // Get form operation
        var form_oper = '<?php echo $operation ?>';

        // Get operation
        var oper = pointer_label + '-form-' + form_oper;
        var oper = $(this).is(':checked') ? 'enable-' + oper : 'disable-' + oper;

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/save-' + pointer_label + '/' + oper,
            context: document.body,
            data : { 'id_module' : <?php echo $id_module ?> },
            cache: false,
            type: 'POST',
            complete : function (response) {
                $.disable_loading();
                $.callbak_enable_response_complete(response);
            }
        });

        // Prevent submit
        return false;
    });

    // =================================
    // Click enable form checkbox toggle
    // =================================
    $('.enable-form').click( function () {

        // Get operation
        var oper = $(this).is(':checked') ? 'enable' : 'disable';

        // Ajax to save this
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/save-form/' + oper,
            context: document.body,
            data : { 'id_module_form' : <?php echo get_value($form, 'id_module_form') ?> },
            cache: false,
            type: 'POST',
            complete : function (response) {
                $.disable_loading();
                $.callbak_enable_response_complete(response);
            }
        });

        // Prevent submit
        return false;
    });

    // ===========================
    // Click enable field checkbox
    // ===========================
    $('.enable-field').click( function () {

        // Get id
        var id = $(this).attr('id').replace('field-', '');

        // Get operation
        var oper = $(this).is(':checked') ? 'enable' : 'disable';

        // Ajax to save this fucking shit
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/save-form-field/' + oper,
            context: document.body,
            data : {
                'id_module_form' : <?php echo get_value($form, 'id_module_form') ?> ,
                'column_name' : $('#tr-' + id + ' .column_name').val()
            },
            cache: false,
            type: 'POST',
            complete : function (response) {
                $.disable_loading();
                $.callbak_enable_response_complete(response);
            }
        });

        // Prevent submit
        return false;
    });

    // ==========================
    // Validation form edit modal
    // ==========================
    $('form.edit-form').validationEngine('attach', {
        promptPosition : "bottomRight",
        scroll: false,
        onValidationComplete: function (form, status) { $.edit_form_submit_callback(form, status); }
    });

    // ===========================
    // Validation field edit modal
    // ===========================
    $('form.edit-field').validationEngine('attach', {
        promptPosition : "bottomRight",
        scroll: false,
        onValidationComplete: function (form, status) { $.edit_field_submit_callback(form, status); }
    });

    // ========================================================================
    // Click to collapse field additional properties, js, masks and validations
    // ========================================================================
    $('h4.ap-opener, h4.js-opener').click( function () {

        var cls = $(this).hasClass('js-opener') ? '.js-properties' : '.additional-properties';

        if( $(this).parent().find(cls).is(':visible') ) {

            $(this).find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-right');
            $(this).parent().find(cls).slideUp();

        } else {

            $(this).find('i').removeClass('fa-arrow-circle-right').addClass('fa-arrow-circle-down');
            $(this).parent().find(cls).slideDown(300);
        }
    });

    // ============
    // Popover json
    // ============
    $('.popover-json').popover( {
        html: true,
        content: function () { return $(".list-json").html(); }
    });

    // =============
    // Popover masks
    // =============
    $('.popover-masks').popover( {
        html: true,
        content: function () { return $(".list-masks").html(); }
    });

    // ===================
    // Popover validations
    // ===================
    $('.popover-validations').popover( {
        html: true,
        content: function () { return $(".list-validations").html(); },
        placement: 'left'
    });

</script>