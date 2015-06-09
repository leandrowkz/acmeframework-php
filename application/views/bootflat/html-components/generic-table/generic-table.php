<?php
/**
 * --------------------------------------------------------------------------------------------------
 * HTML Component generic-table.php
 *
 * This HTML component build the given table for object $array_table. Is is loaded when the call
 * $this->array_table->get_html(); is triggered.
 *
 * @param    object $array_table
 * @since    28/06/2013
 * --------------------------------------------------------------------------------------------------
 */
?>

<?php if( count($array_table->data) > 0 ) { ?>

<div class="table-responsive">

    <table class="table table-hover table-bordered no-footer <?php echo $array_table->class ?>" id="<?php echo $array_table->id ?>">
        <thead>
            <tr role="row">

                <?php
                // Add columns before
                for( $i = 0; $i < count($array_table->columns_before); $i++ ) { ?>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>

                <?php } ?>

                <?php
                // Proccess table header
                foreach ($array_table->data[0] as $index => $value) { ?>
                <th class="sorting" tabindex="0" rowspan="1" colspan="1"><?php echo  $index ?></th>

                <?php } ?>

                <?php
                // Add columns after
                for( $i = 0; $i < count($array_table->columns_after); $i++ ) { ?>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>

                <?php } ?>
            </tr>
        </thead>

        <tbody>

            <?php
            // Now, proccess table lines
            foreach ($array_table->data as $data) { ?>
            <tr class="gradeA">

                <?php
                // Process columns before
                foreach($array_table->columns_before as $index => $value) { ?>
                <td><?php echo array_tag_replace($value, $data) ?></td>
                <?php } ?>

                <?php
                // Process columns from table data
                foreach ($data as $column => $value) { ?>
                <td><?php echo $value ?></td>
                <?php } ?>

                <?php
                // Process columns after
                foreach($array_table->columns_after as $index => $value) { ?>
                <td><?php echo array_tag_replace($value, $data) ?></td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>

    </table>

</div>

<!-- DataTables Plugin -->
<script src="<?php echo URL_JS ?>/dataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL_JS ?>/dataTables/js/dataTables.bootstrap.js"></script>
<link href="<?php echo URL_JS ?>/dataTables/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet" />

<script>
    // =====================
    // Initialize DataTables
    // =====================
    $('#<?php echo $array_table->id ?>').dataTable({
        language: {
            search:         '<span class="input-group-addon input-md"><i class="fa fa-search fa-fw" data-original-title="" title=""></i></span>',
            lengthMenu:     "_MENU_ &nbsp;<?php echo lang('Entries')?>",
            info:           "<small class=\"text-muted\"><?php echo lang('Showing') ?> _START_ <?php echo lang('to') ?> _END_ <?php echo lang('of') ?> _TOTAL_ <?php echo lang('entries') ?></small>",
            infoEmpty:      "<small class=\"text-muted\"><?php echo lang('Showing') ?> 0 entries</small>",
            infoFiltered:   "<small class=\"text-muted\">(<?php echo lang('filtered from') ?> _MAX_ <?php echo lang('total entries') ?>)",
        },
        order: [[ 0, "asc" ]]
    });
</script>

<?php } else { echo message('info', '', '<i class="fa fa-fw fa-info-circle"></i> ' . lang('There is no content for this query') . '.'); } ?>
