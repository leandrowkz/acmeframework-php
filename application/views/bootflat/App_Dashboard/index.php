<div class="module-header">

	<div class="row">

		<div class="col-xs-10 col-sm-10">
			<h1>
				<?php echo lang($this->label) ?>
				<span><?php echo image($this->url_img) ?></span>
				<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
			</h1>
		</div>

		<?php if ( count($this->menus) > 0 ) {?>

        <div class="col-xs-2 col-sm-2">

            <div class="btn-group pull-right clearfix">

                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-fw fa-cogs hidden-lg hidden-md"></i>
                    <div class="hidden-xs hidden-sm">
                        <i class="fa fa-fw fa-cogs"></i>
                        <span><?php echo lang('Actions') ?></span>
                        <span class="caret"></span>
                    </div>
                </button>

                <ul class="dropdown-menu">
                    <?php
                    foreach ($this->menus as $menu) {

                    // Build link
                    $link = tag_replace(get_value($menu, 'link'));
                    $target = (get_value($menu, 'target') != '') ? ' target="' . tag_replace(get_value($menu, 'target')) . '" ' : '';
                    $label = lang(get_value($menu, 'label'));
                    $img = image(get_value($menu, 'url_img'));

                    ?>
                    <li><a href="<?php echo $link ?>" <?php echo $target ?>><?php echo $img . ' ' . $label ?></a></li>
                    <?php } ?>
                </ul>

            </div>

        </div>

        <?php } ?>

	</div>

</div>

<div class="module-body">

	<div class="row">

		<div class="col-sm-6 col-md-6 col-lg-6">

			<div class="panel panel-normal panel-list custom-panels">

				<div class="panel-heading">
	                <i class="fa fa-cubes"></i>
	                <h1 class="pull-right"><?php echo count($modules) ?></h1>
	                <div class="text-right text-bold"style="margin-top:5px"><?php echo lang('Application modules')?></div>
	            </div>

				<div class="panel-body panel-body-modules">

					<div class="list-group" style="border: none">

						<a href="<?php echo URL_ROOT ?>/app-module-maker" class="list-group-item text-success" title="<?php echo lang('Click to go') ?>">
			            	<h3>
			            		<?php echo lang('New module') ?>
			            		<i class="fa fa-fw fa-plus-circle pull-right"></i>
			            	</h3>
			            	<p class="list-group-item-text text-success"><?php echo lang('Create a new module with Module Maker') ?></p>
			            </a>

						<?php foreach($modules as $module) { ?>
			        	<a href="<?php echo URL_ROOT ?>/<?php echo strtolower(str_replace('_', '-', get_value($module, 'controller')))?>" class="list-group-item" title="<?php echo lang('Click to go') ?>">
			        		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
			            	<h5 class="list-group-item-heading"><?php echo lang(get_value($module, 'label')) ?></h5>
			            	<p class="list-group-item-text"><?php echo lang(get_value($module, 'description')) ?></p>
			            </a>
			            <?php } ?>

			        </div>

			    </div>

			</div>

		</div>

		<div class="col-sm-6 col-md-6 col-lg-6">

			<div class="row">

				<?php
				$total_general_errors = count($general_errors);
				$total_php_errors = count($php_errors);
				$total_db_errors = count($db_errors);
				$total_errors = $total_general_errors + $total_php_errors + $total_db_errors;
				?>

				<div class="col-sm-12 col-md-12 col-lg-6 custom-panels">

					<div class="panel panel-list panel-danger">

			            <div class="panel-heading">
			                <i class="fa fa-bug"></i>
			                <h1 class="pull-right" id="count-errors"><?php echo $total_errors ?></h1>
			                <div class="text-right text-bold"style="margin-top:5px"><?php echo lang('Errors found')?></div>
			            </div>

			            <div class="panel-body panel-body-errors">

			            	<div class="panel-group panel-group-lists collapse in" id="errors-list">

				            	<div class="panel">

				                	<div class="panel-heading">

				                		<?php
				                		if ($total_general_errors >= 100)
				                			$badge = 'danger';
				                		elseif ($total_general_errors > 0)
				                			$badge = 'warning';
				                		else
				                			$badge = 'success';
				                		?>

				                  		<div class="panel-title">
				                    		<a data-toggle="collapse" data-parent="#errors-list" href="#general-errors" class="collapsed">
				                    		<?php echo lang('General errors') ?>
				                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($general_errors)?></span>
				                    		</a>
				                  		</div>

				                	</div>

				                	<div id="general-errors" class="panel-collapse collapse" style="height: 0px;">
				                  		<div class="panel-body">

				                  			<?php
				                  			if($total_general_errors > 0) {
				                  				$class_content = 'show';
				                  				$class_no_content = 'hidden';
				                  			} else {
				                  				$class_content = 'hidden';
				                  				$class_no_content = 'show';
				                  			}
				                  			?>

				                  			<div class="error-content <?php echo $class_content ?>">

					                  			<h5 class="text-muted"><?php echo lang('Showing last 50') ?></h5>

					                  			<div class="error-container">

						                  			<?php foreach($general_errors as $error) {?>
						                  			<div class="error-box">
						                  				<small>
						                  					<strong><?php echo lang('On') ?> <?php echo get_value($error, 'log_dtt_ins') ?></strong>
						                  					| <a href="javascript:void(0)" id="<?php echo get_value($error, 'id_log_error') ?>"><?php echo lang('Remove')?></a>
						                  				</small>
						                  				<p><small><?php echo get_value($error, 'message') ?></small></p>
						                  			</div>
						                  			<?php } ?>

						                  		</div>

						                  	</div>

					                  		<p class="<?php echo $class_no_content?>"><small class="text-muted"><?php echo lang('There is no general errors')?></small></p>

				                  			<h5 style="margin: 15px 0 0">
				                  				<a href="<?php echo URL_ROOT ?>/app-log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
				                  				</a>
				                  			</h5>

				                  		</div>
				                	</div>

				              	</div>

				              	<div class="panel">

				                	<div class="panel-heading">

				                		<?php
				                		if ($total_php_errors >= 100)
				                			$badge = 'danger';
				                		elseif ($total_php_errors > 0)
				                			$badge = 'warning';
				                		else
				                			$badge = 'success';
				                		?>

				                  		<div class="panel-title">
				                    		<a data-toggle="collapse" data-parent="#errors-list" href="#php-errors" class="collapsed">
				                    		<?php echo lang('PHP errors') ?>
				                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($php_errors)?></span>
				                    		</a>
				                  		</div>

				                	</div>

				                	<div id="php-errors" class="panel-collapse collapse" style="height: 0px;">
				                  		<div class="panel-body">

				                  			<?php
				                  			if($total_php_errors > 0) {
				                  				$class_content = 'show';
				                  				$class_no_content = 'hidden';
				                  			} else {
				                  				$class_content = 'hidden';
				                  				$class_no_content = 'show';
				                  			}
				                  			?>

				                  			<div class="error-content <?php echo $class_content ?>">

					                  			<h5 class="text-muted"><?php echo lang('Showing last 50') ?></h5>

					                  			<div class="error-container">

						                  			<?php foreach($php_errors as $error) {?>
						                  			<div class="error-box">
						                  				<small>
						                  					<strong><?php echo lang('On') ?> <?php echo get_value($error, 'log_dtt_ins') ?></strong>
						                  					| <a href="javascript:void(0)" id="<?php echo get_value($error, 'id_log_error') ?>"><?php echo lang('Remove')?></a>
						                  				</small>
						                  				<p><small><?php echo get_value($error, 'message') ?></small></p>
						                  			</div>
						                  			<?php } ?>

						                  		</div>

						                  	</div>

					                  		<p class="<?php echo $class_no_content?>"><small class="text-muted"><?php echo lang('There is no PHP errors')?></small></p>

				                  			<h5 style="margin: 15px 0 0">
				                  				<a href="<?php echo URL_ROOT ?>/app-log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
				                  				</a>
				                  			</h5>

				                  		</div>
				                	</div>

				              	</div>

				              	<div class="panel">

				                	<div class="panel-heading">

				                		<?php
				                		if ($total_db_errors >= 100)
				                			$badge = 'danger';
				                		elseif ($total_db_errors > 0)
				                			$badge = 'warning';
				                		else
				                			$badge = 'success';
				                		?>

				                  		<div class="panel-title">
				                    		<a data-toggle="collapse" data-parent="#errors-list" href="#database-errors" class="collapsed">
				                    		<?php echo lang('Database errors') ?>
				                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($db_errors)?></span>
				                    		</a>
				                  		</div>

				                	</div>

				                	<div id="database-errors" class="panel-collapse collapse" style="height: 0px;">
				                  		<div class="panel-body">

				                  			<?php
				                  			if($total_db_errors > 0) {
				                  				$class_content = 'show';
				                  				$class_no_content = 'hidden';
				                  			} else {
				                  				$class_content = 'hidden';
				                  				$class_no_content = 'show';

				                  			}
				                  			?>

				                  			<div class="error-content <?php echo $class_content ?>">

					                  			<h5 class="text-muted"><?php echo lang('Showing last 50') ?></h5>

					                  			<div class="error-container">

						                  			<?php foreach($db_errors as $error) {?>
						                  			<div class="error-box">
						                  				<small>
						                  					<strong><?php echo lang('On') ?> <?php echo get_value($error, 'log_dtt_ins') ?></strong>
						                  					| <a href="javascript:void(0)" id="<?php echo get_value($error, 'id_log_error') ?>"><?php echo lang('Remove')?></a>
						                  				</small>
						                  				<p><small><?php echo get_value($error, 'message') ?></small></p>
						                  			</div>
						                  			<?php } ?>

						                  		</div>

						                  	</div>

					                  		<p class="<?php echo $class_no_content?>"><small class="text-muted"><?php echo lang('There is no database errors')?></small></p>

				                  			<h5 style="margin: 15px 0 0">
				                  				<a href="<?php echo URL_ROOT ?>/app-log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
				                  				</a>
				                  			</h5>

				                  		</div>
				                	</div>

				              	</div>

					        </div>

			            </div>

			        </div>

				</div>

				<div class="col-sm-12 col-md-12 col-lg-6 custom-panels">

			        <div class="panel panel-default panel-list">

						<?php $total_browsers = count($browsers); ?>

			            <div class="panel-heading">
			                <i class="fa fa-compass"></i>
			                <h1 class="pull-right"><?php echo $total_browsers ?></h1>
			                <div class="text-right text-bold" style="margin-top:5px"><?php echo lang('Different browsers')?></div>
			            </div>

			            <div class="panel-body panel-body-modules">

			            	<div class="panel-group panel-group-lists">

				            	<div class="panel">

				                	<div class="panel-heading">

				                		<?php if( $total_browsers > 2) { ?>

					                		<?php for($i = 0; $i <= 1; $i++) { ?>
					             			<div class="panel-title">
					             				<a href="javascript:void(0)">
					                    		<span><?php echo get_value($browsers[$i], 'browser_name') ?> <?php echo get_value($browsers[$i], 'browser_version') ?></span>
					                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($browsers[$i], 'count_access') ?> <?php echo lang('access') ?></span>
					                    		</a>
					                  		</div>
					                  		<?php } ?>

				                  			<div class="browsers-container" style="display: none">

				                  				<?php for($i = 2; $i < $total_browsers; $i++) { ?>
						             			<div class="panel-title">
						             				<a href="javascript:void(0)">
						                    		<span><?php echo get_value($browsers[$i], 'browser_name') ?> <?php echo get_value($browsers[$i], 'browser_version') ?></span>
						                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($browsers[$i], 'count_access') ?> <?php echo lang('access') ?></span>
						                    		</a>
						                  		</div>
					                  			<?php } ?>

				                  			</div>

				                  			<div class="panel-title">
					                  			<h5>
					                  				<a class="see-all-browsers" href="javascript:void(0)">
														<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
					                  					<?php echo lang('See all browsers') ?>
					                  				</a>
					                  			</h5>
					                  		</div>

				                  		<?php } else { ?>

				                  			<?php foreach ($browsers as $browser) { ?>

				                  			<div class="panel-title">
					             				<a href="javascript:void(0)">
					                    		<span><?php echo get_value($browser, 'browser_name') ?> <?php echo get_value($browser, 'browser_version') ?></span>
					                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($browser, 'count_access') ?> <?php echo lang('access') ?></span>
					                    		</a>
					                  		</div>

					                  		<?php } ?>

				                  		<?php } ?>

				                	</div>

				              	</div>

					        </div>

			            </div>

			        </div>

				</div>

			</div>

			<div class="row">

				<div class="col-sm-12 col-md-12 col-lg-12 custom-panels">

					<div class="panel panel-default panel-list">

						<?php $total_devices = count($devices); ?>

			            <div class="panel-heading">
			                <i class="fa fa-tablet"></i>
			                <h1 class="pull-right"><?php echo $total_devices ?></h1>
			                <div class="text-right text-bold" style="margin-top:5px"><?php echo lang('Different devices')?></div>
			            </div>

			            <div class="panel-body">

			            	<div class="panel-group panel-group-lists">

				            	<div class="panel">

				                	<div class="panel-heading">

				                		<?php if( $total_devices > 2) { ?>

					                		<?php for($i = 0; $i <= 1; $i++) { ?>
					             			<div class="panel-title">
					             				<a href="javascript:void(0)">
					                    		<span><?php echo get_value($devices[$i], 'device_name') ?> <?php echo get_value($devices[$i], 'device_version') ?></span>
					                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($devices[$i], 'count_access') ?> <?php echo lang('access') ?></span>
					                    		</a>
					                  		</div>
					                  		<?php } ?>

				                  			<div class="devices-container" style="display: none">

				                  				<?php for($i = 2; $i < $total_devices; $i++) { ?>
						             			<div class="panel-title">
						             				<a href="javascript:void(0)">
						                    		<span><?php echo get_value($devices[$i], 'device_name') ?> <?php echo get_value($devices[$i], 'device_version') ?></span>
						                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($devices[$i], 'count_access') ?> <?php echo lang('access') ?></span>
						                    		</a>
						                  		</div>
					                  			<?php } ?>

				                  			</div>

				                  			<div class="panel-title">
					                  			<h5>
					                  				<a class="see-all-devices" href="javascript:void(0)">
														<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
					                  					<?php echo lang('See all devices') ?>
					                  				</a>
					                  			</h5>
					                  		</div>

				                  		<?php } else { ?>

				                  			<?php foreach ($devices as $device) { ?>

				                  			<div class="panel-title">
					             				<a href="javascript:void(0)">
					                    		<span><?php echo get_value($device, 'device_name') ?> <?php echo get_value($device, 'device_version') ?></span>
					                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($device, 'count_access') ?> <?php echo lang('access') ?></span>
					                    		</a>
					                  		</div>

					                  		<?php } ?>

				                  		<?php } ?>

				                	</div>

				              	</div>

					        </div>

			            </div>

			        </div>

	       		</div>

			</div>

		</div>

	</div>

</div>

<script>

	// =======================
	// trigger to remove error
	// =======================
	$('.error-box a').click(function () {

		// get id
        var id = $(this).attr('id');

        // Confirm this shit
        bootbox.confirm("<?php echo lang('Are you sure to remove the selected error ?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // ajax to remove that shit
			$.enable_loading();

			$.ajax({
	            url: $('#URL_ROOT').val() + '/app-log/save/error/delete',
	            context: document.body,
	            data : { 'id_log' : id },
	            cache: false,
	            type: 'POST',

	            complete : function (response) {

	            	$.disable_loading();

	            	// Parse json to check errors
	            	json = $.parseJSON(response.responseText);

	            	// Check return
	            	if( ! json.return) {

	            		// nice alert error
	            		bootbox.alert(json.error);
	            		return false;
	            	}

                	// update badge counter
                	var badge = $('#' + id).closest('.panel').find('.badge').html() - 1;
                	$('#' + id).closest('.panel').find('.badge').html( badge );

                	// update general counter
                	$('#count-errors').html($('#count-errors').html() - 1);

                	// when no errors get reached
                	if(badge <= 0) {
						$('#' + id).closest('.panel').find('.badge').removeClass('badge-danger badge-warning').addClass('badge-success');
                		$('#' + id).closest('.panel-body').find('p').toggleClass('hidden show');
                		$('#' + id).closest('.error-content').toggleClass('hidden show');
                	}

                	// procced with no errors, remove error from div
                	$('#' + id).closest('.error-box').remove();

	            }
	        });

        });
	});

	// ===============
	// see all devices
	// ===============
	$('.see-all-devices').click(function () {
		if( $('.devices-container').is(':visible') ) {
			$(this).find('i').toggleClass('fa-arrow-circle-up fa-arrow-circle-right');
			$('.devices-container').slideUp(300);
		} else {
			$(this).find('i').toggleClass('fa-arrow-circle-up fa-arrow-circle-right');
			$('.devices-container').slideDown(300);
		}
	});

	// ================
	// see all browsers
	// ================
	$('.see-all-browsers').click(function () {
		if( $('.browsers-container').is(':visible') ) {
			$(this).find('i').toggleClass('fa-arrow-circle-up fa-arrow-circle-right');
			$('.browsers-container').slideUp(300);
		} else {
			$(this).find('i').toggleClass('fa-arrow-circle-up fa-arrow-circle-right');
			$('.browsers-container').slideDown(300);
		}
	});

</script>

<style>
	.custom-panels .panel-heading i {
	    font-size: 65px;
	    margin-left: 0
	}

	.custom-panels h1 {
	    font-size: 60px;
	    margin: 0;
	}

	.custom-panels h4 {
	    margin: 0;
	}

	#list-errors {
	    display: none
	}

	#list-errors div.list-group {
	    margin:10px 0 0;
	    max-height: 250px;
	    overflow-y: scroll;
	}

	.panel-list .list-group {
		margin-bottom: 0
	}

	.panel-list .panel-body {
	    padding: 0;
	}

	.panel-list .panel-body .list-group .list-group-item {
	    border-radius: 0;
	    border-left: 0;
	    border-right: 0;
	    border-bottom: 0;
	}

	.panel-group {
		border: none;
		margin-bottom: 0
	}

	.panel-group .panel {
		border-top: none;
		border-left: none;
		border-right: none;
	}

	.panel-group-lists .panel,
	.panel-group-lists .panel .panel-body {
		box-shadow: none !important;
	}

	.panel-group-lists .panel-title a:hover {
		color: #4fc1e9;
	}

	.panel-group-lists .panel-title a {
		color: #3bafda;
	}

	p small {
		word-break: break-all;
	}

	.error-container {
	    max-height: 180px;
	    overflow-y: scroll;
	    border-bottom: 1px dotted #e8e8e8;
	}

	.panel-group-lists .panel-heading a {
		color: inherit;
	}

	.panel-group-lists .panel-heading a:hover {
		color: inherit;
		cursor: default;
	}

	.panel-group-lists .panel-heading .panel-title {
		border-bottom: 1px solid #e8e8e8;
	}

	.panel-group-lists .panel-heading .panel-title:last-child {
		border-bottom: 1px solid transparent;
	}

	.panel-body-errors .panel-group-lists .panel-heading .panel-title:last-child {
		border-bottom: 0;
	}

	.panel-group-lists .panel-heading .panel-title i {
		font-size: inherit;
	}

	.panel-group-lists .panel-heading .panel-title h5 {
		margin-bottom: 0;
	}

	.panel-heading .panel-title h5 a {
		color: #3bafda;
	}

	.panel-heading .panel-title h5 a:hover {
		color: #4fc1e9;
		cursor: pointer;
	}

	.panel-body-errors .panel-heading a {
		color: #3bafda;
	}

	.panel-body-errors .panel-heading a:hover {
		color: #4fc1e9;
		cursor: pointer;
	}

	.panel-body-modules .list-group h3 {
		color: #8cc152;
		margin-bottom: 3px;
	}

	.panel-body-modules .list-group p.text-success {
		color: #8cc152;
	}

</style>
