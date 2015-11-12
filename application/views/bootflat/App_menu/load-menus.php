<?php
	function custom_menu_tree($menus = array())
	{
		$html = '';

		// Build all application menus in a tree format
		foreach($menus as $menu)
		{
			// Check if this menu has children
			$count_menu_children = count(get_value($menu, 'children'));

			// Build a single line menu
			$html .= '<li id="menu-item-' . get_value($menu, 'id_menu') . '" class="dd-item dd3-item" data-id="' . get_value($menu, 'id_menu') . '" order="' . get_value($menu, 'order_') . '">';

			$html .= '<div class="dd-handle dd3-handle"></div>';

			$html .= '<div class="dd3-content">';

				$class = get_value($menu, 'dtt_inative') != '' ? 'text-error' : '';

                $img = image(get_value($menu, 'url_img'));

                $label = get_value($menu, 'url_img') == '' && get_value($menu, 'label') == '' ? '[NO NAME]' : lang(get_value($menu, 'label'));

				$html .= '<a href="javascript:void(0)" class="menu-label ' . $class . '" data-toggle="modal" data-target="#modal-menu-' . get_value($menu, 'id_menu') . '">' . $img . ' ' . $label . '</a>';

				$html .= '<i class="text-success fa fa-fw fa-check-circle" style="display: none; margin-left: 5px"></i>';

				$html .= '<a href="javascript:void(0)" class="menu-delete pull-right hidden"><i class="fa fa-trash fa-fw"></i></a>';

			$html .= '</div>';

			// If current menu has children items, then build all again
			if($count_menu_children > 0)
				$html .= '<ol class="dd-list">' . custom_menu_tree(get_value($menu, 'children')) . '</ol>';

			$html .= '</li>';
		}

		return $html;
	}
?>

<!-- Now, modal menus -->
<?php
foreach($form_menus as $menu) {
$id_menu = get_value($menu, 'id_menu');
?>
<form menu="<?php echo URL_ROOT ?>/app-menu/save/update" method="post">

    <div class="modal fade" id="modal-menu-<?php echo $id_menu ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit menu')?></h4>
                </div>

                <div class="modal-body">

                    <input type="hidden" class="id_menu" value="<?php echo $id_menu ?>" />
                    <input type="hidden" class="id_user_group" value="<?php echo get_value($menu, 'id_user_group')?>" />
                    <input type="hidden" class="id_menu_parent_tmp" value="<?php echo get_value($menu, 'id_menu_parent')?>" />

                	<div class="row">
                        <div class="col-sm-4">

                			<div class="form-group">
                        		<label><?php echo lang('Group') ?>*</label>
                        		<span class="user-group-label form-control"></span>
                    		</div>

                    	</div>

                    	<div class="col-sm-8">

                    		<div class="form-group">
                        		<label><?php echo lang('Parent menu') ?></label>
		                        <select class="form-control id_menu_parent"></select>
		                    </div>

                    	</div>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Menu label') ?></label>
                        <input type="text" class="form-control lbl" value="<?php echo get_value($menu, 'label') ?>" />
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                        	<div class="form-group">
                        		<label><?php echo lang('Link') ?> </label>
                                <i class="fa fa-fw fa-question-circle url-root"></i>
                                <input type="text" class="form-control link" value="<?php echo get_value($menu, 'link') ?>" />
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
                                <i class="fa fa-fw fa-question-circle url-img"></i>
                                <input type="text" class="form-control url_img" value="<?php echo htmlentities(get_value($menu, 'url_img')) ?>" />
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
<form menu="<?php echo URL_ROOT ?>/app-menu/save/insert" method="post" id="new-menu">

    <div class="modal fade" id="modal-new-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang('New menu')?></h4>
                </div>

                <div class="modal-body">

                	<input type="hidden" class="id_user_group" value="" />

                	<div class="row">
                        <div class="col-sm-4">

                			<div class="form-group">
                        		<label><?php echo lang('Group') ?>*</label>
                        		<span class="user-group-label form-control"></span>
                    		</div>

                    	</div>

                    	<div class="col-sm-8">

                    		<div class="form-group">
                        		<label><?php echo lang('Parent menu') ?></label>
		                        <select class="form-control id_menu_parent"></select>
		                    </div>

                    	</div>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('Menu label') ?></label>
                        <input type="text" class="form-control lbl" value="" />
                    </div>

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label><?php echo lang('Link') ?></label>
                                <i class="fa fa-fw fa-question-circle url-root"></i>
                                <input type="text" class="form-control link" value="" />
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
                                <i class="fa fa-fw fa-question-circle url-img"></i>
                                <input type="text" class="form-control url_img" value="" />
                            </div>

                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label><?php echo lang('Order') ?></label>
                                <input type="text" class="form-control order_" alt="integer" value="10" />
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

<div class="popover-url-root hide">
    <div>
        <small><strong><?php echo lang('Use {URL_ROOT} to save value of PHP URL_ROOT constant, like') ?>:</strong></small>
        <pre>{URL_ROOT}/controller/action</pre>
    </div>
</div>

<div class="popover-url-img hide">
    <div>
        <small><strong><?php echo lang('Use {URL_IMG} to save value of PHP URL_IMG constant, like') ?>:</strong></small>
        <pre>{URL_IMG}/my-image.png</pre>
    </div>
    <div style="margin: 10px 0 0">
        <small><strong><?php echo lang('You can also use font-awesome, like')?>:</strong></small>
        <pre>&lt;i class="fa fa-home"&gt;&lt;/i&gt;</pre>
    </div>
</div>

<!-- Nestable Plugin -->
<link href="<?php echo URL_JS ?>/nestable/nestable.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL_JS ?>/nestable/jquery.nestable.js"></script>

<?php if ( count($menus) > 0 ) : ?>

<div class="dd"><ol class="dd-list"><?php echo custom_menu_tree($menus); ?></ol></div>

<?php else : echo message('info', '', lang('There is no menu items for this group. Click on button New menu above to start adding a new menu.')); endif; ?>

<script>

    // ===========
    // Popovers :)
    // ===========
    $('.form-group i').popover( {
        trigger : 'hover',
        title :  '<?php echo lang('Example of use') ?>:',
        html: true,
        content: function () {
            console.log($(this).attr('class'));
            var cls = $(this).attr('class').replace('fa fa-fw fa-question-circle ', '');
            console.log(cls);
            return $('.popover-' + cls).html();
        }
    });

	// ==============
    // Nestable items
    // ==============
    $('.dd').nestable({

        dropCallback: function(details) {
            $.reorder_menu(details.sourceId, details.destId, false);
        }
    });

	// ======================
	// Show delete button 'x'
	// ======================
	$('.dd3-content').on('mouseover mouseout', function() {
		$(this).find('.menu-delete').toggleClass('show hidden');
	});

	// ====================================
	// Change current group for insert form
	// ====================================
	$('.btn-new-menu').on('click', function () {

		// Change label
		$('#new-menu .id_user_group').val( $('#select-groups').val() );
		$('#new-menu .user-group-label').html( $('#select-groups option:selected').text() );

		$.enable_loading();

		// Get all menus for this group
		$.ajax({
            url: $('#URL_ROOT').val() + '/app-menu/group-menus-options/' + $('#select-groups').val(),
            context: document.body,
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

	            // Set all parent menus options
	            $('#new-menu .id_menu_parent').html(json.options);
            }
        });
	});

	// ====================================
	// Change current group for update form
	// ====================================
	$('.menu-label').on('click', function () {

		// Closest element (current form)
		var id = $(this).closest('.dd3-item').attr('data-id');

		// Change label
		$('#modal-menu-' + id + ' .id_user_group').val( $('#select-groups').val() );
		$('#modal-menu-' + id + ' .user-group-label').html( $('#select-groups option:selected').text() );

		$.enable_loading();

		// Get all menus for this group
		$.ajax({
            url: $('#URL_ROOT').val() + '/app-menu/group-menus-options/' + $('#select-groups').val(),
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

	            // Set all parent menus options and change value
	            $('#modal-menu-' + id + ' .id_menu_parent').html(json.options).val( $('#modal-menu-' + id + ' .id_menu_parent_tmp').val() );
            }
        });
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

		// Ajax to save this
		$.enable_loading();

    	$.ajax({
            url: form.attr('menu'),
            context: document.body,
            data : {
                'id_menu' : form.find('.id_menu').val(),
                'id_menu_parent' : form.find('.id_menu_parent').val(),
                'id_user_group' : form.find('.id_user_group').val(),
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

                    // Load menus again :)
                    $.load_menus($('#select-groups').val());

                });
            }
        });

        // Prevent submit
    	return false;
    };

    // ================
    // Reorder function
    // ================
    $.reorder_menu = function(source, dest, recursion) {

        if ( ! recursion)
            $.enable_loading();

        // Calculate order properly
        var order = $('#menu-item-' + source).prev().attr('order');

        if( isNaN(order) )
            order = 1;
        else
            order++;

        $.ajax({
            url: $('#URL_ROOT').val() + '/app-menu/save/reorder',
            context: document.body,
            data: {
                'id_menu' : source,
                'id_menu_parent' : dest,
                'order_' : order
            },
            cache: false,
            type: 'POST',

            complete : function (response) {

                if ( !recursion ) {
                    $.disable_loading();

                    // Parse json to check errors
                    json = $.parseJSON(response.responseText);

                    // Check return
                    if( ! json.return) {
                        // Close modal and alert
                        bootbox.alert(json.error);
                        return false;
                    }

                    // Success icon!
                    $('#menu-item-' + source + ' .text-success').first().fadeIn();

                    setTimeout( function () {
                        $('#menu-item-' + source + ' .text-success').first().fadeOut();
                    }, 4000);
                }

                // Change current order
                $('#menu-item-' + source).attr('order', order);

                // Reorder all menus from the same list level
                if($('#menu-item-' + source).next().length > 0)
                    $.reorder_menu($('#menu-item-' + source).next().attr('data-id'), dest, true);
            }
        });
    };

    // ====================
    // Remove menu callback
    // ====================
    $('.menu-delete').click( function () {

        // Get id
        var id = $(this).closest('.dd3-item').attr('data-id');

        // Confirm this shit
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected menu? All children menu of it will be deleted as well.') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // Ajax to remove this
            $.enable_loading();

            $.ajax({
                url: $('#URL_ROOT').val() + '/app-menu/save/delete',
                context: document.body,
                data: { 'id_menu' : id },
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
					$.load_menus($("#select-groups").val());
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