<?php

/**
 * Classes that implement the ITableRow interface can be used to generate an HtmlTable via the HtmlTable::CreateFromTableRows method.
 * Each ITableRow object provided describes one row in the table to create.
 * @author Alexander Herrfurth
 *
 */
interface ITableRow {
    
    /**
     * Returns an array of strings representing the fields in an HtmlTable's row. 
     */
    function GetTableRowData();
    
    
}