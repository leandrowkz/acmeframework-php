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

				<a href="<?php echo URL_ROOT ?>/app-user" class="pull-right clearfix btn btn-default">
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

			<form action="<?php echo URL_ROOT ?>/app-user/new-user/true" method="post">

				<h3 style="margin: 0 0 30px 0"><?php echo lang('New user') ?></h3>

				<div class="form-group">
	                <label><?php echo lang('Group') ?>*</label>
	                <select class="form-control validate[required]" id="id_user_group" name="id_user_group">
	                	<?php echo $options ?>
	                </select>
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Name') ?>*</label>
	                <input type="text" id="name" name="name" class="form-control validate[required]" value="" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Description') ?></label>
	                <input name="description" id="description" class="form-control" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Email') ?>*</label>
	               	<i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Used to login on application') ?>"></i>
	                <input type="text" id="email" name="email" class="form-control validate[required, custom[email,funcCall[validate_email]]]" value="" />
	            </div>

	            <div class="row">

	            	<div class="col-sm-6">

			            <div class="form-group">
			                <label><?php echo lang('Password') ?>*</label>
			                <input type="password" id="password" name="password" class="form-control validate[required,minSize[6]]" value="" />
			            </div>

			        </div>

	            	<div class="col-sm-6">

	            		<div class="form-group">
			                <label><?php echo lang('Confirm password') ?>*</label>
			                <input type="password" id="repeat-password" name="repeat-password" class="form-control validate[required,minSize[6],equals[password]]" value="" />
			            </div>

	            	</div>

	        	</div>

		        <div class="form-group">
	                <label><?php echo lang('Default language') ?>*</label>
	                <select class="form-control validate[required]" id="lang_default" name="lang_default">
	                	<option value="en_US"><?php echo lang('English') ?></option>
	                	<option value="pt_BR"><?php echo lang('Brazilian Portuguese') ?></option>
	                </select>
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Default page / URL') ?>*</label>
	               	<i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('After login on application the user will be redirected to this page') ?>"></i>
	                <input type="text" id="url_default" name="url_default" class="form-control validate[required]" value="{URL_ROOT}/app-dashboard" />
	            </div>

				<div class="form-footer">
	                <button class="btn btn-success" type="submit"><?php echo lang('Save') ?> <i class="fa fa-fw fa-check-circle"></i></button>
	                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app-user"><?php echo lang('Cancel') ?></a>
		        </div>

			</form>

	    </div>

	</div>

</div>

<script>

	// ========
    // Tooltips
    // ========
    $('body').tooltip( { selector: "[data-toggle=tooltip]" } );

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