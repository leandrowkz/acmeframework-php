<hr style="margin:10px 0" />
<div style="border: 3 px solid #ccc; background-color:#f5f5f5;padding:10px 15px;">
<?php 
	$i = 1;
	foreach($errors as $error) {
		echo '<h6>' . lang('Instrução número ') . get_value($error, 'INSTRUÇÃO') . lang(' do pacote:') . '</h6>';
		echo '<div style="margin-top:5px;" class="font_11">' . nl2br(get_value($error, 'description')) . '</div>';
		echo '<br /><br />';
		$i++;
	}
?>
</div>