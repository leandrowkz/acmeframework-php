<div class="module-header">

	<div class="row">

		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<h1>
				<?php echo lang($this->label) ?>
				<span><?php echo image($this->url_img) ?></span>
				<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
			</h1>
		</div>
		
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

			<div class="pull-right clearfix">
				
				<a href="<?php echo URL_ROOT ?>/app_module_manager" class="pull-right clearfix btn btn-primary">
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

		<div class="col-md-7 col-lg-7">
			
			<h3 style="margin-top: 0">

				<span><?php echo lang(get_value($module, 'label')) ?></span>
				
				<span><?php echo image(get_value($module, 'url_img')) ?></span>
				
				<a href="<?php echo URL_ROOT ?>/app_module_manager/edit/<?php echo get_value($module, 'id_module')?>" class="btn btn-xs btn-primary">
					<span><?php echo lang('Edit module')?></span>
					<i class="fa fa-arrow-circle-right fa-fw"></i>
				</a>

			</h3>

			<hr style="margin: 10px 0 20px 0" />

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
	            		echo '<pre>' . get_value($module, 'sql_list') . '</pre>';
	            	} else { 
	            		echo '<em class="text-muted">' . lang('Module with no query') . '</em>'; 
	            	}
	            ?>
	           	</div>
	        </div>

        </div>

        <div class="col-md-5 col-lg-5">

	    	<div class="panel panel-info">
	    		<div class="panel-heading"><?php echo lang('Module files (MVC)') ?></div>
	    		<div class="panel-body">
	    			<div><i class="fa fa-file-text fa-fw"></i> controllers/<?php echo get_value($module, 'controller') ?>.php</div>
					<div><i class="fa fa-file-text-o fa-fw"></i> models/<?php echo get_value($module, 'controller') ?>_model.php</div>
					<div><i class="fa fa-folder-o fa-fw"></i> views/<?php echo TEMPLATE . '/' . get_value($module, 'controller') ?>/</div>
	    		</div>
	    	</div>

	    </div>
    
    </div>

    <hr style="margin: 10px 0 20px 0" />

    <div class="row">

    	<div class="col-sm-12">

            <!-- Nav tabs -->
            <ul class="nav nav-pills">
                <li class="active"><a href="#permissions-pills" id="permissions" data-toggle="tab"><?php echo lang('Permissions')?></a>
                </li>
                <li class="dropdown">
                	<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                    	<?php echo lang('Forms') ?> <span class="caret"></span>
                  	</a>
                  	<ul class="dropdown-menu">
                    	<li><a href="#form-insert-pills" id="form-insert" data-toggle="tab"><?php echo lang('Insert') ?></a></li>
                    	<li><a href="#form-update-pills" id="form-update" data-toggle="tab"><?php echo lang('Update') ?></a></li>
                    	<li><a href="#form-delete-pills" id="form-delete" data-toggle="tab"><?php echo lang('Delete') ?></a></li>
                    	<li><a href="#form-view-pills" id="form-view" data-toggle="tab"><?php echo lang('View') ?></a></li>
                  	</ul>
                </li>
                <li><a href="#menus-pills" id="menus" data-toggle="tab"><?php echo lang('Menus')?></a>
                </li>
                <li><a href="#actions-pills" id="actions" data-toggle="tab"><?php echo lang('Actions')?></a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="padding: 0">
                <div class="tab-pane fade active in" id="permissions-pills">                            	
                </div>
                <div class="tab-pane fade" id="form-insert-pills">
                </div>
                <div class="tab-pane fade" id="form-update-pills">
                </div>
                <div class="tab-pane fade" id="form-delete-pills">
                </div>
                <div class="tab-pane fade" id="form-view-pills">
                </div>
                <div class="tab-pane fade" id="menus-pills">
                </div>
                <div class="tab-pane fade" id="actions-pills">
                </div>
            </div>

       </div>
       
    </div>
	
</div>

<style>
	
	.module-img img {
		max-width: 48px
	}

</style>

<script>
	
	// Loading pills function
	$.load_area = function (param) {
		
		$.enable_loading();

		$.ajax({
            url: $('#URL_ROOT').val() + '/app_module_manager/load_area/' + param + '/<?php echo get_value($module, 'id_module') ?>',
            context: document.body,
            cache: false,
            type: 'POST',
            complete : function (data) {
                $('#' + param + '-pills').html(data.responseText);
                $.disable_loading();
            }
        });

	};

	// Click on pills
	$('.nav-pills li a').click(function () {
		if($(this).attr('id') != undefined)
			$.load_area($(this).attr('id'));
	});

	// First load, yeah, its permissions!
	$.load_area('permissions');

	// Reposition the alerts from form
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });
	
</script>