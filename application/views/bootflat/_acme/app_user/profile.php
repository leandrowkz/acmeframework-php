<div class="module-header">

    <div class="row">

        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h1>
                <?php echo lang('Profile') ?>
                <span><i class="fa fa-fw fa-user"></i></span>
                <small>// <?php echo lang('User information') ?></small>
            </h1>
        </div>

    </div>
    
</div>

<div class="module-body">

    <div class="user-profile-sidebar">
        
        <div class="row">
            
            <div class="col-xs-6 col-sm-6 col-md-12 text-center">
                
                <?php 

                $id_user = get_value($user, 'id_user');
                $url_img = get_value($user, 'url_img');

                // Adjust thumb
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
            	<a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_profile/<?php echo $id_user ?>"><i class="fa fa-edit fa-fw"></i> <?php echo lang('Edit profile') ?></a>
                <a class="btn btn-sm btn-primary btn-block" href="<?php echo URL_ROOT ?>/app_user/edit_photo/<?php echo $id_user ?>"><i class="fa fa-picture-o fa-fw"></i> <?php echo lang('Change image')?></a>
                <a class="btn btn-sm btn-warning btn-block" href="<?php echo URL_ROOT ?>/app_user/change_password/<?php echo $id_user ?>"><i class="fa fa-lock fa-fw"></i> <?php echo lang('Change password') ?></a>
            </div>

        </div>

    </div>

    <div class="user-profile-main-content">

        <div class="row" id="user-profile-name">
            <div class="col-sm-12">
                <h1 style="margin-top: 0"><?php echo get_value($user, 'name') ?></h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-top" id="user-profile-badges">
                <div style="vertical-align: top; display: inline-block; margin-top:-1px">
                    <div class="label label-info cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Group') ?>"><?php echo get_value($user, 'user_group') ?></div>
                    <?php if(get_value($user, 'active') == 'Y'){ ?>
                    <div class="label label-success"><i class="fa fa-check-circle fa-fw"></i> <?php echo lang('Active') ?></div>
                    <?php } else { ?>
                    <div class="label label-danger"><i class="fa fa-minus-circle fa-fw"></i> <?php echo lang('Inactive') ?></div>
                    <?php } ?>
                </div>
                <div style="display:inline-block;"><i class="fa fa-calendar fa-fw"></i> <?php echo lang('Member since:') . ' ' . get_value($user, 'log_dtt_ins') ?></div>
            </div>
        </div>

        
        <div class="row" style="margin-top:20px">

            <div class="col-sm-12 user-info">
                
                <h4><?php echo lang('Profile') ?></h4>
                <div style="line-height:25px">
                    <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Email') ?>"><i class="fa fa-envelope fa-fw"></i> <?php echo get_value($user, 'email') ?></span><br />
                    <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Default page / URL') ?>"><i class="fa fa-home fa-fw"></i> <?php echo get_value($user, 'url_default') ?></span><br />
                    <span class="cursor-default" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo lang('Default language') ?>">
                    	<i class="fa fa-font fa-fw"></i> 
                    	<?php 
    						switch(strtolower(get_value($user, 'lang_default'))) {
    							case 'en_us':
    								echo lang('English');
    							break;
    							
    							case 'pt_br':
    							default:
    								echo lang('Brazilian Portuguese');
    							break;
    						} 
    					?>
                    </span>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top:20px">
            <div class="col-sm-12">
                <h4><?php echo lang('Description') ?></h4>
                <p>
                	<?php 
                	if(get_value($user, 'description') != '') {
                		echo get_value($user, 'description');
                	} else { 
                		echo '<em class="text-muted">' . lang('There is no description') . '</em>'; 
                	}
                ?>
                </p>
            </div>
        </div>

        <div class="row" style="margin-top:20px">
            <div class="col-sm-12">
                <h4><?php echo lang('Access history') ?></h4>
                <div id="morris-area-chart"></div>
            </div>
        </div>

    </div>

</div>

<script>
    // tooltips
    $('body').tooltip({ selector: "[data-toggle=tooltip]" });
</script>

<style>
    #user-profile-badges {
        line-height:30px;
    }

    .user-profile-actions {
        margin-top: 20px;
    }

    .user-profile-actions a {
        margin-bottom: 10px !important;
    }

    .user-profile-img {
        width: 140px;
        height: 140px;
        background-size: cover;
        border-radius: 100px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
    }

    .user-profile-sidebar {
        width:150px;
        position:absolute;
    }

    .user-profile-main-content {
        margin-left:180px;
    }

    /* Mobile devices */
    @media(max-width: 768px){

        #user-profile-name h1 {
            text-align: center;
            font-size:30px;
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name a {
            display:none;
        }

        #user-profile-badges {
            text-align:center;
        }

        .user-profile-sidebar {
            width:100%;
            position:relative;
        }

        .user-profile-main-content {
            margin-left:0;
        }

        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 120px;
            width: 120px;
        }

        .list-user-info {
            margin: 2px 0 0 105px !important
        }
    }

    /* Mobile portrait */
    @media(max-width: 480px){
        .user-profile-sidebar {
            width:100%;
        }

        .dropdown-user {
            left:0;
            margin-right:-25px !important;
        }

        #user-profile-name h1 {
            text-align: center;
            font-size:30px;
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name button {
            display:none;
        }

        #user-profile-badges {
            text-align:center;
        }


        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 110px;
            width: 110px;
        }
    }

    /* Tablet and large desktops */
    @media(min-width: 768px) and (max-width: 991px) {
        .user-profile-sidebar {
            width:100%;
            position:relative;
        }

        .user-profile-main-content {
            margin-left:0;
        }

        .user-profile-actions {
            margin-top:0;
        }

        .user-profile-sidebar img {
            height: 120px;
            width: 120px;
        }

        #user-profile-name h1  {
            margin: 30px 0 0 0 !important;
        }

        #user-profile-name button {
            margin: 35px 0 0 0 !important;
        }
    }
<style>