<!DOCTYPE html>
<html>
<head>

    <?php echo $this->template->load_html_component('header-assets'); ?>

    <style>
        body { padding: 30px; }
        h1, h2, h3, h4 { margin: 0 0 20px; }
        h5 { margin: 0 0 5px; }
        .panel-body { padding: 30px; }
    </style>

</head>

<body>

    <div class="panel panel-default">

        <div class="panel-body">

    		<h3 class="hidden-lg hidden-md"><?php echo lang('An Error was encountered')?></h3>
    		<h1 class="hidden-xs hidden-sm"><?php echo lang('An Error was encountered')?></h1>
    		<h4><?php echo lang('Do not worry, this problem was already forwarded to correction.')?></h4>
    		<?php if(ENVIRONMENT != 'production') { ?>
    		<div class="text-danger" style="margin-bottom:20px">
    			<h5><strong><?php echo lang('Tecnical details')?></strong></h5>
    			<?php
    			if(is_array($message)) {
    				foreach($message as $msg)
    					if($msg != '')
    						echo '<div>&bull;&nbsp;' . $msg . '</div>';
    			} else {
    				echo '<div>&bull;&nbsp;' . $message . '</div>';
    			}
    			?>
    		</div>
    		<?php } ?>

    		<?php $url = $this->session->userdata('url_default') ? $this->session->userdata('url_default') : URL_ROOT; ?>
    		<a href="<?php echo $url ?>" class="btn btn-success btn-lg"><?php echo lang('Initial page')?> <i class="fa fa-arrow-circle-right fa-fw"></i></a>

    	</div>

    </div>

    <script type="text/javascript">

        // ======================
        // Initialize Material.js
        // ======================
        $.material.init();

    </script>

</body>

</html>
