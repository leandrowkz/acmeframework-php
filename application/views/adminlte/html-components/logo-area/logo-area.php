<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component logo-area.php
 *
 * This HTML component build a logo area that will contain application logo inside it.
 *
 * It is loaded by the call $this->template->load_logo_area();
 *
 * @param 	string $url		// user's url default (home)
 * @since 	28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
?>

<?php if( ! file_exists(PATH_IMG . '/logo.png') ) { ?>

    <a href="<?php echo $url ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini text-bold"><?php echo substr(APP_NAME, 0, 1) ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg text-bold"><?php echo APP_NAME ?></span>
    </a>

<?php } else { ?>

    <a href="<?php echo $url ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini text-bold"><?php echo substr(APP_NAME, 0, 1) ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="<?php echo  URL_IMG ?>/logo.png" /></span>
    </a>

<?php } ?>
