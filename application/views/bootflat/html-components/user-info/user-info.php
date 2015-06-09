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

<li class="dropdown">

    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <img src="<?php echo $user_img ?>" class="img-circle user-photo" />
        <span class="user-info">
            <small><?php echo lang('Welcome') ?></small>
            <br /><?php echo $first_name ?>
        </span>
        <i class="fa fa-caret-down"></i>
    </a>

    <ul class="dropdown-menu dropdown-user">

        <li>
            <a href="<?php echo URL_ROOT ?>/app-user/profile/<?php echo $id_user ?>">
                <i class="fa fa-user fa-fw"></i>
                <?php echo lang('Profile') ?>
            </a>
        </li>
        <li>
            <a class="container-html cursor-pointer">
                <i class="fa fa-fw fa-square text-danger"></i>
                <?php echo lang('HTML Container') ?>
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

<script>

    // Bind container html click
    $('.change-language').on('click', function(e) {
        $.change_language($(this).attr('id'));
    });

    // Bind container html click
    $('.container-html').on('click', function(e) {

        // Prevent clicking
        e.preventDefault();

        // Toggle container
        $.container_html();

        // Build a pretty checkbox
        $(this).find('i').toggleClass('fa-check-square fa-square');

        return false;
    });

    // HTML container check
    $(document).ready( function () {

        if($.read_cookie('container-html') != null)
            $('.container-html').click();
    });

</script>