<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo APP_NAME ?></title>

<!-- Core CSS - Include with every page -->
<link href="<?php echo URL_CSS ?>/bootstrap.css" rel="stylesheet">

<!-- ACME CSS - Include with every page -->
<link href="<?php echo URL_CSS ?>/app-core.css" rel="stylesheet">

</head>

<body>
	
	<p><strong><?php echo lang('Olá') ?>, <?php echo get_value($user, 'name') ?></strong></p>

	<p><?php echo lang('Utilize este email para atualizar sua senha de acesso ao sistema. Verifique abaixo seus dados de acesso e caso existam divergências, descarte esta mensagem e solicite o reenvio novamente.')?></p>
		
	<div>

		<label><?php echo lang('Seu e-mail') ?>:</label>
		<?php echo get_value($user, 'email') ?>

	</div>

	<p><?php echo lang('Para atualizar sua senha de acesso, clique')?> <a href="<?php echo URL_ROOT ?>/app_access/reset_password/<?php echo get_value($user, 'id_user') ?>/<?php echo $key_access; ?>" target="_blank"><?php echo lang('aqui') ?></a>.</p>
	<p>
		<?php echo lang('Caso você tenha problemas de acesso com o link acima, copie a URL abaixo e cole em uma nova aba do seu navegador:')?>
		<br />
		<?php echo URL_ROOT ?>/app_access/reset_password/<?php echo get_value($user, 'id_user') ?>/<?php echo $key_access; ?>
	</p>
		
</body>
</html>


