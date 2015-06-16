<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo APP_NAME ?></title>

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/jquery-2.1.3.min.js"></script>
    <script src="<?php echo URL_CSS ?>/bootstrap/js/bootstrap.min.js"></script>

    <!-- App Scripts - Include with every page -->
    <script src="<?php echo URL_JS ?>/app-functions.js"></script>

    <!-- CSS Assets - Include with every page -->
    <link href="<?php echo URL_CSS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_CSS ?>/bootflat/css/bootflat.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL_CSS ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Plugins Section -->

    <!-- Bootbox Plugin -->
    <script src="<?php echo URL_JS ?>/bootbox/bootbox.min.js"></script>

    <!-- MagicSuggest Plugin -->
    <link href="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.js"></script>

    <!-- ValidationEngine Plugin -->
    <link href="<?php echo URL_JS ?>/validationEngine/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo URL_JS ?>/validationEngine/js/jquery.validationEngine.js"></script>
    <script src="<?php echo URL_JS ?>/validationEngine/js/languages/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

    <!-- Meiomask Plugin -->
    <script src="<?php echo URL_JS ?>/meiomask/meiomask.min.js"></script>

    <!-- Plugins Section -->

    <!-- CSS Template - Override other styles -->
    <link href="<?php echo URL_TEMPLATE ?>/styles.css" rel="stylesheet" type="text/css" />

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

							// Get language
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
                                    <i class="fa fa-fw text-danger <?php echo $lang == 'en_US' ? 'fa-dot-circle-o' : 'fa-circle-o'; ?>"></i>
                                    <?php echo lang('English') ?>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" class="change-language" id="pt_BR">
                                    <i class="fa fa-fw text-danger <?php echo $lang == 'pt_BR' ? 'fa-dot-circle-o' : 'fa-circle-o'; ?>"></i>
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

							<div class="step">
								1
								<h3 class="text-success" style="margin: -25px 0 0 30px"><i class="fa fa-fw fa-check-circle"></i></h3>
							</div>

							<div class="step-text"><?php echo lang('System requirements') ?></div>

						</center>

					</div>

					<div class="col-xs-4 col-sm-4 step-two">

						<center>

							<div class="step done">2</div>

							<div class="step-text done"><?php echo lang('New application info') ?></div>

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

					<?php if ($app_logo !== true) { ?>
					<div class="row">

						<div class="col-sm-12">

							<?php echo message('danger', lang('Warning!'), lang('It was not possible upload your logo file: ') . $app_logo . '<br /><br />' . lang('Try to upload it again.'), true) ?>

						</div>

					</div>
					<?php } ?>

					<div class="col-sm-6 col-md-6">

						<form action="<?php echo URL_ROOT ?>/app-installer/new-app-info/true" method="post" enctype="multipart/form-data">

							<input type="hidden" name="db_driver" value="<?php echo get_value($post, 'db_driver')?>" />

							<input type="hidden" name="db_host" value="<?php echo get_value($post, 'db_host')?>" />

							<input type="hidden" name="db_port" value="<?php echo get_value($post, 'db_port')?>" />

							<input type="hidden" name="db_user" value="<?php echo get_value($post, 'db_user')?>" />

							<input type="hidden" name="db_pass" value="<?php echo get_value($post, 'db_pass')?>" />

							<input type="hidden" name="db_database" value="<?php echo get_value($post, 'db_database')?>" />

							<h3 style="margin: 0 0 30px 0"><?php echo lang('Application info') ?></h3>

							<div class="form-group">
				                <label>
				                	<?php echo lang('Application name') ?>*
				                </label>
				                <input type="text" name="app_name" id="app_name" class="form-control validate[required]" autofocus value="<?php echo get_value($post, 'app_name') ?>" />
				            </div>

							<div class="form-group">
				                <label>
				                	<?php echo lang('Default language') ?>*
				                </label>
				                <select name="app_language" id="app_language" class="form-control validate[required]">
				                	<option value="en_US" <?php echo get_value($post, 'app_language') == 'en_US' ? 'selected="selected"' : '' ?>><?php echo lang('English') ?></option>
				                	<option value="pt_BR" <?php echo get_value($post, 'app_language') == 'pt_BR' ? 'selected="selected"' : '' ?>><?php echo lang('Brazilian Portuguese') ?></option>
				                </select>
				            </div>

				            <div class="form-group">
				                <label>
				                	<?php echo lang('Application logo') ?>
				                	<small class="text-muted">// <?php echo lang('PNG file with dimensions: 120 x 20') ?></small>
				                </label>
				                <input type="file" name="app_logo" id="app_logo" />
				            </div>

				            <h3 style="margin: 50px 0 30px 0">
				            	<?php echo lang('User ROOT') ?>
				            	<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('One single user with special permissions will be created with the following information') ?>"></i>
				            </h3>

				            <div class="form-group">
				                <label>
				                	<?php echo lang('Name') ?>*
				                </label>
				                <input type="text" name="user_name" id="user_name" class="form-control validate[required]" value="<?php echo get_value($post, 'user_name') ?>" />
				            </div>

				             <div class="form-group">
				                <label>
				                	<?php echo lang('Email') ?>*
									<i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('The new application will be accessible by using this email') ?>"></i>
				                </label>
				                <input type="text" name="email" id="email" class="form-control validate[required,custom[email]]" value="<?php echo get_value($post, 'email') ?>" />
				            </div>

				            <div class="row">

				            	<div class="col-sm-6">

						            <div class="form-group">
						                <label>
						                	<?php echo lang('Password') ?>*
						                </label>
						                <input type="password" name="user_pass" id="user_pass" class="form-control validate[required,minSize[6]]" value="<?php echo get_value($post, 'user_pass') ?>" />
						            </div>

						        </div>

						        <div class="col-sm-6">

						        	<div class="form-group">
						                <label>
						                	<?php echo lang('Confirm password') ?>*
						                </label>
						                <input type="password" name="pass_confirm" id="pass_confirm" class="form-control validate[required,minSize[6],equals[user_pass]]" value="<?php echo get_value($post, 'pass_confirm') ?>" />
						            </div>

						        </div>

						    </div>

						    <div class="form-footer">

							    <button type="submit" class="btn btn-lg btn-success">
					    			<?php echo lang('Create application') ?>
					    			<i class="fa fa-fw fa-arrow-circle-right"></i>
					    		</button>

					    		<?php echo lang('or') ?>

					    		&nbsp;
					    		&nbsp;

					    		<a href="javascript:void(0)" class="btn btn-md btn-default back-step">
					    			<?php echo lang('Back') ?>
					    			<i class="fa fa-fw fa-arrow-circle-left"></i>
					    		</a>

				    		</div>

				    	</form>

				    </div>

				</div>

			</div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Loading layer -->
    <div class="loading-layer"></div>
    <div class="loading-box"><h4><i class="fa fa-fw fa-circle-o-notch fa-spin"></i> <?php echo lang('Loading')?></h4></div>

	<style>

		.list-group-item-heading { font-size: 16px; margin: 2px 0 4px 0px; }
		.list-group-item-text { margin-left: 25px; }
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

	<script>

		// ==================================
		// Put all content inside a container
		// ==================================
    	$.container_html();

    	// ========
    	// Tooltips
    	// ========
    	$('body').tooltip({
    		selector : '[data-toggle="tooltip"]',
    		container : 'body'
    	});

	    // ==================================
    	// Change action and return to step 1
    	// ==================================
	    $('.back-step').on('click', function () {

	    	$("form").validationEngine('detach');

	    	$(this).closest('form').attr('action', $('#URL_ROOT').val() + '/app-installer/system-requirements').submit();
	    });

	    // ============================
	    // Set validations to all forms
	    // ============================
	    $('form').validationEngine('attach', {

	        promptPosition : "bottomRight",
	        onValidationComplete: function (form, status) {
	        	if( ! status )
	        		return false;

	        	$.enable_loading();
	        	return true;
	        }
	    });

	    // ===============================
    	// Reposition the alerts from form
    	// ===============================
    	$( window ).resize( function () {
        	$("form").validationEngine('updatePromptsPosition');
    	});

    	// =================
	    // Language callback
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
		        url: $('#URL_ROOT').val() + '/app-installer/change-language/' + language,
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

</body>

</html>
