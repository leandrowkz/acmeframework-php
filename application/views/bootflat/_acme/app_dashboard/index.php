<div class="module-header">

	<div class="row">

		<div class="col-xs-12">
			<h1><?php echo lang($this->label) ?> 
			<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
			</h1>
		</div>

	</div>

</div>

<div class="module-body">

	<div class="row">
	
		<div class="col-md-5 col-lg-5">
			
			<div class="panel panel-default panel-list">

				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-12 col-lg-7" id="title-modules-override">
							<h4 style="margin:10px 0"><?php echo lang('Módulos da aplicação')?></h4>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-12 col-lg-5" id="add-module-override">
							<a href="<?php echo URL_ROOT ?>/app_module_maker" class="btn btn-success btn-block btn-md" style="white-space:normal"><?php echo lang('Novo módulo')?> <i class="fa fa-plus-circle fa-fw"></i></a>
						</div>
					</div>
				</div>

				<div class="panel-body">
					
					<div class="list-group" style="border: none">
						<?php foreach($modules as $module) { ?>
			        	<a href="<?php echo URL_ROOT ?>/<?php echo get_value($module, 'controller')?>" class="list-group-item" title="<?php echo lang('Clique para ir') ?>">
			        		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
			            	<h5 class="list-group-item-heading"><?php echo get_value($module, 'label') ?></h5>
			            	<p class="list-group-item-text"><?php echo get_value($module, 'description')?></p>
			            </a>
			            <?php } ?>
			        </div>

			    </div>

			</div>

		</div>
		
		<div class="col-md-7 col-lg-7">

			<div class="row">

				<div class="col-sm-6 col-md-12 col-lg-6 custom-panels">

					<div class="panel panel-primary panel-list">

			            <div class="panel-heading">
			                <i class="fa fa-tablet"></i>
			                <h1 class="pull-right"><?php echo count($devices)?></h1>
			                <div class="text-right" style="margin-top:5px"><?php echo lang('Different devices')?></div>
			            </div>

			            <div class="panel-body">

			            	<div class="list-group" style="border: none">

				                <div class="list-group-item" style="padding: 15px">
				                	<span class="pull-right"><i id="show-devices-arrow" class="fa fa-arrow-circle-right fa-fw"></i></span>
				                	<a href="javascript:void(0)" id="show-devices"><?php echo lang('See devices') ?></a>
				                </div>

				                <div id="list-devices" style="display: none">
			                	<?php foreach($devices as $device) {?>
				                	<div class="list-group-item">
				                		<span class="text-muted pull-right"><?php echo get_value($device, 'count_access'); ?> <?php echo lang('access')?></span>
				                		<span><?php echo get_value($device, 'device_name'); ?></span>
				                	</div>
			                	<?php } ?>
			                	</div>

			            	</div>

			            </div>

			        </div>
			    
				</div>

				<?php
				$total_general_errors = count($general_errors);
				$total_php_errors = count($php_errors);
				$total_db_errors = count($db_errors);
				$total_errors = $total_general_errors + $total_php_errors + $total_db_errors;
				?>

				<div class="col-sm-6 col-md-12 col-lg-6 custom-panels">

					<div class="panel panel-list panel-danger">
			            
			            <div class="panel-heading">
			                <i class="fa fa-bug"></i>
			                <h1 class="pull-right" id="count-errors"><?php echo $total_errors ?></h1>
			                <div class="text-right"style="margin-top:5px"><?php echo lang('Errors found')?></div>
			            </div>

			            <div class="panel-body">

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
				                  				<a href="<?php echo URL_ROOT ?>/app_log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right"></i>
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
				                  				<a href="<?php echo URL_ROOT ?>/app_log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right"></i>
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
				                  				<a href="<?php echo URL_ROOT ?>/app_log">
				                  					<?php echo lang('See all errors')?>
				                  					<i class="fa fa-fw fa-arrow-circle-right"></i>
				                  				</a>
				                  			</h5>

				                  		</div>
				                	</div>

				              	</div>

					        </div>

			            </div>

			        </div>

				</div>

			</div>

			<div class="row" style="margin-top:10px">
				<div class="col-md-12 custom-panels">
					<div class="well" STYLE="height:400px">
			            <h4 class="text-center"><?php echo lang('Navegadores e acessos')?></h4>
						<div id="browser-chart"></div>
			        </div>
				</div>
			</div>

		</div>

	</div>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/morris/morris-0.4.3.min" />

<script src="<?php echo URL_JS ?>/plugins/morris/raphael-2.1.0.min.js"></script>

<script src="<?php echo URL_JS ?>/plugins/morris/morris.js"></script>

<script>
	
	// trigger to remove error
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
	            url: $('#URL_ROOT').val() + '/app_log/save/error/delete',
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

	// slide devices
	$('#show-devices, #show-devices-arrow').click(function () {
		if( $('#list-devices').is(':visible') ) {
			$('#show-devices-arrow').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-right');
			$('#list-devices').slideUp(300);
		} else {
			$('#show-devices-arrow').removeClass('fa-arrow-circle-right').addClass('fa-arrow-circle-down');
			$('#list-devices').slideDown(300);
		}
	});

	// graph browsers
	Morris.Bar({
    	element: 'browser-chart',
    	data: <?php echo json_encode(array_change_key_case_recursive($browsers, CASE_LOWER)) ?>,
    	xkey: 'browser_name',
    	ykeys: ['count_access'],
    	labels: ['Acessos'],
    	barRatio: 0.4,
    	xLabelAngle: 35,
    	hideHover: 'auto',
    	pointSize: 2,
        resize: true
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

	#list-errors div.list-group-item div {
	    overflow: hidden;
	    text-overflow: ellipsis;
	}

	.panel-list .panel-body {
	    padding: 0;
	}

	.panel-list .panel-body .list-group {
	    margin: 0;
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

</style>