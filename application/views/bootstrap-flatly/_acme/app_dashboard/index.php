<div class="row module-header">

	<div class="col-xs-12">
		<h1><?php echo lang($this->label) ?> 
		<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
		</h1>
	</div>

</div>

<div class="row">
	
	<div class="col-md-5 col-lg-5">
		
		<div class="panel panel-default panel-list">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-8 col-sm-8 col-md-12 col-lg-7" id="title-modules-override">
						<h4 style="margin:10px 0"><?php echo lang('Módulos da aplicação')?></h4>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-12 col-lg-5" id="add-module-override">
						<a href="<?php echo URL_ROOT ?>/app_module_maker" class="btn btn-success btn-block btn-default btn-md" style="white-space:normal"><?php echo lang('Novo módulo')?> <i class="fa fa-plus-circle fa-fw"></i></a>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="list-group">
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

				<div class="panel panel-primary">

		            <div class="panel-heading">
		                <i class="fa fa-tablet fa-fw"></i>
		                <h1 class="pull-right"><?php echo count($devices)?></h1>
		                <div class="text-right" style="margin-top:5px"><?php echo lang('Dispositivos diferentes')?></div>
		            </div>
		            <div class="panel-body">
		            	<span class="pull-right"><i id="show-devices-arrow" class="fa fa-arrow-circle-right fa-fw"></i></span>
		                <a href="javascript:void(0)" id="show-devices"><?php echo lang('Ver dispositivos') ?></a>

		                <div class="list-group" id="list-devices" style="margin:10px 0 0;display:none">
		                <?php foreach($devices as $device) {?>
			                <div class="list-group-item">
			                	<span class="text-muted pull-right"><?php echo get_value($device, 'count_access'); ?> <?php echo lang('acessos')?></span>
			                	<span><?php echo get_value($device, 'device_name'); ?></span>
			                </div>
		                <?php } ?>
		            	</div>
		            </div>

		        </div>
		    
			</div>

			<div class="col-sm-6 col-md-12 col-lg-6 custom-panels">
				<div class="panel panel-danger">
		            
		            <div class="panel-heading">
		                <i class="fa fa-bug fa-fw"></i>
		                <h1 class="pull-right" id="count-errors"><?php echo count($errors) ?></h1>
		                <div class="text-right"style="margin-top:5px"><?php echo lang('Erros encontrados')?></div>
		            </div>
		            <div class="panel-body">
		            	<span class="pull-right"><i id="show-errors-arrow" class="fa fa-arrow-circle-right fa-fw"></i></span>
		                <a href="javascript:void(0)" id="show-errors"><?php echo lang('Resolver problemas') ?></a>
		                
		                <div id="list-errors">
		                	<h5 class="text-muted"><?php echo lang('Exibindo últimos 50')?></h5>
			                <div class="list-group">
				                <?php 
				                $i = 1;
				                foreach($errors as $error) {?>
				                	<?php if($i <= 50) {?>
					                <div class="list-group-item" id="error-<?php echo get_value($error, 'id_log_error') ?>">
					                	<small class="pull-right"><a href="javascript:void(0)" id="<?php echo get_value($error, 'id_log_error') ?>"><?php echo lang('Remover'); ?></a></small>
					                	<div><?php echo get_value($error, 'header'); ?></div>
					                	<div><small><?php echo get_value($error, 'additional_data'); ?></small></div>
					                	<div><small><?php echo get_value($error, 'message'); ?></small></div>
					                	<div><?php echo lang('Em') ?> <?php echo get_value($error, 'log_dtt_ins'); ?></div>
					                </div>
					            	<?php } ?>
					            <?php $i++; } ?>
				            </div>
				            
				            <?php if($i >= 50) {?>
				            <a href="<?php echo URL_ROOT ?>/app_log" title="<?php echo lang('Ver todos') ?>" class="text-center"><h2 style="margin-top:0">. . .</h2></a>
				            <?php } ?>
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

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/morris/morris-0.4.3.min" />
<script src="<?php echo URL_JS ?>/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="<?php echo URL_JS ?>/plugins/morris/morris.js"></script>

<script>
	
	// trigger to remove log error
	$('small.pull-right a').click(function () {
		
		// get id
        var id = $(this).attr('id');
        
        // Confirm this shit
        bootbox.confirm("<?php echo lang('Deseja realmente remover o erro selecionado?') ?>", function (result) {

            // Cancel
            if( ! result)
                return;

            // ajax to remove that shit
			enable_loading();

			$.ajax({
	            url: $('#URL_ROOT').val() + '/app_log/save_error/' + id + '/true',
	            context: document.body,
	            cache: false,
	            async: false,
	            type: 'POST',

	            complete : function (response) {
	            	
	            	// Parse json to check errors
	            	json = $.parseJSON(response.responseText);
	            	
	            	// Check return
	            	if( ! json.return) { 

	            		// nice alert error
	            		bootbox.alert(json.error);
	            		return false;
	            	}

	            	// procced with no errors, remove error from div
                	$('#error-' + id).remove();
                	$('#count-errors').html($('#count-errors').html() - 1);
	            }
	        });

	    	disable_loading();
            
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

	// slide for errors
	$('#show-errors, #show-errors-arrow').click(function () {
		if( $('#list-errors').is(':visible') ) {
			$('#show-errors-arrow').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-right');
			$('#list-errors').slideUp();
		} else {
			$('#show-errors-arrow').removeClass('fa-arrow-circle-right').addClass('fa-arrow-circle-down');
			$('#list-errors').slideDown(300);
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