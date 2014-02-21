<div class="row module-header">

	<div class="col-xs-12"><h1><?php echo lang('Dashboard') ?> <small>// <?php echo lang('Estatísticas gerais')?></small></h1></div>

</div>

<div class="row">
	
	<div class="col-md-4">
	
		<div class="row">
			<div class="col-sm-8 col-md-7">
				<h3 style="margin:0 0 15px 0"><?php echo lang('Módulos da aplicação')?></h3>
			</div>
			<div class="col-sm-4 col-md-5">
				<a href="<?php echo URL_ROOT ?>/app_module_maker" class="btn btn-success btn-block btn-default btn-sm" style="white-space:normal;margin-bottom:15px"><?php echo lang('Criar novo módulo')?> <i class="fa fa-plus-circle fa-fw"></i></a>
			</div>
		</div>

		<div class="list-group">
			<?php foreach($modules as $module) { ?>
        	<a href="<?php echo URL_ROOT ?>/<?php echo get_value($module, 'controller')?>" class="list-group-item" title="<?php echo lang('Clique para ir') ?>">
        		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
            	<h4 class="list-group-item-heading"><?php echo get_value($module, 'label') ?></h4>
            	<p class="list-group-item-text"><?php echo get_value($module, 'description')?></p>
            </a>
            <?php } ?>
        </div>

	</div>
	
	<div class="col-md-8">

		<div class="row">
			<div class="col-md-6 custom-panels">
				<div class="panel panel-primary">
		            <div class="panel-heading">
		                <i class="fa fa-tablet fa-fw"></i>
		                <h1 class="pull-right">18</h1>
		                <div class="text-right" style="margin-top:5px"><?php echo lang('Dispositivos diferentes')?></div>
		            </div>
		            <div class="panel-body">
		            	<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
		                <a href="javascript:void(0)"><?php echo lang('Ver dispositivos') ?></a>
		            </div>
		        </div>
			</div>

			<div class="col-md-6 custom-panels">
				<div class="panel panel-danger">
		            <div class="panel-heading">
		                <i class="fa fa-fire-extinguisher fa-fw"></i>
		                <h1 class="pull-right">18</h1>
		                <div class="text-right" style="margin-top:5px"><?php echo lang('Erros encontrados')?></div>
		            </div>
		            <div class="panel-body">
		            	<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
		                <a href="javascript:void(0)"><?php echo lang('Resolver problemas') ?></a>
		            </div>
		        </div>
			</div>
		</div>

		<div class="row" style="margin-top:10px">
			<div class="col-md-12 custom-panels">
				<div class="well" STYLE="height:400px">
		            <h3 class="text-center"><?php echo lang('Navegadores e acessos')?></h3>
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
	Morris.Bar({
    	element: 'browser-chart',
    	data: [
      		{device: 'iPhone', geekbench: 136},
      		{device: 'iPhone 3G', geekbench: 137},
      		{device: 'iPhone 3GS', geekbench: 275},
      		{device: 'iPhone 4', geekbench: 380},
      		{device: 'iPhone 4S', geekbench: 655},
      		{device: 'iPhone 5', geekbench: 1571}
    	],
    	xkey: 'device',
    	ykeys: ['geekbench'],
    	labels: ['Geekbench'],
    	barRatio: 0.4,
    	xLabelAngle: 35,
    	hideHover: 'auto',
    	pointSize: 2,
        resize: true
  	});
</script>