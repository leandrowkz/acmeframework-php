<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component image.php
 *
 * This HTML component build an img tag. It also check if the given url is a font-awesome icon
 * and them let it be (know more on fontawesome.github.io/Font-Awesome/)
 *
 * It is loaded by the call $this->template->image($url) or simply image($url);
 *
 * @param 	string $url_img
 * @since 	28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
?>

<?php

// Check if the given value is a font-awesome
if ( stristr($url_img, 'class="fa') || stristr($url_img, "class='fa") ) {

	echo $url_img;

} elseif ($url_img != '') { ?>

	<img src="<?php echo tag_replace($url_img) ?>" />

<?php } ?>
