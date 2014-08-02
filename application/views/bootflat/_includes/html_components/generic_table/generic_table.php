<?php
/**
* --------------------------------------------------------------------------------------------------
*
* generic_table.php
* 
* This HTML component build the given table for object $array_table. Is is loaded when the call
* $this->array_table->get_html(); is triggered.
*
* @param    object $array_table
* @since    28/06/2013
*
* --------------------------------------------------------------------------------------------------
*/
?>

<?php if( count($array_table->data) > 0 ) { ?>

<div class="table-responsive">
	
	<div class="dataTables_wrapper form-inline" role="grid">
		
		<table class="table table-hover table-bordered no-footer <?php echo $array_table->class ?>" id="<?php echo $array_table->id ?>">
            
            <thead>
                    
                <tr role="row">

                    <?php
                    // add columns before
                    for( $i = 0; $i < count($array_table->columns_before); $i++ ) { ?>
	    			    <th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>
                    <?php } ?>

                    <?php 
	    			// proccess table header
	    			foreach ($array_table->data[0] as $index => $value) { ?>
	    				<th class="sorting" tabindex="0" rowspan="1" colspan="1"><?php echo  $index ?></th>
                    <?php } ?>

                    <?php
	    			// add columns after
                    for( $i = 0; $i < count($array_table->columns_after); $i++ ) { ?>
	    			    <th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>
                    <?php } ?>

          		</tr>

          	</thead>

            <tbody>

                <?php
          		// now, proccess table lines
          		foreach ($array_table->data as $data) { ?>
          			<tr class="gradeA">

                    <?php    
          			// process columns before
          			foreach($array_table->columns_before as $index => $value) { ?>
          				<td><?php echo array_tag_replace($value, $data) ?></td>
                    <?php } ?>

                    <?php
          			// process columns from table data
          			foreach ($data as $column => $value) { ?>
          				<td><?php echo $value ?></td>
                    <?php } ?>

                    <?php
          			// process columns after
          			foreach($array_table->columns_after as $index => $value) { ?>
          				<td><?php echo array_tag_replace($value, $data) ?></td>
                    <?php } ?>

          			</tr>
          		<?php } ?>

      		</tbody>

      	</table>

    </div>

</div>
    
<link type="text/css" rel="stylesheet" href="<?php echo URL_CSS ?>/plugins/dataTables/dataTables.bootstrap.css" />

<script src="<?php echo URL_JS ?>/plugins/dataTables/jquery.dataTables.js"></script>
    
<script src="<?php echo URL_JS ?>/plugins/dataTables/dataTables.bootstrap.js"></script>
    
<script>

	$("#<?php echo $array_table->id ?>").dataTable();

</script>

<?php } else { echo message('info', '', lang('There is no content for this query')); } ?>
