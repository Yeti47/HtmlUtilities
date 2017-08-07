<?php

/**
 * Describes a field in HTML table.
 * @author Alexander Herrfurth
 *
 */
class TableField {
	
	public $content = "";
	public $isHeader = false;
	
	public function __construct($content, $isHeader) {
		
		$this->content = $content;
		$this->isHeader = $isHeader;
		
	}
	
}

/**
 * Describes an HTML table element. Currently, only tables with equally distributes columns are supported.
 * @author Alexander Herrfurth
 *
 */
class HtmlTable extends HtmlElement{
	
	// Fields
	
	private $_rows = 0;
	private $_columns = 0;
	
	private $_data = array();
	
	// Constructors
	
	/**
	 * Creates a new HtmlTable with the given dimensions.
	 * @param int $rows The number of rows.
	 * @param int $columns The number of columns.
	 */
	public function __construct($rows, $columns) {
		
		$this->_rows = max($rows, 0);
		$this->_columns = max($columns, 0);
		
		for($x = 0; $x < $columns; $x++) {
			
			$this->_data[$x] = array();
			
			for($y = 0; $y < $rows; $y++) {
				
				$this->_data[$x][$y] = new TableField("", false);
			
			}
			
		}
			
	}
	
	// Methods
	
	/**
	 * Sets the text of the table field with the given indices.
	 * @param int $indexX The horizontal index of the field.
	 * @param int $indexY The vertical index of the field.
	 * @param string $content The new content for the table field.
	 */
	public function SetFieldContent($indexX, $indexY, $content) {
		
		$this->_data[$indexX][$indexY]->content = $content;
		
	}
	
	/**
	 * Gets the text contained in the table field with the given indices.
	 * @param int $indexX The horizontal index of the field.
	 * @param int $indexY The vertical index of the field.
	 * @return string The text of the table field determined by the given indices.
	 */
	public function GetFieldContent($indexX, $indexY) {
		
		return $this->_data[$indexX][$indexY]->content; 
		
	}
	
	/**
	 * Marks/unmarks the table field with the given indices as a header (<th>).
	 * @param int $indexX The horizontal index of the field.
	 * @param int $indexY The vertical index of the field.
	 * @param string $isHeader Whether or not the field should be a header (true by default).
	 */
	public function SetHeader($indexX, $indexY, $isHeader = true) {
		
		$this->_data[$indexX][$indexY]->isHeader = $isHeader;
		
	}
	
	/**
	 * Marks/unmarks all fields in the table's row as headers.
	 * @param int $rowIndex The index of the table's row.
	 * @param string $isHeader Wether or not the fields should be marked as headers (true by default).
	 * @return boolean True if successfull, false if an invalid row index was passed.
	 */
	public function SetHeaderRow($rowIndex, $isHeader = true) {

	    if($rowIndex >= $this->_rows)
	        return false;
	    
	    for($x = 0; $x < $this->_columns; $x++) {
	        
	        $this->SetHeader($x, $rowIndex, $isHeader);
	        
	    }
	        
	    return true;
	    
	}
	
	/**
	 * Marks/unmarks all fields in the table's column as headers.
	 * @param int $columnIndex The index of the table's column.
	 * @param string $isHeader Wether or not the fields should be marked as headers (true by default).
	 * @return boolean True if successfull, false if an invalid column index was passed.
	 */
	public function SetHeaderColumn($columnIndex, $isHeader = true) {
	    
	    if($rowIndex >= $this->_columns)
	        return false;
	    
	    for($y = 0; $y < $this->_rows; $y++) {
	        
	        $this->SetHeader($columnIndex, $y, $isHeader);
	        
	    }
	    
	    return true;
	    
	}
	
	/**
	 * Generates and returns the HTML code for this HtmlTable.
	 * @return string The HTML code for this HtmlTable.
	 */
	public function GenerateTable() {
		
		$result = "";
		
		for($y = 0; $y < $this->_rows; $y++) {
			
			$rowContent = "";
			
			for($x = 0; $x < $this->_columns; $x++) {
				
				$fieldTag = new HtmlTag($this->_data[$x][$y]->isHeader ? "th" : "td");
				$rowContent .= $fieldTag->Surround($this->_data[$x][$y]->content);
				
			}
			
			$trTag = new HtmlTag("tr");
			$result .= $trTag->Surround("\n".$rowContent."\n")."\n";
			
		}
		
		$tableTag = new HtmlTag("table");
		
		foreach($this->_attributes as $attributeName => $attributeContent)
			$tableTag->CreateAttribute($attributeName, $attributeContent);
		
		return$tableTag->Surround("\n".$result);
		
	}
	
	/**
	 * Generates the HTML code for this HtmlTable and prints it.
	 */
	public function EchoTable() {
		
		echo $this->GenerateTable();
		
	}
	
	// Static Methods
	
	/**
	 * Creates an HtmlTable instance from the given string array.
	 * @param string[] $data A string array that contains the individual contents of the table fields to create.
	 * @param int $columns The number of columns per row. If the number of items in the provided array is not a mulitple 
	 * of this number, the remaining columns will be left empty.
	 * 
	 * @return HtmlTable A new instance of HtmlTable generated from the elements of the given string array.
	 */
	public static function CreateFromArray($data, $columns) {
		
		$itemCount = count($data);
		$rows = ceil($itemCount / $columns );
		$table = new HtmlTable($rows, $columns);
		
		for($y = 0; $y < $rows; $y++) {
			
			for($x = 0; $x < $columns; $x++) {
				
				$i = $y * $columns + $x;
				
				if($i < $itemCount)
					$table->SetFieldContent($x, $y, $data[$i]);
				else
					break;
			}
			
		}
		
		return $table;
		
	}
	
	/**
	 * Creates an HtmlTable instance from the given two dimensional string array.
	 * The number of columns of the newly created HtmlTable is determined by the number of elements in the longest array provided.
	 * Fields for which no content was provided will remain empty.
	 * @param string[][] $data A two dimensional string array that represents the table's fields in the format [row][column].
	 * @return HtmlTable A new instance of HtmlTable generated from the elements of the given string arrays.
	 */
	public static function CreateFromArray2D($data) {
		
		$rows = count($data);
		$columns = 0;
		
		foreach($data as $row) {
			
			if(count($row) > $columns)
				$columns = count($row);
			
		}
		
		$table = new HtmlTable($rows, $columns);
		
		for($y = 0; $y < $rows; $y++) {
			
			for($x = 0; $x < count($data[$y]); $x++) {
				
				$table->SetFieldContent($x, $y, $data[$y][$x]);

			}
			
		}
		
		return $table;
		
	}
	
	/**
	 * Generates an HtmlTable from the given ITableRow objects that provide the data of each row.
	 * @param ITableRow[] $tableRows The rows to generate the table from.
	 * @return HtmlTable A new instance of HtmlTable generated from the given array of ITableRow objects.
	 */
	public static function CreateFromTableRows($tableRows) {
	    
	    $tableData = [];
	    
	    foreach($tableRows as $tableRow) {
	        
	        $tableData[] = $tableRow->GetTableRowData();
	        
	    }
	    
	    return HtmlTable::CreateFromArray2D($tableData);
	    
	}

}

?>