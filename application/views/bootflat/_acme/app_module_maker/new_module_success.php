<div class="module-header">

	<div class="row">

		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<h1>
				<?php echo lang($this->label) ?>
				<span><?php echo image($this->url_img) ?></span>
				<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
			</h1>
		</div>

		<?php if ( count($this->menus) > 0 ) {?>

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

            <div class="btn-group pull-right clearfix">
                
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-align-justify hidden-lg hidden-md"></i> 
                    <div class="hidden-xs hidden-sm">
                        <i class="fa fa-align-justify"></i> 
                        <span><?php echo lang('Actions') ?></span> 
                        <span class="caret"></span>
                    </div>
                </button>

                <ul class="dropdown-menu">
                    <?php 
                    foreach ($this->menus as $menu) { 
                    
                    // build link
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

		<div class="col-sm-12">
			<h2 class="text-success">
				<span><?php echo lang('Module successfully created') ?></span>
				<i class="fa fa-fw fa-check-circle"></i>
			</h2>
		</div>

	</div>

	<div class="row">

		<div class="col-sm-6">
			
			<h3 style="margin-top: 15px"><?php echo lang('Your new module') . ' <a href="' . tag_replace($link)  . '" target="_blank">' .  get_value($module, 'label') . ' <i class="fa fa-fw fa-external-link"></i></a> ' . lang('was created with no errors.') ?></h3>

			<h4 style="margin-top: 40px"><?php echo lang('Things you are recommended now')?>:</h4>

			<div>
				<h5>
				<i class="fa fa-fw fa-arrow-circle-right"></i>
				<a href="<?php echo tag_replace($link) ?>" target="_blank"><?php echo lang('Go to') ?> <?php echo get_value($module, 'label') ?> <i class="fa fa-fw fa-external-link"></i></a>
				</h5>
			</div>

			<div>
				<h5>
				<i class="fa fa-fw fa-users"></i> 
				<a href="<?php echo URL_ROOT ?>/app_user" target="_blank"><?php echo lang('Apply user permissions for this module') ?> <i class="fa fa-fw fa-external-link"></i></a>
				</h5>
			</div>

			<div style="margin-top: 10px">
				<h5>
				<i class="fa fa-fw fa-cog"></i> 
				<a href="<?php echo URL_ROOT ?>/app_module_manager/config/<?php echo get_value($module, 'id_module')?>" target="_blank"><?php echo lang('Manage settings of this module') ?> <i class="fa fa-fw fa-external-link"></i></a>
				</h5>
			</div>

			<h4 class="text-muted" style="margin: 40px 0 0"><?php echo lang('Or you can')?>:</h4>

			<a href="<?php echo $this->session->userdata('url_default'); ?>" class="btn btn-md btn-normal" style="margin: 15px 15px 0 0"><?php echo lang('Go to initial page') ?> <i class="fa fa-fw fa-home"></i></a>

			<a href="<?php echo URL_ROOT ?>/app_module_maker/new_module" class="btn btn-md btn-default" style="margin: 15px 0 0 "><?php echo lang('Create a new module') ?> <i class="fa fa-fw fa-plus-circle"></i></a>

		</div>

		<div class="col-sm-6">
			<div class="panel panel-info" style="margin-top: 15px">
	    		<div class="panel-heading"><?php echo lang('Files that were created')?>:</div>
	    		<div class="panel-body">
	    			<div><i class="fa fa-file-text fa-fw"></i> application/controllers/<strong><?php echo get_value($module, 'controller') ?>.php</strong></div>
					<div><i class="fa fa-file-text-o fa-fw"></i> application/models/<strong><?php echo get_value($module, 'controller') ?>_model.php</strong></div>
					<div><i class="fa fa-folder-o fa-fw"></i> application/views/<?php echo TEMPLATE ?>/<strong><?php echo get_value($module, 'controller') ?></strong></div>
	    		</div>
	    	</div>
		</div>

	</div>

	<div class="row">

		<div class="col-sm-12">
		</div>

	</div>

</div>

<script>

    // tooltips
    $('body').tooltip( { selector: "[data-toggle=tooltip]" } );

</script>