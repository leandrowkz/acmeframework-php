<?php
/**
* --------------------------------------------------------------------------------------------------
*
* message.php
* 
* This HTML component build an application message.
*
* It is loaded by the call $this->template->message($type, $title, $description, $close, $style);
*
* Or by the function loaded by template helper, called message($type, $title, $description, $close, $style);
*
* @param    string $type 	// info, warning, danger|error, success, note
* @param 	string $title
* @param 	string $description
* @param 	boolean $close
* @param 	string $style
* @since    28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
?>
<?php

$type = ($type != 'info' && $type != 'warning' && $type != 'error' && $type != 'danger' && $type != 'success' && $type != 'note') ? 'info' : $type;

$type = ($type == 'error') ? 'danger' : $type;

$style = $style != '' ? ' style="' . $style . '"' : '';

?>
<div class="alert alert-<?php echo $type ?> <?php echo ($close) ? ' alert-dismissable' : ''; ?>" <?php echo $style ?> >
	
	<?php if( ($close) ) { ?> 
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php } ?>

	<?php if( $title != '') { ?>
	<strong><?php echo $title ?></strong>
	<?php } ?>
	<?php echo $description ?>

</div>
