<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo APP_TITLE; ?></title>
	<?php echo $this->template->load_array_config_js_files(); ?>
	<?php echo $this->template->load_array_config_css_files(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo URL_IMG ?>/_favicon.ico">
	<script type="text/javascript" language="javascript">
		$(document).ready(function () {
			$('body').layout({ applyDemoStyles: true });
		});		
	</script>
</head>
<body>
	<?php echo $this->template->load_menu() ?>
	<div class="ui-layout-west" style="background-color:#f5f5f5">
		<div style="margin:60px 5px 20px 5px">
			<?php echo $this->template->load_logo_area(); ?>
			<?php echo $this->template->load_user_info(); ?>
		</div>
	</div>
	<div class="ui-layout-center">
		<div style="margin:60px 20px 20px 20px;">
		<div><?php echo message('warning', lang('ATENÇÃO!') , $message); ?></div>
		
		<?php if($link_to_back != '') {?>
		<div style="margin-top:35px">
			<hr />
			<div style="margin:10px 3px 0 0" class="inline top"><button onclick="redirect('<?php echo $link_to_back; ?>')"><?php echo lang('Voltar')?></button></div>
		</div>
		<?php } ?>
	</div>
</body>
</html>
