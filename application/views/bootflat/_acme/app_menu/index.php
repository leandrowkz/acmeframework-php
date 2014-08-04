
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

		<div class="col-xs-12">

			<div class="row">
				<div class="col-md-6 col-lg-6">
					
					<div class="input-group">
	                    <select class="form-control inline" id="select-groups"><?php echo $options ?></select>
	                    <span class="input-group-btn">
	                    	<button class="btn btn-success btn-new-menu" data-toggle="modal" data-target="#modal-new-menu"><i class="fa fa-plus-circle fa-fw"></i> <?php echo lang('New menu') ?></button> 
	                    </span>
	                </div>

				</div>

			</div>

			<div class="row">	

				<div class="col-lg-12">

					<div id="menus-container" style="margin-top: 20px"></div>
					
		        </div>

		    </div>

	    </div>

	</div>

</div>

<script>
	
	// load all menus based on current group
	$.load_menus = function(group) {

		$.enable_loading();

		$.ajax({
            url: $('#URL_ROOT').val() + '/app_menu/load_menus/',
            data: {
            	'group' : group
            },
            context: document.body,
            cache: false,
            type: 'POST',
            complete : function (data) {

        		$.disable_loading();
           		
                $('#menus-container').html(data.responseText);
            }
        });

	};

 	// select change value
	$("#select-groups").change( function() {
		$.load_menus( $(this).val() );
	});

	// after load page
	$.load_menus($("#select-groups").val());
</script>