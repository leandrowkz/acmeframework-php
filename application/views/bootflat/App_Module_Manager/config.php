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

			<div class="pull-right clearfix">

				<a href="<?php echo URL_ROOT ?>/app-module-manager" class="pull-right clearfix btn btn-default">
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

	<div class="row">

		<div class="col-sm-12">

			<h3>
				<span><?php echo lang(get_value($module, 'label')) ?></span>
				<span><?php echo image(get_value($module, 'url_img')) ?></span>

				<a href="<?php echo URL_ROOT ?>/app-module-manager/edit/<?php echo get_value($module, 'id_module')?>" class="btn btn-xs btn-primary">
					<span><?php echo lang('Edit module')?></span>
					<i class="fa fa-arrow-circle-right fa-fw"></i>
				</a>
			</h3>

            <div class="well" style="margin-bottom: 40px;">

    			<div class="form-group">
    				<label><?php echo lang('Description') ?></label>
    				<p>
    	            <?php
    	            	if(get_value($module, 'description') != '') {
    	            		echo get_value($module, 'description');
    	            	} else {
    	            		echo '<em class="text-muted">' . lang('Module with no description') . '</em>';
    	            	}
    	            ?>
    	            </p>
            	</div>

    	        <div class="form-group">
    	            <label><?php echo lang('Table') ?></label>
    				<div>
    				<?php
    	            	if(get_value($module, 'table_name') != '') {
    	            		echo get_value($module, 'table_name');
    	            	} else {
    	            		echo '<em class="text-muted">' . lang('Module with no table') . '</em>';
    	            	}
    	            ?>
    				</div>
    	        </div>

    	        <div class="form-group">
    	            <label><?php echo lang('SQL list') ?></label>
    	            <div>
    	            <?php
    	            	if(get_value($module, 'sql_list') != '') {
    	            		echo '<code>' . get_value($module, 'sql_list') . '</code>';
    	            	} else {
    	            		echo '<em class="text-muted">' . lang('Module with no query') . '</em>';
    	            	}
    	            ?>
    	           	</div>
    	        </div>

    	    	<div class="form-group" style="margin: 0">
                    <label><?php echo lang('Module files (MVC)') ?></label>
    	    		<p style="margin: 0">
    	    			<i class="fa fa-fw fa-file-text-o"></i> application/controllers/<?php echo get_value($module, 'controller') ?>.php
                        <br />
    					<i class="fa fa-fw fa-database"></i>  application/models/<?php echo get_value($module, 'controller') ?>_Model.php
                        <br />
    					<i class="fa fa-fw fa-folder-o"></i> application/views/<?php echo TEMPLATE . '/' . get_value($module, 'controller') ?>/
    	    		</p>
    	    	</div>

            </div>

            <h3 class="inline"><?php echo lang('Module features') ?></h3>

            <!-- Nav tabs -->
            <ul class="nav nav-pills inline" style="margin: 0 0 -10px 15px">
                <li class="active">
                    <a href="#pill-permissions" data-operation="permissions" data-toggle="tab"><?php echo lang('Permissions')?> <i class="fa fa-fw fa-shield"></i></a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                        <?php echo lang('Forms') ?> <i class="fa fa-fw fa-toggle-on"></i> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#pill-form-insert" data-operation="form-insert" data-toggle="tab"><i class="fa fa-fw fa-plus-square"></i> <?php echo lang('Insert') ?></a></li>
                        <li><a href="#pill-form-update" data-operation="form-update" data-toggle="tab"><i class="fa fa-fw fa-pencil-square"></i> <?php echo lang('Update') ?></a></li>
                        <li><a href="#pill-form-delete" data-operation="form-delete" data-toggle="tab"><i class="fa fa-fw fa-minus-square"></i> <?php echo lang('Delete') ?></a></li>
                        <li><a href="#pill-form-view" data-operation="form-view" data-toggle="tab"><i class="fa fa-fw fa-binoculars"></i> <?php echo lang('View') ?></a></li>
                    </ul>
                </li>
                <li><a href="#pill-menus" data-operation="menus" data-toggle="tab"><?php echo lang('Menus')?> <i class="fa fa-fw fa-tasks"></i></a></li>
                <li><a href="#pill-actions" data-operation="actions" data-toggle="tab"><?php echo lang('Actions')?> <i class="fa fa-fw fa-rocket"></i></a></li>
            </ul>

            <hr style="margin: 0;" />

            <!-- Tab panes -->
            <div class="tab-content" style="padding: 0">
                <div class="tab-pane fade active in" id="pill-permissions"></div>
                <div class="tab-pane fade" id="pill-form-insert"></div>
                <div class="tab-pane fade" id="pill-form-delete"></div>
                <div class="tab-pane fade" id="pill-form-update"></div>
                <div class="tab-pane fade" id="pill-form-view"></div>
                <div class="tab-pane fade" id="pill-menus"></div>
                <div class="tab-pane fade" id="pill-actions"></div>
            </div>

            <!-- Aditional controls -->
            <input type="hidden" id="id-form" value="" />
            <input type="hidden" id="id-module" value="<?php echo get_value($module, 'id_module') ?>" />

	    </div>

    </div>

</div>

<!-- DataTables Plugin -->
<script src="<?php echo URL_JS ?>/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_JS ?>/dataTables/js/dataTables.bootstrap.js"></script>
<link href="<?php echo URL_JS ?>/dataTables/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />

<script>

    // ========
    // Tooltips
    // ========
    $('body').tooltip({
        selector: "[data-toggle=tooltip]",
        container : 'body'
    });

    // ======================
	// Loading pills function
    // ======================
	$.load_area = function (param) {

		$.enable_loading();

		$.ajax({
            url: $('#URL_ROOT').val() + '/app-module-manager/load-area/' + param + '/<?php echo get_value($module, 'id_module') ?>',
            context: document.body,
            cache: false,
            type: 'POST',
            complete : function (data) {
                console.log('#pill-' + param);
                $('#pill-' + param).html(data.responseText);
                $.disable_loading();
            }
        });

	};

    // ==============
	// Click on pills
    // ==============
	$('.nav-pills li a').click(function () {
        if ($(this).attr('data-operation') != undefined)
		  $.load_area( $(this).attr('data-operation') );
	});

    // ======================
	// First load Permissions
    // ======================
	$.load_area('permissions');

    // ===============================
	// Reposition the alerts from form
    // ===============================
    $( window ).resize( function () {
        $('form').validationEngine('updatePromptsPosition');
    });

</script>