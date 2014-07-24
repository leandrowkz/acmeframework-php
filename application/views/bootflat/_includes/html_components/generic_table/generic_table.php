<?php
/**
*
* generic_table()
*
* Builds a generic HTML table with the given data from array_table object. When the process() method
* is called, this component is loaded.
*
* This component uses the plugin dataTables for better improvement and features.
*
* @param object array_table
* @return string html
*
*/
function generic_table($array_table = array())
{
    
    if( count($array_table->data) > 0 ) {
	
	$html = '
	<div class="table-responsive">
	
		<div class="dataTables_wrapper form-inline" role="grid">
		
			<table class="table table-hover table-bordered no-footer ' . $array_table->class . '" id="' . $array_table->id . '">
                
                <thead>
                    
                    <tr role="row">';

	                    // add columns before
	                    for( $i = 0; $i < count($array_table->columns_before); $i++ )
	    					$html .= '<th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>';

	    				// proccess table header
	    				foreach ($array_table->data[0] as $index => $value)
	    					$html .= '<th class="sorting" tabindex="0" rowspan="1" colspan="1">' . $index . '</th>';

	    				// add columns after
	                    for( $i = 0; $i < count($array_table->columns_after); $i++ )
	    					$html .= '<th tabindex="0" rowspan="1" colspan="1" style="width: 01%"></th>';

          			$html .= '
          			</tr>

          		</thead>

          		<tbody>';

          		// now, proccess table lines
          		foreach ($array_table->data as $data) {

          			$html .= '
          			<tr class="gradeA">';

          			// process columns before
          			foreach($array_table->columns_before as $index => $value)
          				$html .= '<td>' . array_tag_replace($value, $data) . '</td>';

          			// process columns from table data
          			foreach ($data as $column => $value)
          				$html .= '<td>' . $value . '</td>';

          			// process columns after
          			foreach($array_table->columns_after as $index => $value)
          				$html .= '<td>' . array_tag_replace($value, $data) . '</td>';

          			$html .= '
          			</tr>';
          		}

          		$html .= '
          		</tbody>

          	</table>

        </div>

    </div>';

    // now the motherf*** script 
    $html .= '
    
    <link type="text/css" rel="stylesheet" href="' . URL_CSS . '/plugins/dataTables/dataTables.bootstrap.css" />
    <script src="' . URL_JS . '/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="' . URL_JS . '/plugins/dataTables/dataTables.bootstrap.js"></script>
    
    <script>

    	$("#' . $array_table->id . '").dataTable();
    
    </script>';
	
	} else { 
		$html = message('info', '', lang('There is no content for this query'));
	}
	
	return $html;
}