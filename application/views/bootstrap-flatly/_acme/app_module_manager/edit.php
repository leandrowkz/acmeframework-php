<div class="row module-header">

	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		<h1><?php echo lang($this->label) ?>
		<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
		</h1>
	</div>
	
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

		<div class="pull-right clearfix">
			<a href="<?php echo URL_ROOT ?>/app_module_manager/config/<?php echo get_value($module, 'id_module')?>" class="pull-right clearfix btn btn-primary">
				<i class="fa fa-arrow-circle-left hidden-lg hidden-md"></i> 
				<div class="hidden-xs hidden-sm">
					<i class="fa fa-arrow-circle-left"></i> 
					<span><?php echo lang('Voltar') ?></span>
				</div>
			</a>

		</div>

	</div>
</div>

<div class="row">

	<div class="col-lg-12">
		
		<h3><?php echo lang('Editar módulo') ?></h3>
		<hr style="margin: 10px 0 20px 0" />

	</div>

</div>

<div class="row">

	<div class="col-sm-8 col-md-7">

		<form action="<?php echo URL_ROOT ?>/app_module_manager/edit/<?php echo get_value($module, 'id_module') ?>/true" method="post">

			<div class="form-group">
                <label><?php echo lang('Label') ?>*</label>
                <input type="text" id="label" name="label" class="form-control validate[required]" value="<?php echo get_value($module, 'label') ?>" />
            </div>

            <div class="form-group">
                <label><?php echo lang('Descrição') ?></label>
                <input type="text" id="description" name="description" class="form-control" value="<?php echo get_value($module, 'description') ?>" />
            </div>

            <div class="form-group">
                <label><?php echo lang('Tabela') ?></label>
                <input type="text" id="table_name" name="table_name" class="form-control" value="<?php echo get_value($module, 'table_name') ?>" />
            </div>

            <div class="form-group">
                <label><?php echo lang('SQL de listagem') ?></label>
                <textarea name="sql_list" id="sql_list" class="form-control" style="height: 180px"><?php echo get_value($module, 'sql_list') ?></textarea>
            </div>

			<div class="row bottom-group-buttons">
	            <div class="col-sm-12">
	                <input class="btn btn-primary" type="submit" value="<?php echo lang('Salvar') ?>" />
	                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app_module_manager/config/<?php echo get_value($module, 'id_module') ?>"><?php echo lang('Cancelar') ?></a>
	            </div>
	        </div>

		</form>

    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>
	
	// Set form validations
    $('form').validationEngine('attach', { promptPosition : "bottomRight" });
	
</script>