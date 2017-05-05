<?php

class Table {
	//declare all internal (private) variables, only accessbile within this class
    private $_conn;
    private $_query;
    
    private $_page; //current page
    private $_total; //total number of rows
    private $_row_start; 
    private $_limit; //records (rows) to show per page

    //constructor method is called automatically when object is instantiated with new keyword
    public function __construct( $conn, $query ) 
    {
     
    //$this-> variables become available anywhere within THIS class
    $this->_conn = $conn; //mysql connection resource
    $this->_query = $query; //mysql query string
 
    //$rs = $this->_conn->query( $this->_query );
    //$this->_total = $rs->num_rows; //total number of rows
     
    }

    public function getRows($thead, $style=null, $sort=null) 
    {
        if($sort == 'all')
            $link = '<a href="?sort='.$sort.'&col_num='.$i.'&limit='.$limit.'">';
        $html = '<thead '.$style.'>
                    <tr>';
        foreach($thead as $th) 
        {
            $html .= '<td>'.$th.'</td>';
        }
        $html .=   '</tr>
                </thead>';

        return $html;                    
    }

}

?>
