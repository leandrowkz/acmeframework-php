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

		<div class="col-sm-7 col-md-7 col-lg-7">

			<div class="panel panel-default panel-custom">

				<div class="panel-heading">
	                <i class="fa fa-cubes"></i>
	                <h1 class="pull-right"><?php echo count($modules) ?></h1>
	                <div class="text-right text-bold"style="margin-top:5px"><?php echo lang('Application modules')?></div>
	            </div>

				<ul class="list-group modules">

					<li class="list-group-item">
						<a href="<?php echo URL_ROOT ?>/app-module-maker" class="text-success" title="<?php echo lang('Click to go') ?>">
			            	<h3 class="text-success">
			            		<?php echo lang('New module') ?>
			            		<i class="fa fa-fw fa-plus-circle pull-right"></i>
			            	</h3>
			            	<p class="list-group-item-text text-success"><?php echo lang('Create a new module with Module Maker') ?></p>
			            </a>
			        </li>

					<?php foreach ($modules as $module) : ?>
					<li class="list-group-item">
			        	<a href="<?php echo URL_ROOT ?>/<?php echo strtolower(str_replace('_', '-', get_value($module, 'controller')))?>" title="<?php echo lang('Click to go') ?>">
			        		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
			            	<h5 class="text-bold"><?php echo lang(get_value($module, 'label')) ?></h5>
			            	<p class="list-group-item-text"><?php echo lang(get_value($module, 'description')) ?></p>
			            </a>
			        </li>
			        <?php endforeach ?>

			    </ul>

			</div>

		</div>

		<div class="col-sm-5 col-md-5 col-lg-5">

			<div class="row">

				<div class="col-sm-12 col-md-12 col-lg-12">

					<div class="panel panel-danger panel-custom">

						<?php
						$total_general_errors = count($general_errors);
						$total_php_errors = count($php_errors);
						$total_db_errors = count($db_errors);
						$total_errors = $total_general_errors + $total_php_errors + $total_db_errors;
						?>

			            <div class="panel-heading">
			                <i class="fa fa-bug"></i>
			                <h1 class="pull-right" id="count-errors"><?php echo $total_errors ?></h1>
			                <div class="text-right text-bold"style="margin-top:5px"><?php echo lang('Errors found')?></div>
			            </div>

			            <ul class="list-group">

							<!-- GENERAL ERRORS -->
			            	<li class="list-group-item">
		                		<?php
		                		if ($total_general_errors >= 100)
		                			$badge = 'danger';
		                		elseif ($total_general_errors > 0)
		                			$badge = 'warning';
		                		else
		                			$badge = 'success';
		                		?>

		                    	<a data-toggle="collapse" data-parent="#errors-list" href="#general-errors" class="collapsed text-bold">
		                    		<span><?php echo lang('General errors') ?></span>
		                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($general_errors)?></span>
		                  		</a>

			                	<div id="general-errors" class="error-box-content collapse" style="height: 0px;">
		                  			<?php
		                  			if ($total_general_errors > 0) {
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
			            	</li>

			            	<!-- PHP ERRRORS -->
			            	<li class="list-group-item">
			            		<?php
		                		if ($total_php_errors >= 100)
		                			$badge = 'danger';
		                		elseif ($total_php_errors > 0)
		                			$badge = 'warning';
		                		else
		                			$badge = 'success';
		                		?>

		                    	<a data-toggle="collapse" data-parent="#errors-list" href="#php-errors" class="collapsed text-bold">
		                    		<span><?php echo lang('PHP errors') ?></span>
		                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($php_errors)?></span>
	                    		</a>

			                	<div id="php-errors" class="error-box-content collapse" style="height: 0px;">
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
			            	</li>

			            	<!-- DATABASE ERRRORS -->
			            	<li class="list-group-item">
			            		<?php
		                		if ($total_db_errors >= 100)
		                			$badge = 'danger';
		                		elseif ($total_db_errors > 0)
		                			$badge = 'warning';
		                		else
		                			$badge = 'success';
		                		?>

	                    		<a data-toggle="collapse" data-parent="#errors-list" href="#database-errors" class="collapsed text-bold">
		                    		<span><?php echo lang('Database errors') ?></span>
		                    		<span class="pull-right badge badge-<?php echo $badge ?>"><?php echo count($db_errors)?></span>
		                  		</a>

			                	<div id="database-errors" class="error-box-content collapse" style="height: 0px;">
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
			            	</li>
			            </ul>
			        </div>
				</div>

				<div class="col-sm-12 col-md-12 col-lg-12">

					<!-- PANEL BROWSERS -->
			        <div class="panel panel-default panel-custom">

						<?php $total_browsers = count($browsers); ?>

			            <div class="panel-heading">
			                <i class="fa fa-compass"></i>
			                <h1 class="pull-right"><?php echo $total_browsers ?></h1>
			                <div class="text-right text-bold" style="margin-top:5px"><?php echo lang('Different browsers')?></div>
			            </div>

			            <ul class="list-group">

	                		<?php if ($total_browsers > 2) : ?>

		                		<?php for ($i = 0; $i <= 1; $i++) : ?>
		             			<li class="list-group-item">
		                    		<span><?php echo get_value($browsers[$i], 'browser_name') ?> <?php echo get_value($browsers[$i], 'browser_version') ?></span>
		                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($browsers[$i], 'count_access') ?> <?php echo lang('access') ?></span>
		                  		</li>
		                  		<?php endfor ?>

	                  			<div class="browsers-container" style="display: none">
	                  				<?php for ($i = 2; $i < $total_browsers; $i++) : ?>
			             			<li class="list-group-item">
			                    		<span><?php echo get_value($browsers[$i], 'browser_name') ?> <?php echo get_value($browsers[$i], 'browser_version') ?></span>
			                    		<span class="pull-right badge badge-normal"><?php echo get_value($browsers[$i], 'count_access') ?> <?php echo lang('access') ?></span>
			                  		</li>
		                  			<?php endfor ?>
	                  			</div>

	                  			<li class="list-group-item">
		                  			<h5 class="text-bold" style="margin: 0">
		                  				<a class="see-all-browsers" href="javascript:void(0)">
											<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
		                  					<?php echo lang('See all browsers') ?>
		                  				</a>
		                  			</h5>
		                  		</li>

	                  		<?php else : ?>

	                  			<?php foreach ($browsers as $browser) : ?>
	                  			<li class="list-group-item">
		                    		<span><?php echo get_value($browser, 'browser_name') ?> <?php echo get_value($browser, 'browser_version') ?></span>
		                    		<span class="pull-right badge badge-normal"><?php echo get_value($browser, 'count_access') ?> <?php echo lang('access') ?></span>
		                  		</li>
		                  		<?php endforeach ?>

	                  		<?php endif ?>

						</ul>
			        </div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">

					<!-- PANEL DEVICES -->
					<div class="panel panel-default panel-custom">

						<?php $total_devices = count($devices); ?>

			            <div class="panel-heading">
			                <i class="fa fa-tablet"></i>
			                <h1 class="pull-right"><?php echo $total_devices ?></h1>
			                <div class="text-right text-bold" style="margin-top:5px"><?php echo lang('Different devices')?></div>
			            </div>

			            <ul class="list-group">

			            	<?php if ($total_devices > 2) : ?>

		                		<?php for ($i = 0; $i <= 1; $i++) : ?>
		             			<li class="list-group-item">
		                    		<span><?php echo get_value($devices[$i], 'device_name') ?> <?php echo get_value($devices[$i], 'device_version') ?></span>
		                    		<span class="pull-right badge badge-normal"><?php echo get_value($devices[$i], 'count_access') ?> <?php echo lang('access') ?></span>
		                  		</li>
		                  		<?php endfor ?>

	                  			<div class="devices-container" style="display: none">
	                  				<?php for ($i = 2; $i < $total_devices; $i++) : ?>
			             			<li class="list-group-item">
			                    		<span><?php echo get_value($devices[$i], 'device_name') ?> <?php echo get_value($devices[$i], 'device_version') ?></span>
			                    		<span class="pull-right badge badge-normal"><?php echo get_value($devices[$i], 'count_access') ?> <?php echo lang('access') ?></span>
			                  		</li>
		                  			<?php endfor ?>
	                  			</div>

	                  			<li class="list-group-item">
	                  				<h5 class="text-bold" style="margin: 0">
	                  					<a class="see-all-devices text-bold" href="javascript:void(0)">
											<i class="fa fa-fw fa-arrow-circle-right pull-right"></i>
	                  						<?php echo lang('See all devices') ?>
	                  					</a>
	                  				</h5>
		                  		</li>

	                  		<?php else: ?>

	                  			<?php foreach ($devices as $device) : ?>
	                  			<li class="list-group-item">
		                    		<span><?php echo get_value($device, 'device_name') ?> <?php echo get_value($device, 'device_version') ?></span>
		                    		<span class="pull-right badge badge-normal ?>"><?php echo get_value($device, 'count_access') ?> <?php echo lang('access') ?></span>
		                  		</li>
		                  		<?php endforeach ?>

	                  		<?php endif; ?>

	                  	</ul>

			        </div>

	       		</div>

			</div>

		</div>

	</div>

</div>

<script>

	// =======================
	// Trigger to remove error
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
                	var badge = $('#' + id).closest('.list-group-item').find('.badge').html() - 1;
                	$('#' + id).closest('.list-group-item').find('.badge').html( badge );

                	// update general counter
                	$('#count-errors').html($('#count-errors').html() - 1);

                	// when no errors get reached
                	if (badge <= 0) {
						$('#' + id).closest('.list-group-item').find('.badge').removeClass('badge-danger badge-warning').addClass('badge-success');
                		$('#' + id).closest('.error-box-content').find('p').toggleClass('hidden show');
                		$('#' + id).closest('.error-content').toggleClass('hidden show');
                	}

                	// procced with no errors, remove error from div
                	$('#' + id).closest('.error-box').remove();

	            }
	        });

        });
	});

	// ===============
	// See all devices
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
	// See all browsers
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

 	/* Custom panels (default to all panels) */
	.panel-custom .panel-heading i { font-size: 65px; margin-left: 0 }
	.panel-custom .panel-heading h1 { font-size: 60px; margin: 0; font-weight: bold }
	.panel-custom .panel-heading h4 { margin: 0; font-weight: bold; }
	.panel-custom .list-group { border-bottom: 0; }

	/* Error panel */
	.panel-custom .error-box-content { margin: 5px 0 0; }
	.panel-custom .error-container { max-height: 150px !important; overflow-y: auto; white-space: nowrap; border-bottom: 1px solid #ddd; padding: 0 0 10px; }

	/* Modules panel */
	.panel-custom .modules a,
	.panel-custom .modules a:hover { color: inherit; }

	/* Browsers panel */
	.panel-custom .browsers-container .list-group-item:first-child { border-top-width: 1px; }

	/* Browsers panel */
	.panel-custom .devices-container .list-group-item:first-child { border-top-width: 1px; }

</style>
