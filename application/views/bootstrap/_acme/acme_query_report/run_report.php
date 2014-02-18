<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo lang(get_value($report, 'lang_key_rotule')) . ' | ' . APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
</head>
<body style="margin:0 20px">
	<h2 class="font_shadow_gray inline top" style="margin:10px 15px 0 0;"><?php echo lang(get_value($report, 'lang_key_rotule'));?></h2>
	<div id="module_menu" class="inline top" style="float:right; margin: 30px 5px 0px 0px">
		<div class="inline">
			<img src="<?php echo URL_IMG;?>/icon_csv.png" style="margin-top:2px;" />
			<a href="javascript:void(0);" onclick="download_excel('<?php echo URL_ROOT?>/acme_query_report/export_csv/<?php echo get_value($report, 'id_query_report')?>');" class="black inline " title="Exporte a lista total de registros para o formato CSV"><h5><?php echo lang('Exportar para .CSV')?></h5></a>
		</div>
		<div class="inline">
			<img src="<?php echo URL_IMG;?>/icon_print.png" style="margin:2px 0 0 25px;" />
			<a href="javascript:void();" class="black inline" title="Imprimir" onClick="window.print()"><h5><?php echo lang('Imprimir') ?></h5></a>
		</div>
	</div>
	<br />
	<h4 class="font_shadow_gray inline top" style="margin:20px 15px 0 0;"><?php echo get_value($report, 'description');?></h4>
	<hr style="margin:5px 0 40px 0" />
	<?php echo($module_table); ?>
</body>
</html>