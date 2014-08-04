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

	<?php echo $module_table ?>

</div>
