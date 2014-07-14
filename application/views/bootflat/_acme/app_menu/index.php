
<div class="row module-header">

	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		<h1><?php echo lang($this->label) ?>
		<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
		</h1>
	</div>

</div>

<div class="row">

	<div class="col-xs-12">

		<div class="row">
			<div class="col-md-6 col-lg-6">
				
				<div class="input-group">
                    <select class="form-control inline" id="select-groups"><?php echo $options ?></select>
                    <span class="input-group-btn">
                    	<button class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> <?php echo lang('Novo menu') ?></button> 
                    </span>
                </div>

			</div>

		</div>

		<div class="row">	

			<div class="col-lg-12">

				<div id="menus-container" style="margin-top: 30px"></div>
				
	        </div>

	    </div>

    </div>

</div>

<script>

	$.load_menus = function(group) {

		enable_loading();

		$.ajax({
            url: $('#URL_ROOT').val() + '/app_menu/load_menus/',
            data: {
            	'group' : group
            },
            context: document.body,
            cache: false,
            async: false,
            type: 'POST',
            complete : function (data) {
            	// alert(data.responseText);
                $('#menus-container').html(data.responseText);
            }
        });

        disable_loading();

	};

 	// select change value
	$("#select-groups").change( function() {
		$.load_menus( $(this).val() );
	});

	// after load page
	$.load_menus($("#select-groups").val());
</script>