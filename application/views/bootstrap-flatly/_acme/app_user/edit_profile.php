
<div class="user-profile-sidebar">
    
    <div class="row">
        
        <div class="col-xs-6 col-sm-6 col-md-12 text-center">
            
            <?php 

            $id_user = get_value($user, 'id_user');
            $url_img = get_value($user, 'url_img');

            // Ajusta thumb
            if(basename($url_img) != '' && file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img)))
                $url_img = tag_replace($url_img);
            else
                $url_img = URL_IMG . '/user-unknown.png';
            ?>
            
            <a href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>">
                <img class="img-circular user-profile-img" src="<?php echo $url_img ?>" />
            </a>

        </div>
        
        <div class="user-profile-actions col-xs-6 col-sm-6 col-md-12">
            <a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_profile/<?php echo $id_user ?>"><i class="fa fa-edit fa-fw"></i> <?php echo lang('Editar perfil') ?></a>
            <a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_photo/<?php echo $id_user ?>"><i class="fa fa-picture-o fa-fw"></i> <?php echo lang('Alterar imagem')?></a>
            <a class="btn btn-sm btn-warning btn-block" href="<?php echo URL_ROOT ?>/app_user/change_password/<?php echo $id_user ?>"><i class="fa fa-lock fa-fw"></i> <?php echo lang('Alterar senha') ?></a>
        </div>

    </div>

</div>

<div class="user-profile-main-content">

    <div class="row" id="user-profile-name">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-sm pull-right" style="margin-top:5px" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Voltar') ?></a>
            <h1 style="margin-top:0"><?php echo get_value($user, 'name') ?></h1>
        </div>
    </div>
    
    <div class="row" style="margin-bottom: 30px ">
        <div class="col-sm-12 text-top" id="user-profile-badges">
            <div style="vertical-align:top;display:inline-block;margin-top:-1px">
                <div class="label label-info cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Grupo') ?>"><?php echo get_value($user, 'user_group') ?></div>
                <?php if(get_value($user, 'active') == 'Y'){ ?>
                <div class="label label-success"><i class="fa fa-check-circle fa-fw"></i> <?php echo lang('Ativo') ?></div>
                <?php } else { ?>
                <div class="label label-danger"><i class="fa fa-minus-circle fa-fw"></i> <?php echo lang('Inativo') ?></div>
                <?php } ?>
            </div>
            <div style="display:inline-block;"><i class="fa fa-calendar fa-fw"></i> <?php echo lang('Membro desde:') . ' ' . get_value($user, 'log_dtt_ins') ?></div>
        </div>
    </div>

    <form role="form" action="<?php echo URL_ROOT ?>/app_user/edit_profile/<?php echo $id_user ?>/true" method="post">
        
        <h3 style="margin: 0 0 30px 0"><?php echo lang('Editar perfil') ?></h3>
        
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user ?>" />

        <input type="hidden" id="email-callback" value="<?php echo get_value($user, 'email') ?>" />

        <div class="row">

            <div class="col-md-7 col-lg-5 col-xs-12 user-info">
                        
                <label><?php echo lang('Nome')?>*</label>
                <div class="form-group">
                    <input class="form-control validate[required]" value="<?php echo get_value($user, 'name') ?>" name="name" id="name" autofocus>
                </div>
                
                <label><?php echo lang('Email')?>*</label>
                <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Utilizado para acessar a aplicação') ?>"></i>
                <div class="form-group">
                    <input class="form-control validate[required,custom[email,funcCall[validate_email_custom]]]" value="<?php echo get_value($user, 'email') ?>" name="email" id="email">
                </div>

                <label><?php echo lang('Idioma')?>*</label>
                <div class="form-group">
                    <select class="form-control validate[required]" name="lang_default" id="lang_default">
                        <option value="pt_BR" <?php echo (get_value($user, 'lang_default') == 'pt_BR') ? 'selected="selected"' : ''; ?>><?php echo lang('Português (Brasil)')?></option>
                        <option value="en_US" <?php echo (get_value($user, 'lang_default') == 'en_US') ? 'selected="selected"' : ''; ?>><?php echo lang('Inglês (Estados Unidos)')?></option>
                    </select>
                </div>
                
                <label><?php echo lang('Descrição')?></label>
                <div class="form-group">
                    <textarea class="form-control" name="description" id="description"><?php echo get_value($user, 'description') ?></textarea>
                </div>

            </div>

        </div>

        <div class="row bottom-group-buttons">
            <div class="col-sm-12">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('Salvar') ?>" />
                <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><?php echo lang('Cancelar') ?></a>
            </div>
        </div>

    </form>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/validationEngine/validationEngine.jquery.css" />
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/plugins/validationEngine/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<script>
    // tooltips
    $('body').tooltip({ selector: "[data-toggle=tooltip]" });

    // Validação de form
    $("form").validationEngine('attach', {promptPosition : "bottomRight"});

    // Validação de form tem que funcionar no resize
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