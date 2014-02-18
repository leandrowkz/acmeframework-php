<?php
/**
* generic_table()
* Monta uma tabela genérica tendo como base um objeto do tipo array_table. O objeto da tabela é
* setado e montado anteriormente, e no método ->process() este componente generic_table é invocado.
* @param object array_table
* @return string html
*/
function generic_table($array_table = array())
{
	$html = '';
	
	if($array_table->data != '' && isset($array_table->data) && count($array_table->data) > 0)
	{
		// Monta os parâmetros a serem encaminhados para a montagem da Grid
		$id = $array_table->id;
		$class = $array_table->class;
		$data = $array_table->data;
		$count_data = count($array_table->data);
		$columnsBefore = $array_table->columnsBefore;
		$columnsAfter = $array_table->columnsAfter;
		$total_columns = count($array_table->columns);
		$objResult = $array_table->data;
		$objRSHead = $array_table->data;
		
		// Cria o layout da tabela
		$auxColNumbers = 0;
		$colNumber     = 0;
		$linhas        = array();
		$counter_total_columns = 0;
		
		// Inicializa variável que será uitilziada
		// para desabilitar sorter nas colunas de imagens, before e after
		$noSorterColumns = '';
		
		// Valores class e ID
		$classTable = (!is_null($class) && $class != '') ? 'class="table_sorter ' . $class .'" ' : 'class="table_sorter"';
		$idTable = (!is_null($id) && $id != '') ? 'id="' . $id . '" ' : '';
		
		// Calcula total de páginas e items por página (50 default), página atual e link da pagina atual
		$diffPages    = 4;
		$actualPage   = $array_table->actual_page;
		$itemsPerPage = $array_table->items_per_page;
		$totalPages   = ceil(($count_data / $itemsPerPage));
		$totalPages   = ($totalPages == 0) ? 1 : $totalPages;
		
		// Link da pagina
		$page_link = URL_ROOT . '/' . $array_table->page_link . 'index';
		
		$html  = '<div>';
		$html .= '<div class="inline middle left" style="margin:0 0 10px 0;"><h5 class="font_shadow_gray inline top">' . lang('Resultados da Consulta') . '</h5> <div class="inline top comment font_11" style="margin:4px 0 0 5px">' . $count_data . ' ' . lang('registro(s)') . '</div></div>';
		
		// Adiciona a linha de paginação
		// Adiciona elemento html responsável por paginação
		if($totalPages > 1)
		{
			$html .= '<div id="pagination_area" class="inline top" style="float:right;margin:-45px 0 0 0;">';
			for($auxCounter = 1; $auxCounter <= $totalPages; $auxCounter++)
			{
				
				if($auxCounter == 1 || $auxCounter == $totalPages || $auxCounter == $actualPage || (($auxCounter >= ($actualPage - $diffPages) && $auxCounter < $actualPage) || ($auxCounter <= ($actualPage + $diffPages) && $auxCounter > $actualPage) ))
				{
					if($auxCounter == $totalPages && $totalPages > ($actualPage + $diffPages + 1))
					{
						$html .= '<div id="link_no_pagination">. . .</div>';
					}
					$actualPageStyle = ($actualPage == $auxCounter) ? 'class="actual_link"' : '';
					$html .= '<a id="link_paginator" href="javascript:void(0);" onclick="set_form_filter_action(\'' . $page_link . '/' . $auxCounter . '\');"><div id="link" ' . $actualPageStyle . '>' . $auxCounter . '</div></a>';
					if($auxCounter == 1 && $actualPage > ($diffPages + 2))
					{
						$html .= '<div id="link_no_pagination">. . .</div>';
					}
				}
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		
		// Começa a montar a tabela
		$html .= "\n<table " . $idTable . $classTable . ">";
		$html .= "\n<thead>";
		$html .= "\n\t<tr>";
		
		// Monta cabeçalho das colunas adicionais
		$iCounterBefore = count($columnsBefore);
		if($iCounterBefore > 0)
		{
			for($auxCounter = 0; $auxCounter < $iCounterBefore; $auxCounter++)
			{
				$html .= "\n\t<th></th>";
				$noSorterColumns .=  $auxCounter . ": { sorter: false },";
				
				// Para desabilitar o ordenação das colunas anteriores e posteriores
				$counter_total_columns++;
			}
		}
		
		// Monta cabeçalho das colunas do sql
		$i = 0;
		foreach($objRSHead as $auxHeadIndex => $auxHeadValue)
		{
			// print_r($auxHeadValue);
			foreach($auxHeadValue as $head_index => $head_value)
			{
				if($i == 0)
				{
					if(($colNumber % 2) == 0)
					{
						// print_r($auxHeadValue);
						if($total_columns > 0)
						{
							// echo($head_index . '<br />');
							if(in_array(strtolower($head_index), $array_table->columns, true) || in_array($auxColNumbers, $array_table->columns))
							{
								$html .= "\n\t<th><h6>" . $head_index . "</h6></th>";
								
								// Diz quais colunas que de fato devem ser colocadas nas linhas
								$linhas[] = $auxColNumbers;
								
								// Conta colunas do meio
								$counter_total_columns++;
							}
						} else {
							$html .= "\n\t<th><h6>" . $head_index . "</h6></th>";
							
							// Conta colunas do meio
							$counter_total_columns++;
						}
						$auxColNumbers++;
					}
				}
			}
			$i++;
			$colNumber++;
		}
		
		// Para desabilitar o ordenação das colunas anteriores e posteriores
		$counter_total_columns += $colNumber;
		
		// Monta cabeçalho das colunas adicionais posterior
		$iCounterAfter = count($columnsAfter);
		if($iCounterAfter > 0)
		{
			// Tem de desabilitar a primeira coluna (ordernação)
			$noSorterColumns .=  ($counter_total_columns - 1) . ": { sorter: false },";
			for($auxCounter = 0; $auxCounter < $iCounterAfter; $auxCounter++)
			{
				$html .= "\n\t<th></th>";
				$noSorterColumns .=  ($counter_total_columns + $auxCounter) . ": { sorter: false },";
			}
		}
		
		$html .= "\n\t</tr>";
		$html .= "\n</thead>";
		
		// Começa a montar o corpo da tabela
		$html .= "\n<tbody>";
		
		// Variavel auxiliar para fazer linhas cor sim, não
		$i = 1;
		
		// Variável de contagem para LINHAS
		$count_linhas = count($linhas);
		
		// Define o range dos registros que serao exibidos nessa tela
		$range_data_fim = $array_table->actual_page * $array_table->items_per_page;
		$range_data_ini = $range_data_fim - ($array_table->items_per_page - 1);
		
		// Varre o SQL para montar linhas
		foreach($objResult as $objRS)
		{
			if($i >= $range_data_ini && $i <= $range_data_fim)
			{
				$class = (($i % 2) == 0) ? ' class="odd"' : '';
				$html .= "\n\t<tr" . $class . ">";
				
				// Colunas adicionais primárias
				if($iCounterBefore > 0)
				{
					for($auxCounter = 0; $auxCounter < $iCounterBefore; $auxCounter++)
					{
						// O trecho abaixo faz a substituição das tags custom do core
						// pelo valor correspodente da coluna do sql da linha atual
						// Faz o match para ver se uma tag custom foi encontrada
						$html .= "\n\t<td id=\"column_before\">" . replace_tag($columnsBefore[$auxCounter], $objRS) . "</td>";
					}
				}
				
				// Colunas do SQL
				$counter_column = 0;
				foreach($objRS as $index => $value)
				{
					if($total_columns > 0)
					{
						if(in_array($counter_column, $linhas) || $count_linhas == 0)
						{
							$html .= "\n\t<td id=\"column_middle\">" . htmlspecialchars($value) . "</td>";
						}
					} else {
						$html .= "\n\t<td id=\"column_middle\">" . htmlspecialchars($value) . "</td>";
					}
					$counter_column++;
				}
				
				// Colunas adicionais posteriores
				if($iCounterAfter > 0)
				{
					for($auxCounter = 0; $auxCounter < $iCounterAfter; $auxCounter++)
					{
						// O trecho abaixo faz a substituição das tags custom do core
						// pelo valor correspodente da coluna do sql da linha atual
						$html .= "\n\t<td id=\"column_after\">" . replace_tag($columnsAfter[$auxCounter], $objRS) . "</td>";
					}
				}
				
				// Fecha a linha
				$html .= "\n\t</tr>";
			}
			$i++;
		}
		
		// Fecha table
		$html .= "\n</tbody>";
		$html .= "\n</table>";
		
		// Adiciona elemento html responsável por paginação
		if($totalPages > 1)
		{
			$html .= '<div id="pagination_area">';
			for($auxCounter = 1; $auxCounter <= $totalPages; $auxCounter++)
			{
				
				if($auxCounter == 1 || $auxCounter == $totalPages || $auxCounter == $actualPage || (($auxCounter >= ($actualPage - $diffPages) && $auxCounter < $actualPage) || ($auxCounter <= ($actualPage + $diffPages) && $auxCounter > $actualPage) ))
				{
					if($auxCounter == $totalPages && $totalPages > ($actualPage + $diffPages + 1))
					{
						$html .= '<div id="link_no_pagination">. . .</div>';
					}
					$actualPageStyle = ($actualPage == $auxCounter) ? 'class="actual_link"' : '';
					$html .= '<a id="link_paginator" href="javascript:void(0);" onclick="set_form_filter_action(\'' . $page_link . '/' . $auxCounter . '\');"><div id="link" ' . $actualPageStyle . '>' . $auxCounter . '</div></a>';
					if($auxCounter == 1 && $actualPage > ($diffPages + 2))
					{
						$html .= '<div id="link_no_pagination">. . .</div>';
					}
				}
			}
			$html .= '</div>';
		}
		
		// Processa os noSorters para colunas iniciais e finais
		$noSorterColumns = trim($noSorterColumns, ',');
		$noSorter = ($noSorterColumns != '') ? '{ headers: { ' . $noSorterColumns . ' } }' : '';
		$html .= "\n" . '<script type="text/javascript" language="javascript">$(document).ready(function() { $("#' . $id . '").tablesorter(' . $noSorter . '); } );</script>';
	} else {
		$CI =& get_instance();
		$CI->load->library('acme/template');
		$html  = '<div class="inline middle left" style="margin:0 0 10px 0;"><h5 class="font_shadow_gray inline top">' . lang('Resultados da Consulta') . '</h5></div>';
		$html .= message('info', 'Consulta vazia', 'Esta consulta não retornou nenhum registro.');
	}
	
	return $html;
}