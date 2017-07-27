<?php

class TableField {
	
	public $content = "";
	public $isHeader = false;
	
	public function __construct($content, $isHeader) {
		
		$this->content = $content;
		$this->isHeader = $isHeader;
		
	}
	
}

class HtmlTable extends HtmlElement{
	
	// Fields
	
	private $_rows = 0;
	private $_columns = 0;
	
	private $_data = array();
	
	// Constructors
	
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
	
	public function SetFieldContent($indexX, $indexY, $content) {
		
		$this->_data[$indexX][$indexY]->content = $content;
		
	}
	
	public function GetFieldContent($indexX, $indexY) {
		
		return $this->_data[$indexX][$indexY]->content; 
		
	}
	
	public function SetHeader($indexX, $indexY, $isHeader = true) {
		
		$this->_data[$indexX][$indexY]->isHeader = $isHeader;
		
	}
	
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
	
	public function EchoTable() {
		
		echo $this->GenerateTable();
		
	}

}

?>