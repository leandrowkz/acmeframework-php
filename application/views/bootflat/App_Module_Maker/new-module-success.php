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
			<h3 class="text-success">
				<span><?php echo lang('Module successfully created') ?>.</span>
				<i class="fa fa-fw fa-check-circle"></i>
			</h3>
		</div>

	</div>

	<div class="row">

		<div class="col-sm-8 col-md-7">

			<h4 style="margin: 15px 0">
                <?php echo lang('Module') . ' <span class="text-italic">' . get_value($module, 'label') . '</span> ' . lang('created with no errors.') ?>
                <a href="<?php echo tag_replace($link) ?>" target="_blank" class="btn btn-primary btn-xs"><?php echo lang('Open module') ?> <i class="fa fa-fw fa-external-link"></i></a>
            </h4>

            <div class="text-bold" style="margin: 30px 0 10px"><?php echo lang('Module files (MVC)')?>:</div>
            <div style="line-height: 25px;"><i class="fa fa-file-text fa-fw"></i> application/controllers/<strong><?php echo get_value($module, 'controller') ?>.php</strong></div>
            <div style="line-height: 25px;"><i class="fa fa-database fa-fw"></i> application/models/<strong><?php echo get_value($module, 'controller') ?>_Model.php</strong></div>
            <div style="line-height: 25px;"><i class="fa fa-folder-o fa-fw"></i> application/views/<?php echo TEMPLATE ?>/<strong><?php echo get_value($module, 'controller') ?></strong></div>


			<div class="text-bold" style="margin: 30px 0 10px"><?php echo lang('What to do next')?>:</div>
			<div style="line-height: 30px;">
                <i class="fa fa-fw fa-users"></i>
                <a href="<?php echo URL_ROOT ?>/app-user" target="_blank"><?php echo lang('Apply user permissions') ?> <i class="fa fa-fw fa-external-link"></i></a>
            </div>
            <div style="line-height: 30px;">
                <i class="fa fa-fw fa-cogs"></i>
                <a href="<?php echo URL_ROOT ?>/app-module-manager/config/<?php echo get_value($module, 'id_module')?>" target="_blank"><?php echo lang('Manage module settings') ?> <i class="fa fa-fw fa-external-link"></i></a>
            </div>
            <div style="line-height: 30px;">
                <i class="fa fa-fw fa-plus-circle"></i>
                <a href="<?php echo URL_ROOT ?>/app-module-maker/new-module" target="_blank"><?php echo lang('Create a new module') ?> <i class="fa fa-fw fa-external-link"></i></a>
            </div>

            <div class="form-footer" style="margin-top: 25px">
                <a href="<?php echo $this->session->userdata('url_default') ?>" class="btn btn-success" type="submit"><?php echo lang('Go home page') ?> <i class="fa fa-fw fa-home"></i></a>
            </div>

		</div>

	</div>

</div>

<script>

    // ========
    // Tooltips
    // ========
    $('body').tooltip({
        selector : '[data-toggle=tooltip]',
        container : 'body'
    });

</script>