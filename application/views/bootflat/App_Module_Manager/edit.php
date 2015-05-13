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

				<a href="<?php echo URL_ROOT ?>/app-module-manager/config/<?php echo get_value($module, 'id_module')?>" class="pull-right clearfix btn btn-default">
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

		<div class="col-sm-8 col-md-7">

			<form action="<?php echo URL_ROOT ?>/app-module-manager/edit/<?php echo get_value($module, 'id_module') ?>/true" method="post">

				<h3 style="margin: 0 0 30px 0"><?php echo lang('Edit module') ?></h3>

	            <div class="form-group">
	                <label><?php echo lang('Table') ?></label>
	                <input type="text" id="table_name" name="table_name" class="form-control" value="<?php echo get_value($module, 'table_name') ?>" />
	            </div>

				<div class="form-group">
	                <label><?php echo lang('Label') ?>*</label>
	                <input type="text" id="label" name="label" class="form-control validate[required]" value="<?php echo get_value($module, 'label') ?>" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Description') ?></label>
	                <input type="text" id="description" name="description" class="form-control" value="<?php echo get_value($module, 'description') ?>" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Image URL') ?></label>
	                <input type="text" id="url_img" name="url_img" class="form-control" value="<?php echo htmlentities(get_value($module, 'url_img')) ?>" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('SQL query list') ?></label>
	                <textarea name="sql_list" id="sql_list" class="form-control" style="height: 180px"><?php echo get_value($module, 'sql_list') ?></textarea>
	            </div>

		        <div class="form-footer">
	                <button class="btn btn-success" type="submit"><?php echo lang('Save') ?> <i class="fa fa-fw fa-check-circle"></i></button>
	                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app-module-manager/config/<?php echo get_value($module, 'id_module') ?>"><?php echo lang('Cancel') ?></a>
		        </div>

			</form>

	    </div>

   	</div>

</div>

<script>

	// ====================
	// Set form validations
	// ====================
    $('form').validationEngine('attach', { promptPosition : "bottomRight" });

    // ===============================
    // Reposition the alerts from form
    // ===============================
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });

</script>