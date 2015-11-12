<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component header-assets.php
 *
 * This HTML component returns all default assets needed for this template. It used inside <head></head>.
 *
 * @since   02/07/2015
 * --------------------------------------------------------------------------------------------------
 */
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo APP_NAME ?></title>

<!-- Core Scripts - Include with every page -->
<script src="<?php echo URL_JS ?>/jquery-2.1.3.min.js"></script>
<script src="<?php echo URL_CSS ?>/bootstrap/js/bootstrap.min.js"></script>

<!-- App Scripts - Include with every page -->
<script src="<?php echo URL_JS ?>/app-functions.js"></script>

<!-- CSS Assets - Include with every page -->
<link href="<?php echo URL_CSS ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URL_CSS ?>/bootflat/css/bootflat.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URL_CSS ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<!-- Plugins Section -->

<!-- Bootbox Plugin -->
<script src="<?php echo URL_JS ?>/bootbox/bootbox.min.js"></script>

<!-- MagicSuggest Plugin -->
<link href="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL_JS ?>/magicsuggest/magicsuggest-min.js"></script>

<!-- ValidationEngine Plugin -->
<link href="<?php echo URL_JS ?>/validationEngine/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL_JS ?>/validationEngine/js/jquery.validationEngine.js"></script>
<script src="<?php echo URL_JS ?>/validationEngine/js/languages/jquery.validationEngine-<?php echo $this->session->userdata('language') ?>.js"></script>

<!-- Meiomask Plugin -->
<script src="<?php echo URL_JS ?>/jquery-meiomask/meiomask.js"></script>

<!-- Plugins Section -->

<!-- CSS Template - Override other styles -->
<link href="<?php echo URL_TEMPLATE ?>/styles.css" rel="stylesheet" type="text/css" />