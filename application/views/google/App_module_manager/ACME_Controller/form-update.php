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

				<a href="<?php echo URL_ROOT ?>/<?php echo $this->controller ?>" class="pull-right clearfix btn btn-default">
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

			<?php

			$action = (get_value($form, 'action') != '') ? tag_replace(get_value($form, 'action')) : URL_ROOT . '/' . $this->controller . '/form_process';
			$enctype = (get_value($form, 'enctype') != '') ? 'enctype="' . get_value($form, 'enctype') . '"' : '';
			$method = (get_value($form, 'method') != '') ? get_value($form, 'method') : 'post';

			?>

			<form action="<?php echo $action ?>" method="<?php echo $method ?>" <?php echo $enctype ?>>

				<input type="hidden" name="operation" id="operation" value="<?php echo $operation ?>" />

				<input type="hidden" name="pk_value" id="pk_value" value="<?php echo $pk_value ?>" />

				<h3 style="margin: 0 0 30px 0"><?php echo lang(ucwords($operation)) ?></h3>

				<?php foreach($html_fields as $field) { ?>

				<div class="form-group">
	                <?php echo $field ?>
	            </div>

	            <?php } ?>

	            <div class="form-footer">
	                <button class="btn btn-success" type="submit"><?php echo lang('Save') ?> <i class="fa fa-fw fa-check-circle"></i></button>
	                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/<?php echo $this->controller ?>"><?php echo lang('Cancel') ?></a>
		        </div>

			</form>

	    </div>

	</div>

</div>

<script>

    // ===============
    // Set field masks
    // ===============
    $('input[type=text]').setMask();

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