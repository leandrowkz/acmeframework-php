<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
<div>
	<!-- CABEÇALHO DO MÓDULO e MENUS -->
	<div id="module_header">
		<div id="module_rotule" class="inline top">
			<h2 class="inline top font_shadow_gray"><a class="black" href="<?php echo URL_ROOT . '/' . $this->controller ?>/dashboard"><?php echo lang('Projetos'); ?></a></h2>
			<?php if($this->url_img != '') {?>
			<img src="<?php echo $this->url_img ?>" />
			<?php } ?>
		</div>
		<!-- MENUS DO MODULO -->
		<div id="module_menus" class="inline top">
			<div class="inline top module_menu_item" style="margin-top:-14px">
				<button class="green rounded" style="margin:0 !important;min-width:230px" onclick="iframe_modal('<?php echo lang('Novo projeto')?>', '<?php echo URL_ROOT ?>/project/modal_project_new/', '<?php echo URL_IMG ?>/icon_project.png', 800, 600)">
					<img class="inline top" src="<?php echo URL_IMG ?>/icon_insert_white.png" style="width:20px;margin:9px 3px 0 0;float:none;" />
					<h4 class="inline top"><?php echo lang('Novo Projeto') ?></h4>
				</button>
			</div>
		</div>
	</div>
	
	<!-- DESCRICAO DO MODULO -->
	<div id="module_description"><h6>&nbsp;</h6></div>
	
	<!-- LISTA DE PROJETOS ATIVOS -->
	<style type="text/css">
		/* =================================================================================== */
		/*  PROJETOS - BLOCO DE ESTILOS CSS                                                    */
		/* =================================================================================== */
		.box-project {
			min-height:200px;
			width:100%;
			background-color:#f5f5f5;
			margin-bottom:80px;
			border-top:1px solid #bbb;
			border-bottom:1px solid #bbb;
		}
		
		.box-project-content {
			position:relative;
			padding:20px !important;
		}
		
		.project-logo {
			position:relative;
			margin-right:20px;
			width:100px;
			vertical-align:bottom !important;
			background-position:top center;
			z-index:9999;
		}
		
		.project-logo img {
			width:100px;
		}
		
		.project-logo:hover .project-logo-controls {
			display:block;
		}
		
		.project-logo-controls {
			transition: all 3s ease;
			-webkit-transition: all 3s ease;
			bottom:0%;
			z-index:9998;
			position:absolute;
			vertical-align:bottom !important;
			width:100%;
			padding:4px 0;
			font-size:11px;
			color:white;
			cursor:pointer;
			background-color:#000;
			opacity:0.8;
			/*margin:0 0 -19px 0 !important;*/
			display:none;
		}
		
		.box-project-controls {
			background-color:#333;
			padding:10px 0;
			border-bottom:2px solid #000;
		}
		
		.box-project-controls a {
			color:white !important;
			margin-left:20px
		}
		
		.box-project-controls div {
			cursor:pointer;
			float:right;
			margin:3px 15px 0 0
		}
		
		.box-project-activities {
			background-color:#fff;
			margin-top:5px;
			border:1px solid #777;
			min-height:50px;
			-moz-box-shadow:0 0 8px 1px #999;
			-webkit-box-shadow: 0 0 8px #999;
			box-shadow: 0px 0px 8px rgb(150,150,150);
			display:none;
		}
		
		.triangle-top-border {
			float:left;
			width: 0;
			height: 0;
			margin:-15px 0 0 40px;
			border-left: 12px solid transparent;
			border-right: 12px solid transparent;
			border-bottom: 17px solid #000;
		}
		
		.triangle-top {
			float:left;
			width: 0;
			height: 0;
			margin:-13px 0 0 -24px;
			border-left: 12px solid transparent;
			border-right: 12px solid transparent;
			border-bottom: 17px solid #fff;
		}
		
		/* =================================================================================== */
		/*  ATIVIDADES - BLOCO DE ESTILOS CSS                                                  */
		/* =================================================================================== */
		.line-activity {
			padding:5px 0px 5px 2px;
			cursor:pointer;
		}
		
		.line-activity:hover {
			background-color:#f5f5f5;
		}
		
		.line-activity .percentage-activity {
			float:right;
			margin:-29px 98px 0 0;
			width:65px;
			color:#888;
			cursor:default;
		}
		
		.details-activity {
			float:right;
			position:absolute;
			right:0%;
			margin:0px 51px 0 0;
		}
		
		.box-details-activity {
			cursor:default;
			display:none;
			position:absolute;
			z-index:10000;
			margin:-90px 0 0 -425px;
		}
		
		.details-activity .btn-control {
			cursor:pointer;
			font-size:08px;
			color:#fff;
			background-color:#000;
			padding:3px 4px;
			letter-spacing:1px;
			text-align:center;
			min-width:55px;
			margin:-22px 6px 0 0;
		}
		
		.details-activity .btn-control:hover {
			background-color:#444;
		}
		
		.activity-balloon-estimate {
			position:absolute;
			min-width:135px;
			margin:-18px 0 0 -140px !important;
			background-color:#000;
			color:#fff;
			padding:5px 10px;
			line-height:18px;
			display:none;
		}
		
		.activity-balloon-estimate img {
			float:right;
			margin:19px -18px 0 0;
		}
		
		
		/* =================================================================================== */
		/*  TAREFAS - BLOCO DE ESTILOS CSS                                                     */
		/* =================================================================================== */
		.line-task:hover {
			background-color:#f5f5f5;
		}
		
		.line-task .details-task {
			float:right;
		}
		
		.line-task .details-task .btn-control {
			min-width:55px;
			margin:3px 3px 0 0;
			cursor:pointer;
			font-size:08px;
			color:#fff;
			background-color:steelblue;
			padding:3px 4px;
			letter-spacing:1px;
			text-align:center;
		}
		
		.line-task .details-task .btn-control:hover {
			background-color:#729abc;
		}
		
		.msg-delayed {
			cursor:default;
			margin:3px 3px 0 0;
			float:right;
			/*background-color:#EEAD0E;*/
			color:#B22222;
			padding:3px 4px;
			letter-spacing:1px;
			font-size:08px;
		}
		
		.box-details-task {
			display:none;
			position:absolute;
			z-index:10000;
			margin:-90px 0 0 -425px;
		}
		
		.line-task .percentage-task {
			float:right;
			width:60px;
			padding:3px 0;
			margin:0 29px 0 0;
			color:#000;
			cursor:default;
			text-align:center;
		}
		
		.line-task .situation-task {
			float:right;
			margin:3px 11px 0 0;
			min-width:80px;
			color:#888;
		}
		
		.task-balloon-estimate {
			position:absolute;
			min-width:135px;
			margin:-23px 0 0 -140px;
			background-color:#000;
			color:#fff;
			padding:5px 10px;
			line-height:18px;
			display:none;
		}
		
		.task-balloon-estimate img {
			float:right;
			margin:18px -18px 0 0;
		}
		
		.btn-new-task a {
			cursor:pointer;
			font-size:09px;
			color:#2E8B57;
		}
		
		.btn-new-task a:hover {
			color:#3CB371;
		}
		
		.task-line-action {
			padding:2px 3px;
		}
		
		.task-line-action:hover {
			background-color:#f5f5f5;
		}
		
		.task-line-action img {
			float:left;
			width:12px;
			margin:4px 7px  0 0px;
		}
	</style>
	
	<div id="box-projects"></div>
	<?php foreach($projects as $project) { ?>
	<script type="text/javascript" language="javascript"> load_project_line(<?php echo get_value($project, 'id_project') ?>); </script>
	<?php } ?>
</div>