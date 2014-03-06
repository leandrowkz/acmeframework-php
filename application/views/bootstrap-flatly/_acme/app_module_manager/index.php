<div class="row module-header">

	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		<h1><?php echo lang($this->label) ?>
		<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
		</h1>
	</div>
	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="btn-group pull-right clearfix">
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-align-justify hidden-lg hidden-md"></i> 
				<div class="hidden-xs hidden-sm">
					<i class="fa fa-align-justify"></i> 
					<span><?php echo lang('Ações') ?></span> 
					<span class="caret"></span>
				</div>
			</button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo URL_ROOT ?>/app_module_maker"><i class="fa fa-plus-circle fa-fw"></i> <?php echo lang('Novo módulo')?></a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-xs-12">

		<div class="row">
			<div class="col-sm-6 col-lg-8">
				<h4 style="margin:10px 0"><?php echo lang('Módulos da aplicação')?></h4>
			</div>

			<div class="col-sm-6 col-lg-4">
				<div class="input-group" style="margin-bottom: 10px">
                    <input type="text" id="search-module" class="form-control input-sm">
                    <span class="input-group-addon input-sm"><i class="fa fa-search fa-fw"></i></span>
				</div>
			</div>
		</div>

		<div class="row">			
			<div class="col-lg-12">
				<div class="list-group modules">
					<?php foreach($modules as $module) { ?>
				   	<a href="<?php echo URL_ROOT ?>/app_module_manager/config/<?php echo get_value($module, 'id_module')?>" class="list-group-item" title="<?php echo lang('Configurações do módulo') ?>">
				   		<span class="pull-right"><i class="fa fa-arrow-circle-right fa-fw"></i></span>
				       	<h5 class="list-group-item-heading"><?php echo get_value($module, 'label') ?></h5>
				      	<p class="list-group-item-text"><?php echo get_value($module, 'description')?></p>
				   	</a>
		            <?php } ?>
		        </div>
	        </div>
	    </div>
    </div>
</div>

<script>

 	// input de pesquisa
	$("#search-module").keyup( function() {
		
		var exist = false;
		
		if($("#search-module").val().length > 2) {
			
			$('.modules .list-group-item').each( function() {
				$(this).hide();								
			});
			
			var search = $("#search-module").val().toLowerCase(); 		
			
			$('.modules .list-group-item h5, .modules .list-group-item p').each( function(index) {
			
				var text = $(this).text().toLowerCase();

				// alert(text);
				
				if(text.indexOf(search) != -1) {
					exist = true;
					$(this).parent().show();
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