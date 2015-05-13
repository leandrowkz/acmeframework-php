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

		<div class="col-sm-12">

			<?php

			$action = (get_value($form, 'action') != '') ? tag_replace(get_value($form, 'action')) : URL_ROOT . '/' . $this->controller . '/form_process';
			$enctype = (get_value($form, 'enctype') != '') ? 'enctype="' . get_value($form, 'enctype') . '"' : '';
			$method = (get_value($form, 'method') != '') ? get_value($form, 'method') : 'post';

			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $operation ?>" />

			<input type="hidden" name="pk_value" id="pk_value" value="<?php echo $pk_value ?>" />

			<h3 style="margin: 0 0 30px"><?php echo lang(ucwords($operation)) ?></h3>

			<div class="well" style="padding-bottom: 5px; margin-bottom: 30px;">

				<?php foreach ($fields as $field) : ?>

				<div class="form-group">
	                <label><?php echo lang(get_value($field, 'label')) ?></label>
		        	<?php if( get_value($field, 'description') != '') { ?>
		        	<i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_value($field, 'description') ?>"></i>
		        	<?php } ?>
		            <p><?php echo get_value($values, get_value($field, 'table_column')) ?></p>
	            </div>

	            <?php endforeach ?>

            </div>

            <div class="form-footer">
                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/<?php echo $this->controller ?>"><i class="fa fa-fw fa-arrow-circle-left"></i> <?php echo lang('Back') ?></a>
	        </div>

	    </div>

	</div>

</div>


<script>

	// ========
	// Tooltips
	// ========
	$('i').tooltip();

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