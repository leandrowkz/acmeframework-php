<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo APP_NAME ?></title>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/jquery-1.10.2.js"></script>
    <script src="<?php echo URL_JS ?>/bootstrap.js"></script>
    <script src="<?php echo URL_JS ?>/plugins/bootbox/bootbox.min.js"></script>

    <!-- App Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/app-functions.js"></script>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <!-- App CSS - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootflat.css" rel="stylesheet">
    <link href="<?php echo URL_CSS ?>/app-styles.css" rel="stylesheet">

</head>

<body>

<?php echo app_settings_inputs(); ?>
    
    <div class="wrapper">

        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            
            <div class="navbar-header">
                
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- brand/logo -->
                <div class="navbar-brand"><img src="<?php echo URL_IMG ?>/logo-acme.png" /></div>

            </div>
            
            <div class="navbar-collapse collapse">
                
                <ul class="nav navbar-nav">
                    
                    <li><a href="http://www.acmeframework.org/docs" target="_blank"><i class="fa fa-fw fa-question-circle"></i> <?php echo lang('Help') ?></a></li>

                    <li class="dropdown">
						<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-fw fa-globe"></i>
							
							<?php 
							
							// get language
							$lang = $this->session->userdata('language');

							// Write language name
							switch ($lang) {
								
								case 'en_US':
								default:
									echo lang('English');
								break;
								
								case 'pt_BR':
									echo lang('Brazilian Portuguese');
								break;
							}

							?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
					        	<a href="javascript:void(0)" class="change-language" id="en_US">
					        		<input type="radio" name="language" <?php echo $lang == 'en_US' ? 'checked="checked"' : ''; ?> />
					        		<?php echo lang('English') ?>
					        	</a>
					        </li>
					        <li>
					            <a href="javascript:void(0)" class="change-language" id="pt_BR">
					            	<input type="radio" name="language" <?php echo $lang == 'pt_BR' ? 'checked="checked"' : ''; ?> />
					            	<?php echo lang('Brazilian Portuguese') ?>
					            </a>
					        </li>
						</ul>
					</li>

                </ul>                
        
            </div>

        </div>

        <div id="page-wrapper">

			<div class="module-header">

				<div class="row">

					<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<h1>
							<?php echo lang('Installation') ?>
							<span><i class="fa fa-fw fa-magic"></i></span>
							<small>// <?php echo lang('Create a new application') ?></small>
						</h1>
					</div>

				</div>

			</div>

			<div class="module-body">

				<div class="row">

					<div class="col-xs-12 col-sm-12">
						
						<div class="line-steps"></div>

					</div>

				</div>
				
				<div class="row">

					<div class="col-xs-4 col-sm-4 step-one">

						<center>

							<div class="step done">1</div>

							<div class="step-text done"><?php echo lang('System requirements') ?></div>

						</center>

					</div>

					<div class="col-xs-4 col-sm-4 step-two">

						<center>

							<div class="step current">2</div>

							<div class="step-text"><?php echo lang('New application info') ?></div>

						</center>

					</div>

					<div class="col-xs-4 col-sm-4 step-three">

						<center>

							<div class="step">3</div>

							<div class="step-text"><?php echo lang('Summary') ?></div>

						</center>

					</div>

				</div>

				<div class="row" style="margin-top: 30px">

					<div class="col-sm-12">

						<ul class="list-group">

							<?php
							$class = $path_permissions ? 'text-success' : 'text-danger';
							$img = $path_permissions ? 'fa-check-circle' : 'fa-exclamation-circle';
							if ( $path_permissions)
								$label = lang('All path permissions are OK');
							else {
								$label = '
								<span class="text-danger">' .
									lang('Check read and write permissions for the following paths:') .
									'<br />&bull;&nbsp;application/core
									 <br />&bull;&nbsp;application/config
								</span>';
							}
							?>

							<li class="list-group-item">
								<h3 class="pull-left <?php echo $class ?>"><i class="fa fa-fw <?php echo $img ?>"></i></h3>
			    				<h5 class="list-group-item-heading"><?php echo lang('Path permissions') ?></h5>
			    				<div class="list-group-item-text">
			    					<small class="text-muted"><?php echo $label ?></small>
			    				</div>
			    			</li>

			    			<?php
								$class = $php_version ? 'text-success' : 'text-danger';
								$img = $php_version ? 'fa-check-circle' : 'fa-exclamation-circle';
								$label = lang('Your version is ') . PHP_VERSION;
								$label = $php_version ? $label : '<span class="text-danger">' . $label . '</span>';
							?>

			    			<li class="list-group-item">
								<h3 class="pull-left <?php echo $class ?>"><i class="fa fa-fw <?php echo $img ?>"></i></h3>
			    				<h5 class="list-group-item-heading"><?php echo lang('PHP 5.3.5 or superior') ?></h5>
			    				<div class="list-group-item-text">
			    					<small class="text-muted"><?php echo $label ?></small>
			    				</div>
			    			</li>

			    			<?php
								if (get_value($params, 'db_driver') == '') {
									$class = 'text-primary';
									$img = 'fa-question-circle';
								} else {
									$class = $php_database_extension ? 'text-success' : 'text-danger';
									$img = $php_database_extension ? 'fa-check-circle' : 'fa-exclamation-circle';
								}
							?>

			    			<li class="list-group-item">
								<h3 class="pull-left <?php echo $class ?>"><i class="fa fa-fw <?php echo $img ?>"></i></h3>
			    				<h5 class="list-group-item-heading"><?php echo lang('PHP database driver') ?></h5>
			    				<div class="list-group-item-text">
			    					
			    					<form action="<?php echo URL_ROOT ?>/app_installer/system_requirements" name="send_db_driver" class="send-db-driver" method="post">
			    					
				    					<div class="checkbox" style="margin-top: 10px">
								            <label>
								                <input type="radio" name="db_driver" value="mysql" <?php echo strtolower(get_value($params, 'db_driver')) == 'mysql' ? 'checked="checked"' : ''; ?>> MySQL
								            </label>
								        </div>

								        <div class="checkbox">
								            <label>
								                <input type="radio" name="db_driver" value="pgsql" <?php echo strtolower(get_value($params, 'db_driver')) == 'pgsql' ? 'checked="checked"' : ''; ?>> PostgreSQL
								            </label>
								        </div>

								        <div class="checkbox">
								            <label>
								                <input type="radio" name="db_driver" value="oci8" <?php echo strtolower(get_value($params, 'db_driver')) == 'oci8' ? 'checked="checked"' : ''; ?>> 
								                Oracle
								                <?php if (strtolower(get_value($params, 'db_driver')) == 'oci8' ) {?>
								                <small class="oci8-description"><strong>// <?php echo lang('Buy ACME Framework for Oracle databases for only US$ 29,99') ?></strong> | <a href="http://www.acmeframework.org/oracle" target="_blank"><?php echo lang('See details') ?></a></small>
								                <?php } ?>
								            </label>
								        </div>

			    					</form>

			    				</div>
			    			</li>

			    			<?php
								if (get_value($params, 'db_driver') == '' || strtolower(get_value($params, 'db_driver')) == 'oci8' ) {
									$class = 'text-primary';
									$img = 'fa-question-circle';
									$label = lang('Select a database driver first');
									$display = 'hidden';
								} 

								elseif (get_value($params, 'db_host') == '' 
										|| get_value($params, 'db_port') == ''
										|| get_value($params, 'db_database') == ''
										|| get_value($params, 'db_user') == '') {
									$class = 'text-primary';
									$img = 'fa-question-circle';
									$label = lang('Fill settings for driver') . ': ' . get_value($params, 'db_driver') ;
									$display = '';
								} 

								else {
									$class = $database_server === true ? 'text-success' : 'text-danger';
									$img = $database_server === true ? 'fa-check-circle' : 'fa-exclamation-circle';
									$label = $database_server === true ? lang('All settings are OK') . ' | <a href="javascript:void(0)" class="show-db-params">' . lang('See details') . '</a>' : '<span class="text-danger">' . $database_server . '<span>';
									$display = $database_server === true ? 'hidden' : '';
								}
							?>

			    			<li class="list-group-item">
								<h3 class="pull-left <?php echo $class ?>"><i class="fa fa-fw <?php echo $img ?>"></i></h3>
			    				<h5 class="list-group-item-heading"><?php echo lang('Database server') ?></h5>
			    				<div class="list-group-item-text">
			    					
			    					<small class="text-muted"><?php echo $label ?></small>
			    					
			    					<form action="<?php echo URL_ROOT ?>/app_installer/system_requirements" name="db_params" class="db-params <?php echo $display ?>" method="post" style="margin: 15px 0 0">

			    						<input type="hidden" name="db_driver" value="<?php echo get_value($params, 'db_driver') ?>" />

			    						<div class="row">

			    							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3">

					    						<div class="form-group">
									                <label><?php echo lang('Server') ?> : <?php echo lang('port') ?></label>
									                <input type="text" name="db_host" value="<?php echo get_value($params, 'db_host') ?>" class="form-control input-sm" autofocus />
									            </div>

									        </div>

									        <div class="col-xs-4 col-sm-2 col-md-2 col-lg-1">

					    						<div class="form-group">
					    							<div class="pull-left" style="margin: 30px 0 0 -18px"><strong>:</strong></div>
									                <label>&nbsp;</label>
									                <input type="text" name="db_port" value="<?php echo get_value($params, 'db_port') ?>" class="form-control input-sm" />
									            </div>

									        </div>

									    </div>

									    <div class="row">

			    							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3">

					    						<div class="form-group">
									                <label><?php echo lang('Database / schema / service') ?></label>
									                <i class="fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('For Oracle connections use the service name, XE for example')?>"></i>
									                <input type="text" name="db_database" value="<?php echo get_value($params, 'db_database') ?>" class="form-control input-sm" />
									            </div>

									        </div>

								      	</div>

								      	<div class="row">

			    							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3">

					    						<div class="form-group">
									                <label>
									                	<?php echo lang('User') ?>
									                	<i class="fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('The given user must has permissions for SELECT, INSERT, UPDATE and CREATE operations')?>"></i>
									                </label>
									                <input type="text" name="db_user" value="<?php echo get_value($params, 'db_user') ?>" class="form-control input-sm" />
									            </div>

									        </div>

								      	</div>

								      	<div class="row">

			    							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3">

					    						<div class="form-group">
									                <label><?php echo lang('Password') ?></label>
									                <input type="password" name="db_pass" value="<?php echo get_value($params, 'db_pass') ?>" class="form-control input-sm" />
									            </div>

									        </div>

								      	</div>

								      	<div class="row">

			    							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3">

								                <input type="submit" class="btn btn-primary btn-sm" value="<?php echo lang('Test connection') ?>" style="margin-bottom: 5px" />

									        </div>

								      	</div>

			    					</form>

			    				</div>

			    			</li>

			    		</ul>

			    		<?php 
			    			// disable step button
			    			if( $path_permissions
			    				&& $php_version 
			    				&& $php_database_extension
			    				&& $database_server === true ) {
			    				$disabled = '';
			    				$label = '';
			    			} else {
			    				$disabled = 'disabled="disabled"';
			    				$label = '<span class="text-muted">&nbsp;&nbsp;' . lang('You must solve all issues before continue') . '</span>';
			    			}
			    		?>

						<form action="<?php echo URL_ROOT ?>/app_installer/new_app_info" name="step_two" class="step-two" method="post">

							<input type="hidden" name="db_driver" value="<?php echo get_value($params, 'db_driver')?>" />
							
							<input type="hidden" name="db_host" value="<?php echo get_value($params, 'db_host')?>" />
							
							<input type="hidden" name="db_port" value="<?php echo get_value($params, 'db_port')?>" />
							
							<input type="hidden" name="db_user" value="<?php echo get_value($params, 'db_user')?>" />
							
							<input type="hidden" name="db_pass" value="<?php echo get_value($params, 'db_pass')?>" />
							
							<input type="hidden" name="db_database" value="<?php echo get_value($params, 'db_database')?>" />


				    		<button type="submit" class="btn btn-lg btn-primary" <?php echo $disabled ?>>
				    			<?php echo lang('Continue') ?> 
				    			<i class="fa fa-fw fa-arrow-circle-right"></i>
				    		</button>

			    			<?php echo $label ?>

						</form>

				    </div>

				</div>

			</div>
        
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

    <link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/icheck/flat/red.css" />
	<script src="<?php echo URL_JS ?>/plugins/icheck/icheck.min.js"></script>

	<script>

		// =====================
    	// toggle form db params
    	// =====================
    	$('.show-db-params').on('click', function() {
    		$('.db-params').toggleClass('hidden show');
    	});
		
		// ==================================
		// Put all content inside a container
		// ==================================
    	$.container_html();

    	// ========
    	// tooltips
    	// ========
    	$('i[data-toggle="tooltip"]').tooltip({
    		container : 'body'
    	});

    	// =======
    	// ichecks
    	// =======
	    $('input[type="radio"]').iCheck({
	        checkboxClass: 'icheckbox_flat-red',
	        radioClass: 'iradio_flat-red'
	    });

	    // =================
	    // click field radio
	    // =================
	    $('input[type=radio]').on('ifChecked ifUnchecked', function () {
	    	
	    	$('form.send-db-driver').submit();
	    });

	    // =================
	    // language callback
	    // =================
	    $('a.change-language').on('click', function () {
	    	
	    	$.change_language_custom($(this).attr('id'));
	    });

	    // ======================
	    // custom change language
	    // ======================
		$.change_language_custom = function (language) {

		    $.enable_loading();

		    $.ajax({
		        url: $('#URL_ROOT').val() + '/app_installer/change_language/' + language,
		        context: document.body,
		        dataType : 'json',
		        cache: false,
		        type: 'POST',
		        complete : function (data) {
		            
		            window.location.reload();

		        }
		    });
		};

	</script>

	<style>

		.form-group {
			margin-bottom: 20px
		}

		h3.text-success {
			color: #8CC152;
		}

		.list-group-item-heading {
			font-size: 16px;
			margin: 2px 0 4px 0px;
		}

		.list-group-item h3 {
			font-size: 22px;
			margin: -3px 3px 0 0;
		}

		.list-group-item h3 i {
			margin: 0 0 0 -9px;
		}

		.list-group-item-text {
			margin-left: 22px;
		}

		.line-steps {
			height: 7px;
			background-color: #e8e8e8;
			width: 100%;
			margin: 30px 0 0 0;
		}

		.step {
			line-height: 60px;
			vertical-align: middle;
			text-align: center;
			height: 60px;
			width: 60px;
			background-color: #e8e8e8;
			border-radius: 100%;
			color: #999;
			font-size: 20px;
			font-weight: bold;
			margin-top: -34px;
		}

		.step.done {
			color: #fff;
			background-color: #A0D468
		}

		.step-text {
			margin: 10px 0 0 0;
			color: #999;
			font-size: 20px
		}

		.step-text.done {
			color: inherit;
			font-weight: bold;
		}

		/* Large desktops */
		@media(min-width: 1170px) {
		    .step-one {
		    	padding-right: 130px;
		    }

		    .step-three {
		    	padding-left: 130px;
		    }
		}

	</style>

</body>

</html>
