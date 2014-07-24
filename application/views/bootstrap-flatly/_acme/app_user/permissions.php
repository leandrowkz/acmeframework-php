
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
            
            <img class="img-circular user-profile-img" src="<?php echo $url_img ?>" />

        </div>

    </div>

</div>

<div class="user-profile-main-content">

    <div class="row" id="user-profile-name">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-sm pull-right" style="margin-top:5px" href="<?php echo URL_ROOT ?>/app_user"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Voltar') ?></a>
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

    <h3 style="margin: 0 0 30px 0"><?php echo lang('Permissões') ?></h3>
    
    <div class="permission" style="margin-bottom: 40px;">
        <h4><?php echo get_value($permissions[0], 'module') ?></h4>
    <?php 
    $i = 0;
    $module = '';
    foreach($permissions as $permission) { 
    ?>

    <?php if($module != get_value($permission, 'module') && $i > 0) { ?>
    </div>
    <div class="permission" style="margin-bottom: 40px;">
        <h4><?php echo get_value($permission, 'module') ?></h4>
    <?php } ?>

    <div class="checkbox">
        <label>
            <input type="checkbox" id="<?php echo get_value($permission, 'id_module_permission') ?>" <?php echo (get_value($permission, 'has_permission') == 'Y') ? 'checked="checked"' : ''; ?>> <?php echo get_value($permission, 'permission') ?> <span class="text-muted">// <?php echo get_value($permission, 'permission_description') ?></span>
            <?php if(get_value($permission, 'permission_observation') != '') { ?>
            <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo get_value($permission, 'permission_observation') ?>"></i>
            <?php } ?>
        </label>
    </div>

    <?php 
    $module = get_value($permission, 'module');
    $i++;
    } 
    ?>

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

    // click enable field checkbox
    $('input[type=checkbox]').click( function () {

        // get id
        var id = $(this).attr('id');

        // get operation
        var oper = $(this).is(':checked') ? 'enable' : 'disable';

        // ajax to save this fucking shit
        $.enable_loading();
        
        $.ajax({
            url: $('#URL_ROOT').val() + '/app_user/save_permission/' + oper,
            context: document.body,
            data : { 
                'id_module_permission' : id ,
                'id_user' : <?php echo $id_user ?>
            },
            cache: false,
            async: false,
            type: 'POST',
            complete : function (response) { 
                
                // Parse json to check errors
                json = $.parseJSON(response.responseText);
                
                // Check return
                if( ! json.return) { 
                    // close modal and alert
                    bootbox.alert(json.error);
                    return false;
                } 
            }
        });

        $.disable_loading();
    });


</script>