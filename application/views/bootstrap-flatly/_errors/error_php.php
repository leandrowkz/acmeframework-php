<?php if(ENVIRONMENT != 'production') {?>
<div id="box_error">
	<h5 class="fnt_error font_shadow_gray" style="margin:0;"><?php echo lang('Um erro PHP foi encontrado') ?></h5>
	<div class="bold" style="margin:10px 0"><?php echo $message; ?></div>
	<div class="font_11"><strong><?php echo lang('Arquivo') ?>: </strong> <?php echo $filepath; ?></div>
	<div class="font_11"><strong><?php echo lang('Linha') ?>: </strong> <?php echo $line; ?></div>
	<div class="font_11"><strong><?php echo lang('Gravidade') ?>: </strong> <?php echo $severity; ?></div>
</div>
<?php } ?>