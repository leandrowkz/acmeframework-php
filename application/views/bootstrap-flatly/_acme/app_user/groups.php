<div class="row module-header">

    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <h1><?php echo lang($this->label) ?>
        <?php if($this->description != ''){ ?><small>// <?php echo lang($this->description)?></small> <?php } ?>
        </h1>
    </div>
    
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        
        <div class="btn-group pull-right clearfix">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-align-justify hidden-lg hidden-md"></i> 
                <div class="hidden-xs hidden-sm">
                    <i class="fa fa-align-justify"></i> 
                    <span><?php echo lang('Ações') ?></span> 
                    <span class="caret"></span>
                </div>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo URL_ROOT ?>/app_user/new_user"><i class="fa fa-plus-circle fa-fw"></i> <?php echo lang('Novo grupo')?></a></li>
                <li><a href="<?php echo URL_ROOT ?>/app_user"><i class="fa fa-arrow-circle-left fa-fw"></i> <?php echo lang('Voltar')?></a></li>
            </ul>
        </div>

    </div>
</div>

<div class="row" style="margin-bottom: 30px ">

    <div class="col-sm-12 col-md-6 col-lg-4">

        <div class="input-group" style="margin-bottom: 10px">
            <input type="text" id="search-groups" class="form-control input-sm" placeholder="<?php echo lang('Pesquisar grupos') ?>" autofocus>
            <span class="input-group-addon input-sm"><i class="fa fa-search fa-fw"></i></span>
        </div>

    </div>

</div>

<div class="table-responsive">

    <table class="table">
        
        <thead>
            <tr>
                <th><?php echo lang('Grupo') ?></th>
                <th><?php echo lang('Descrição') ?></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>

        <?php foreach($groups as $group) { ?>
        
            <tr class="group">

                <td>
                    <div class="label label-info cursor-pointer group-name"><?php echo get_value($group, 'name')?></div>
                </td>
                <td class="group-description"><?php echo get_value($group, 'description') ?></td>
                <td class="text-right" style="width: 01%" title="<?php echo lang('Remover')?>"><a href="javascript:void(0)" id="<?php echo get_value($group, 'id_user_group') ?>"><i class="fa fa-times fa-fw"></i></a></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<style>
    .label { font-size: 100%; }
</style>

<script>
    // tooltips
    $('body').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // input de pesquisa
    $("#search-groups").keyup( function() {
        
        var exist = false;
        
        if($("#search-groups").val().length > 2) {
            
            $('.group').each( function() {
                $(this).hide();                             
            });
            
            var search = $("#search-groups").val().toLowerCase();       
            
            $('.group-name, .group-description').each( function(index) {
            
                var text = $(this).html().toLowerCase();

                console.log(text);
                
                if(text.indexOf(search) != -1) {
                    exist = true;
                    $(this).closest('.group').show();
                }
            });
            
            if(exist == false)
                return;
        
        } else if($("#search-groups").val().length <= 2 || $("#search-groups").val().length == '') {
            $('.group').each(function(index) { 
                $(this).show();
            });
        }
    });
</script>