
<div class="user-profile-sidebar">
    
    <div class="row">
        
        <div class="col-xs-6 col-sm-6 col-md-12 text-center">
            
            <?php 
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
            <h1 style="margin-top:0"><?php echo $name ?></h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 text-top" id="user-profile-badges">
            <div style="vertical-align:top;display:inline-block;margin-top:-1px">
                <div class="label label-info cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Grupo') ?>"><?php echo $group ?></div>
                <?php if($active == 'Y'){ ?>
                <div class="label label-success"><i class="fa fa-check-circle fa-fw"></i> <?php echo lang('Ativo') ?></div>
                <?php } else { ?>
                <div class="label label-danger"><i class="fa fa-minus-circle fa-fw"></i> <?php echo lang('Inativo') ?></div>
                <?php } ?>
            </div>
            <div style="display:inline-block;"><i class="fa fa-calendar fa-fw"></i> <?php echo lang('Membro desde:') . ' ' . $log_dtt_ins ?></div>
        </div>
    </div>

    <h3>// <?php echo lang('Perfil') ?></h3>
    
    <div class="row" style="margin-top:20px">

        <div class="col-sm-12 user-info">
            <div style="line-height:25px">
                <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('login') ?>"><i class="fa fa-user fa-fw"></i> <?php echo $login ?></span><br />
                <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Email') ?>"><i class="fa fa-envelope fa-fw"></i> <?php echo $email ?></span><br />
                <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('URL inicial') ?>"><i class="fa fa-home fa-fw"></i> <?php echo $url_default ?></span><br />
                <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Idioma de acesso') ?>">
                	<i class="fa fa-font fa-fw"></i> 
                	<?php 
						switch(strtolower($lang_default)) {
							case 'en_us':
								echo lang('Inglês (Estados Unidos)');
							break;
							
							case 'pt_br':
							default:
								echo lang('Português (Brasil)');
							break;
						} 
					?>
                </span>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:20px">
        <div class="col-sm-12">
            <h4><?php echo lang('Descrição') ?></h4>
            <p>
            	<?php 
            	if($description != '') {
            		echo $description;
            	} else { 
            		echo '<em class="text-muted">' . lang('Nenhuma descrição disponível.') . '</em>'; 
            	}
            ?>
            </p>
        </div>
    </div>

    <div class="row" style="margin-top:20px">
        <div class="col-sm-12">
            <h4><?php echo lang('Histórico de acesso') ?></h4>
            <div id="morris-area-chart"></div>
        </div>
    </div>

</div>

<script>
    // tooltips
    $('.user-profile-main-content').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
</script>