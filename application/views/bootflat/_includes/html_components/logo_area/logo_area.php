<?php
/**
* --------------------------------------------------------------------------------------------------
*
* logo_area.php
* 
* This HTML component build a logo area that will contain application logo inside it.
*
* It is loaded by the call $this->template->load_logo_area();
*
* @param 	string $url		// user's url default (home)
* @since 	28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
?>
<?php if( ! file_exists(URL_IMG . '/logo.png') ) { ?>
	<div class="navbar-brand"><a href="<?php echo $url ?>"><?php echo APP_NAME ?></a></div>
<?php } else { ?>
	<div class="navbar-brand"><a href="<?php echo $url ?>"><img src="<?php echo  URL_IMG ?>/logo.png" /></a></div>
<?php } ?>