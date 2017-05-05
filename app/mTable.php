<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
	if(!isset( $_GET['mDisplayStart'] )) 
		$_GET['mDisplayStart'] = 0; 
	if(!isset($_GET['mDisplayLength']))
		$_GET['mDisplayLength'] = 100;
	if(!isset($_GET['page']))
		$_GET['page'] = 1;
	if(!isset($_GET['sSearch']))
		$_GET['sSearch'] = '';

	if(!isset($_GET['iSortCol']) && !isset($_GET['sSortDir'])) 
	{
		$_GET['iSortCol'] = 2;
		$_GET['sSortDir'] = $_GET['pSortDir'] = 'asc';
	}else if(isset($_GET['pSortDir']) && $_GET['pSortDir'] != $_GET['sSortDir'])
		$_GET['pSortDir'] = $_GET['sSortDir'];

	function sIcon($sSortDir, $iSortCol, $rowNum) 
	{
		if($sSortDir == 'asc' && $iSortCol == $rowNum)
			$icon = ' <i class="fa fa-sort-alpha-desc"></i>';
		else if($sSortDir == 'desc'  && $iSortCol == $rowNum)
			$icon = ' <i class="fa fa-sort-alpha-asc"></i>';
		else
			$icon = '';
		return $icon;
	}	 
	
	function page_length_list($lengthMenu = null)
	{
		if($lengthMenu == null)
			$lengthMenu = array(100, 500, 1000);
		if(isset($_GET['sSearch']))
			$sSearch = '<input type="hidden" name="sSearch" value="'.$_GET['sSearch'].'">';
		else
			$sSearch = '';

		$pageLength = 	'<form class="form-inline" action="?" method="GET">
							<div class="form-group">
				    			<label for="mDisplayLength">Show </label>
				    			'.$sSearch.'
				    			<select class="form-control" name="mDisplayLength" id="mDisplayLength" onchange="this.form.submit()">'; 	
		foreach($lengthMenu AS $length) 
		{
			if($_GET['mDisplayLength'] == $length)	
				$pageLength .= '<option selected>'. $length .'</option>';
			else	 
				$pageLength .= '<option>'. $length .'</option>'; 
		}
			$pageLength .= 		'</select>
							</div>
						</form>';
		return $pageLength;
	}

	function display_search_bar() 
	{
		$search_bar = 	'<form class="form-inline" action="?" method="GET">
							<div class="form-group">
				    			<label for="col_name">Search: </label>
								<input class="form-control" name="sSearch">
							</div>
						</form>';
		return $search_bar;						
	}

	//PRINT LINKS
    function mPagination($links, $list_class, $total_rows=null, $url=null ) 
    {

        //get the last page number
        $last = ceil( $total_rows / $_GET['mDisplayLength'] );
        // starting page
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1; 
        
        //calculate start of range for link printing
        $start = ( ( $page - $links ) > 0 ) ? $page - $links : 1;
        
        //calculate end of range for link printing
        $end = ( ( $page + $links ) < $last ) ? $page + $links : $last;

        $row_start = ($page-1) * $_GET['mDisplayLength'];

		$startShowRow = (($row_start)+1);
		$endShowRow = (($row_start)+($_GET['mDisplayLength']));

		if($total_rows > $endShowRow)
			$endShowRow = $endShowRow;	
		else
			$endShowRow = $total_rows;

        $paginator = '<table border=0 width="100%">
                    <tr>
                        <td>
                            Showing '. $startShowRow .' to '. $endShowRow . ' of '. $total_rows .' entries
                        </td>
                        <td align="right">';

        //ul boot strap class - "pagination pagination-sm"
        $paginator .= '<ul class="' . $list_class . '">';

        $class = ( $page == 1 ) ? "disabled" : ""; //disable previous page link <<<
        
        //create the links and pass limit and page as $_GET parameters

        //$page - 1 = previous page (<<< link )
        $previous_page = ( $page == 1 ) ? 
        '<a href=""><li class="' . $class . '">Previous</a></li>' : //remove link from previous button
        '<li class="' . $class . '"><a href="?mDisplayStart='. $row_start .'&mDisplayLength=' . $_GET['mDisplayLength'] . '&page=' . ( $page - 1 ) . $url .'">Previous</a></li>';

        $paginator .= $previous_page;

        if ( $start > 1 ) { //print ... before (previous <<< link)
            $paginator .= '<li><a href="?mDisplayStart=0&mDisplayLength=' . $_GET['mDisplayLength'] . '&page=1'. $url .'">1</a></li>'; //print first page link
            $paginator .= '<li class="disabled"><span>...</span></li>'; //print 3 dots if not on first page
        }

        //print all the numbered page links
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class = ( $page == $i ) ? "active" : ""; //highlight current page
            $paginator .= '<li class="' . $class . '"><a href="?mDisplayStart='. ( ($i-1) * $_GET['mDisplayLength'] ).'&mDisplayLength=' . $_GET['mDisplayLength'] . '&page=' . $i . $url .'">' . $i . '</a></li>';
        }

        if ( $end < $last ) { //print ... before next page (>>> link)
            $paginator .='<li class="disabled"><span>...</span></li>'; //print 3 dots if not on last page
            $paginator .='<li><a href="?mDisplayStart='.(($last-1)*$_GET['mDisplayLength']).'&mDisplayLength='.$_GET['mDisplayLength'].'&page='.$last.$url.'">'.$last.'</a></li>'; //print last page link
        }

        $class = ( $page == $last ) ? "disabled" : ""; //disable (>>> next page link)
        
        //$page + 1 = next page (>>> link)
        $next_page = ( $page == $last) ? 
        '<li class="' . $class . '"><a href="">Next</a></li>' : //remove link from next button
        '<li class="' . $class . '"><a href="?mDisplayStart='. $row_start .'&mDisplayLength=' . $_GET['mDisplayLength'] . '&page=' . ( $page + 1 ) . $url .'">Next</a></li>';

        $paginator .= $next_page;
        $paginator .= '</ul>
                </td>
            </tr>
        </table>';
        
        return $paginator;
    }
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['mDisplayStart'] ) && $_GET['mDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['mDisplayStart'] ).", ".
			intval( $_GET['mDisplayLength'] );
	}	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol'] ) )
	{	
		$sOrder = "ORDER BY ";
		$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol'] ) ]."` ".
						($_GET['sSortDir']==='asc' ? 'asc' : 'desc') .", ";

		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	if(isset($_GET['sSortDir']) && $_GET['sSortDir'] == 'desc')
		$_GET['sSortDir'] = 'asc';
	else
		$_GET['sSortDir'] = 'desc';
		
/*							
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
*/	
	/* 
	 * Filtering
	 */
	$sWhere = "";
	if( isset($_GET['pSearch']) &&  isset($_GET['pSearch']) != "")
	{
		$sWhere = " WHERE part_id = ".$_GET['pSearch'];	
	}	

	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysqli_real_escape_string($db_link, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
	$rResult = mysqli_query( $db_link, $sQuery ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query( $db_link, $sQuery ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length 
		$sIndexColumn = Indexed column (used for fast and accurate table cardinality) 
	*/
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = mysqli_query( $db_link, $sQuery ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	//$mTotal = $aResultTotal[0];
	$mTotal = $aResultFilterTotal[0];

	
	
	/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
	 * 												Output
	:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	function highlight_search_word($content, $search) 
	{
		$replace = '<span style="background-color: #FF0;">'. $search .'</span>';
		$content = str_replace($search, $replace, $content);
		return $content;
	}

//Rows	

	$tableRows = '';
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$tableRows .= '<tr>';
		for ( $i=1 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
				$row = highlight_search_word($aRow[ $aColumns[$i] ], strtoupper($_GET['sSearch']));
			else	
				$row = $aRow[ $aColumns[$i] ];

			if($aColumns[$i] == 'ss_num')
				$tableRows .= '<td><a href="?sSearch='.$aRow[ $aColumns[$i] ].'" style="color:#C63632;">'. $aRow[ $aColumns[$i] ] .'</a></td>';
			else
				$tableRows .= '<td>'. $row .'</td>';
			
		}
		$tableRows .='<td>
						<a href="part_details.php?id='.$aRow[0].'" style="color:#73879C;"><i class="fa fa-file-text-o"></a></i>
						&nbsp;
						<a href="part_details_edit.php?id='.$aRow[0].'" style="color:#73879C;" target="_blank"><i class="fa fa-pencil"></a></i>
					</td>';
		
		$tableRows .= '</tr>';
	}	
