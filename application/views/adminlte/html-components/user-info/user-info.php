<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component user-info.php
 *
 * This HTML block contain all user information (like name, email, group, etc).
 *
 * It is loaded by the call $this->template->load_user_info();
 *
 * @param    int $id_user
 * @param    string $login
 * @param    string $email
 * @param    string $user_name
 * @param    string $user_group
 * @param    string $user_img
 * @since    28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
?>

<?php
// Get language
$lang = $this->session->userdata('language');

// User first name
$first_name = get_value(explode(' ', $user_name), '0');

// Image adjustment (in case that image doesnt exist)
$user_img = ( ! file_exists(PATH_UPLOAD . '/user-photos/' . basename($user_img)) || basename($user_img) == '') ? URL_IMG . '/user-unknown.png' : $user_img;

?>

<div class="navbar-custom-menu">

    <ul class="nav navbar-nav">

        <li class="dropdown user user-menu">

            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $user_img ?>" class="user-image" />
                <span class="hidden-xs"><?php echo $first_name ?></span>
            </a>

            <ul class="dropdown-menu">

                <!-- User image -->
                <li class="user-header">
                    <img src="<?php echo $user_img ?>" class="img-circle" />
                    <p>
                        <strong><?php echo $user_name ?></strong><br />
                        <?php echo $user_group ?>
                        <small><i class="fa fa-fw fa-envelope-o"></i> <?php echo $email ?></small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo $id_user ?>" class="btn btn-default btn-flat"><i class="fa fa-fw fa-user"></i> <?php echo lang('Profile') ?></a>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo URL_ROOT ?>/app-login/logout" class="btn btn-default btn-flat"><?php echo lang('Logout') ?> <i class="fa fa-fw fa-sign-out"></i></a>
                    </div>
                </li>
            </ul>

        </li>

        <!-- Control Sidebar Toggle Button -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>

            <!-- Settings -->
            <ul class="dropdown-menu">

                <li>
                    <a class="layout-boxed-toggle cursor-pointer">
                        <i class="fa fa-fw <?php echo $this->input->cookie('body-layout') == 'layout-boxed' ? 'fa-check-square' : 'fa-square'; ?> text-danger"></i>
                        <?php echo lang('Boxed Layout') ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0)" class="change-language" id="en_US">
                        <i class="fa fa-fw text-danger <?php echo $lang == 'en_US' ? 'fa-dot-circle-o' : 'fa-circle-o'; ?>"></i>
                        <?php echo lang('English') ?>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="change-language" id="pt_BR">
                        <i class="fa fa-fw text-danger <?php echo $lang == 'pt_BR' ? 'fa-dot-circle-o' : 'fa-circle-o'; ?>"></i>
                        <?php echo lang('Brazilian Portuguese') ?>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="http://www.acmeframework.org" target="_blank">
                        <i class="fa fa-question-circle fa-fw"></i>
                        <?php echo lang('Help') ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL_ROOT ?>/app-login/logout">
                        <i class="fa fa-sign-out fa-fw"></i>
                        <?php echo lang('Logout') ?>
                    </a>
                </li>

            </ul>
        </li>

    </ul>

</div>

<script>

    // Bind container html click
    $('.change-language').on('click', function(e) {
        $.change_language($(this).attr('id'));
    });

    // Bind container html click
    $('.layout-boxed-toggle').on('click', function(e) {

        // Prevent clicking
        e.preventDefault();

        // Toggle container
        $.layout_boxed();

        // Build a pretty checkbox
        $(this).find('i').toggleClass('fa-check-square fa-square');

        return false;
    });

</script>