<div class="module-header">

	<div class="row">

		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<h1>
				<?php echo lang($this->label) ?>
				<span><?php echo image($this->url_img) ?></span>
				<?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
			</h1>
		</div>
		
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

			<div class="pull-right clearfix">
				<a href="<?php echo URL_ROOT ?>/app_user" class="pull-right clearfix btn btn-primary">
					<i class="fa fa-arrow-circle-left hidden-lg hidden-md"></i> 
					<div class="hidden-xs hidden-sm">
						<i class="fa fa-arrow-circle-left"></i> 
						<span><?php echo lang('Voltar') ?></span>
					</div>
				</a>

			</div>

		</div>

	</div>

</div>

<div class="module-body">

	<div class="row">

		<div class="col-sm-8 col-md-7">
			
			<form action="<?php echo URL_ROOT ?>/app_user/edit/<?php echo get_value($user, 'id_user') ?>/true" method="post">
			
				<h3 style="margin: 0 0 30px 0"><?php echo lang('Editar usuário') ?></h3>

				<input type="hidden" id="email-callback" value="<?php echo get_value($user, 'email') ?>" />

				<div class="form-group">
	                <label><?php echo lang('Grupo') ?>*</label>
	                <select class="form-control validate[required]" id="id_user_group" name="id_user_group">
	                	<?php echo $options ?>
	                </select>
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Nome') ?>*</label>
	                <input type="text" id="name" name="name" class="form-control validate[required]" value="<?php echo get_value($user, 'name') ?>" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Descrição') ?></label>
	                <input name="description" id="description" class="form-control" value="<?php echo get_value($user, 'description') ?>" />
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Email') ?>*</label>
	               	<i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Utilizado para acessar a aplicação') ?>"></i>
	                <input type="text" id="email" name="email" class="form-control validate[required, custom[email,funcCall[validate_email_custom]]]" value="<?php echo get_value($user, 'email') ?>" />
	            </div>

		        <div class="form-group">
	                <label><?php echo lang('Idioma padrão') ?>*</label>
	                <select class="form-control validate[required]" id="lang_default" name="lang_default">
	                	<option value="en_US" <?php echo (get_value($user, 'lang_default') == 'en_US') ? 'selected="selected"' : '' ?>><?php echo lang('Inglês (EUA)') ?></option>
	                	<option value="pt_BR" <?php echo (get_value($user, 'lang_default') == 'pt_BR') ? 'selected="selected"' : '' ?>><?php echo lang('Português (Brasil)') ?></option>
	                </select>
	            </div>

	            <div class="form-group">
	                <label><?php echo lang('Página inicial') ?>*</label>
	               	<i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Após entrar na aplicação o usuário será direcionado para esta página') ?>"></i>
	                <input type="text" id="url_default" name="url_default" class="form-control validate[required]" value="<?php echo get_value($user, 'url_default') ?>" />
	            </div>

				<div class="row bottom-group-buttons">
		            <div class="col-sm-12">
		                <input class="btn btn-primary" type="submit" value="<?php echo lang('Salvar') ?>" />
		                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app_user"><?php echo lang('Cancelar') ?></a>
		            </div>
		        </div>

			</form>

	    </div>

	</div>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>

    // tooltips
    $('body').tooltip( { selector: "[data-toggle=tooltip]" } );
	
	// Set form validations
    $('form').validationEngine('attach', { promptPosition : "bottomRight" });

    // Reposition the alerts from form
    $( window ).resize( function () {
        $("form").validationEngine('updatePromptsPosition');
    });

    // custom validation for email
    var validate_email_custom = function(field, rules, i, options) {

	    var exist = false;
	    
	    if(field.val() != $('#email-callback').val())
	        $.ajax({
	            
	            url: $('#URL_ROOT').val() + '/app_user/check_email/',
	            context: document.body,
	            cache: false,
	            async: false,
	            data: { 'email' : field.val() },
	            type: 'POST',
	            success: function(data){

	                json = $.parseJSON(data);
	                
	                if(json.return == true)
	                    exist = true;
	            }
	        });
	    
	    if( exist )
	        return "<?php echo lang('Endereço de email já existe') ?>";
    }
	
</script>