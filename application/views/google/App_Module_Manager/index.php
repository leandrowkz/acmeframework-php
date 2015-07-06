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

					<li><a href="<?php echo URL_ROOT ?>/app-module-maker"><i class="fa fa-plus-circle fa-fw"></i> <?php echo lang('New module')?></a></li>

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

	</div>

</div>

<div class="module-body">

	<div class="module-filter">
        <span class="input-group-addon input-md"><i class="fa fa-search fa-fw"></i></span>
		<input id="search-module" type="search" class="form-control" placeholder="<?php echo lang('Search modules') ?>" autofocus="autofocus" style="width: auto; display: inline-block !important" />
	</div>

	<div class="row">

		<div class="col-sm-12">

			<div class="list-group modules">

				<?php foreach($modules as $module) { ?>

			   	<a href="<?php echo URL_ROOT ?>/app-module-manager/config/<?php echo get_value($module, 'id_module')?>" class="list-group-item" title="<?php echo lang('Module configuration') ?>">

			   		<div class="module-img inline top"><?php echo image(get_value($module, 'url_img')) ?></div>

			   		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>

			       	<div class="inline">

				       	<h5 class="list-group-item-heading">

				       		<?php echo lang(get_value($module, 'label')) ?>

				       	</h5>

				      	<p class="list-group-item-text"><?php echo lang(get_value($module, 'description'))?></p>

			     	 </div>

			   	</a>

	            <?php } ?>

	        </div>

        </div>

    </div>

</div>

<style>

	.module-img { min-width: 55px; }
	.module-img img { vertical-align: top; max-width: 32px; margin: 0 0 0 5px; }
	.module-img i { font-size: 32px; vertical-align: top; margin-right: 10px; }

</style>

<script>

	// =============
 	// Module search
 	// =============
	$("#search-module").keyup( function() {

		var exist = false;

		if($("#search-module").val().length > 2) {

			$('.modules .list-group-item').each( function() {
				$(this).hide();
			});

			var search = $("#search-module").val().toLowerCase();

			$('.modules .list-group-item h5, .modules .list-group-item p').each( function(index) {

				var text = $(this).text().toLowerCase();

				if(text.indexOf(search) != -1) {
					exist = true;
					$(this).closest('.list-group-item').show();
				}
			});

			if(exist == false)
				return;

		} else if($("#search-module").val().length <= 2 || $("#search-module").val().length == '') {
			$('.modules .list-group-item').each(function(index) {
				$(this).show();
			});
		}
	});

</script>