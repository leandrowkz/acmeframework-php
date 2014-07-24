
<div class="user-profile-sidebar">
    
    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-12 text-center">
            
            <?php 

            $id_user = get_value($user, 'id_user');
            $url_img = get_value($user, 'url_img');
            $url_img_large = tag_replace(get_value($user, 'url_img_large'));

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
    
    <div class="row">
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

    <h3><?php echo lang('Alterar imagem')?></h3>

    <div class="row" style="margin-top:20px">
        
        <?php $file_exists = file_exists(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename($url_img_large)) && basename($url_img_large) != '' ? true : false; ?>
        <?php if($file_exists) {?>
        <div class="col-sm-8 col-xs-12 text-center">
            <div>
            <img src="<?php echo $url_img_large ?>" class="img-responsive" id="img-user" style="margin-bottom:15px" />
            </div>
        </div>
        <?php } ?>
        <!--
        <div id="preview" style="width: 100px; height: 100px; overflow: hidden;">
            <img src="<?php echo URL_IMG ?>/bg-4.jpg" />
        </div>
        -->

        <div class="col-sm-<?php echo ($file_exists) ? '4' : '12'; ?> col-xs-12 text-center">
            <?php if($file_exists) {?>
            <button class="btn btn-primary btn-block" onclick="make_thumbnail()"><?php echo lang('Recortar e salvar')?></button>
            <p class="lead" style="margin:10px 0 20px 0"><?php echo lang('ou') ?></p>
            <?php } ?>
            
            <form action="<?php echo URL_ROOT ?>/app_user/upload_photo/<?php echo $id_user ?>" enctype="multipart/form-data" method="post" class="dropzone" id="sendFile">
                
                <div class="fallback text-center">
                    <input class="btn btn-default btn-xs text-center" name="file" id="file" type="file" />
                    <a class="btn btn-default btn-lg" href="javascript:void(0)" onclick="send_file_fallback()"><?php echo lang('Enviar') ?></a>
                </div>

            </form>

            <iframe name="iframe-fallback" id="iframe-fallback" style="display:none"></iframe>

            <div id="msg-return-container" class="text-left" style="margin-top:15px"></div>
            <div id="msg-template-error" style="display:none"><?php echo message('error', 'Ops!', '<span id="msg-content"></span>', true); ?></div>
            <div id="msg-template-success" style="display:none"><?php echo message('success', lang('Feito!'), '<span id="msg-content"></span>', true); ?></div>
        </div>
    </div>

    <div class="row bottom-group-buttons">
        <div class="col-sm-12">
            <?php if($file_exists) { ?>
            <button class="btn btn-primary" onclick="make_thumbnail()"><?php echo lang('Recortar e salvar') ?></button>
            <a class="btn btn-default" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><?php echo lang('Cancelar') ?></a>
            <?php } else { ?>
            <a class="btn btn-primary" style="margin-top:5px" href="<?php echo URL_ROOT ?>/app_user/profile/<?php echo $id_user ?>"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Voltar') ?></a>
            <?php } ?>
        </div>
    </div>

</div>

<script src="<?php echo URL_JS ?>/plugins/dropzone/dropzone.js"></script>
<script src="<?php echo URL_JS ?>/plugins/imgareaselect/jquery.imgareaselect.js"></script>
<script src="<?php echo URL_JS ?>/plugins/imgareaselect/jquery.imgareaselect.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/dropzone/dropzone.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-animated.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_CSS ?>/plugins/imgareaselect/imgareaselect-deprecated.css" />

<script>
    // Some configs
    var max_upload_size = 4; // MB

    // tooltips
    $('.user-profile-main-content').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    <?php if($file_exists) { ?>
    // para a seleção no loading
    var px2 = ($('#img-user').width() < 150) ? $('#img-user').width() : 150;
    var py2 = ($('#img-user').height() < 150) ? $('#img-user').height() : 150;

    // instancia o crop
    var api = $('#img-user').imgAreaSelect({ instance : true });
    api.setOptions({ 
        aspectRatio: '1:1', 
        handles: true, 
        fadeSpeed: 200,
        movable: true,
        x1 : 0,
        x2 : px2,
        y1 : 0,
        y2 : py2
    });
    api.update();

    // reabilita o crop no resize da janela
    $( window ).resize(function () {

        api.setOptions({ hide : true });
        api.update();

        api.setOptions({ disable : true });
        api.update();

        api.setOptions({ enable : true });
        api.update();

    });

    // Button Recortar e salvar
    function make_thumbnail() {
        
        // Retorna a seleção atual (x1, y1, ...)
        selection = api.getSelection();

        // DEBUG:
        // alert(selection.width);
        // alert(selection.height);

        if(!selection.width || !selection.height) {
            alert('<?php echo lang("Para recortar, selecione uma área da imagem atual.")?>');
            return; 
        }

        // habilita layer de loading
        $.enable_loading();

        $.ajax({
            url: $('#URL_ROOT').val() + '/app_user/edit_thumbnail/<?php echo $id_user ?>',
            data: {
                w : $("#img-user").width(),
                h : $("#img-user").height(),
                sw : selection.width,
                sh : selection.height,
                x1 : selection.x1,
                x2 : selection.x2,
                y1 : selection.y1,
                y2 : selection.y2,
            },
            context: document.body,
            cache: false,
            async: false,
            type: 'POST',
            success: function(data)
            {
                redirect($('#URL_ROOT').val() + '/app_user/profile/<?php echo $id_user ?>');
            },
            complete : function () {
                $.disable_loading();
            }
        });
    }
    <?php } ?>

    // dropzone (upload)
    Dropzone.options.sendFile = {
        init: function() {

            this.on("error", function(file, errorMessage) {
                $("#msg-template-error #msg-content").html(errorMessage); 
                $("#msg-return-container").html($("#msg-template-error").html());
            });

            this.on("success", function(file, response) {
                
                <?php if(!$file_exists) { ?>
                window.location.reload();
                return;
                <?php } ?>
                
                // Adiciona mensagem de sucesso
                $("#msg-template-success #msg-content").html("<?php echo lang('Imagem enviada com sucesso.')?>"); 
                $("#msg-return-container").html($("#msg-template-success").html());

                // Atualiza img em tempo real
                $("#img-user").attr("src", "<?php echo URL_UPLOAD . '/' . $this->photos_dir ?>/" + response);

                // Reinicia API crop de imagens
                api.setOptions({ hide : true });
                api.update();

                api.setOptions({ disable : true });
                api.update();

                api.setOptions({ enable : true });
                api.update();

                // Remove todos os thumbs
                this.removeAllFiles();
                
            });

            this.on("sending", function(file) {
                this.removeAllFiles();
            });
        },

        maxFilesize: max_upload_size,

        addRemoveLinks : true,

        dictDefaultMessage : '<div class="cursor-pointer"><i class="fa fa-cloud-upload fa-fw" style="font-size:70px;margin:0"></i><div class="lead" style="margin:0"><?php echo lang("Envie uma imagem")?></div><div><?php echo lang("Clique ou arraste para esta área")?></div></div>',
        
        dictRemoveFile : "<?php echo lang('Remover')?>",

        paramName : "file",

        forceFallback : false
    };

    // Função retaguarda para envio de arquivo (cross-browser)
    function send_file_fallback() {

        // troca o target do form
        $('form#sendFile').attr('target', 'iframe-fallback').submit();

        // alert($("#iframe-fallback").contents());
        
        // Get initial text:
        var changed = false;
        var previous = $("#iframe-fallback").contents().find("body");

        // Create a function for what to do if there is a change:
        $check = function() {
        
            if ($("#iframe-fallback").contents().find("body") != previous && changed == false) {
                
                // Upload error
                if($("#iframe-fallback").contents().find("body error").length > 0)
                {
                    $("#msg-template-error #msg-content").html($("#iframe-fallback").contents().find("body error").html()); 
                    $("#msg-return-container").html($("#msg-template-error").html());
                
                // That's right!
                } else {
                    $("#msg-template-success #msg-content").html("<?php echo lang('Imagem enviada com sucesso.')?>"); 
                    $("#msg-return-container").html($("#msg-template-success").html());

                    // atualiza imagem
                    $("#img-user").attr("src", "<?php echo URL_UPLOAD . '/' . $this->photos_dir ?>/" + $("#iframe-fallback").contents().find("body").html());

                    // Reinicia API crop de imagens
                    api.setOptions({ hide : true });
                    api.update();

                    api.setOptions({ disable : true });
                    api.update();

                    api.setOptions({ enable : true });
                    api.update();
                }

                changed = true;

            }
            // Store what contents are for later comparison
            previous = $("#iframe-fallback").contents().find("body");

        }

        // Right click work around is to check every Xs
        setInterval(function() { $check(); }, 500);
    }

    // listener do input file (prevent to upload large files)
    $('#file').change(function() {
        
        var file = this.files[0];
        var size = Math.round(file.size / 1000000);

        // Max size
        if(size > max_upload_size) {
            $("#msg-template-error #msg-content").html('<?php echo lang("Arquivo muito grande") ?> (' + size + ' MB). ' + '<?php echo lang("Tamanho máximo de arquivo")?>: ' + max_upload_size + ' MB.');
            $("#msg-return-container").html($("#msg-template-error").html());
            $(this).val('');
        }
    });
</script>