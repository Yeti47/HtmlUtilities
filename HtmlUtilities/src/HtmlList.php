<?php

class HtmlList extends HtmlElement {
	
	// Fields
	
	private $_isOrdered = false;
	private $_data = array();
	
	// Constructors
	
	public function __construct($isOrdered = false, $data = null) {
		
		$this->_isOrdered = $isOrdered;
		
		if($data != null)
			$this->_data = $data;
		
	}
	
	// Methods
	
	public function SetOrdered($value) { $this->_isOrdered = $value; }
	public function IsOrdered() { return $this->_isOrdered; }
	
	public function SetItems($items) {
		$this->_data = $items;
	}
	
	public function GetItems() {
		return $this->_data;
	}
	
	public function GetTagName() {
		return $this->_isOrdered ? "ol" : "ul";
	}
	
	public function GenerateList() {
		
		$listTag = new HtmlTag($this->GetTagName());
		$itemTag = new HtmlTag("li");
		$listContent = "";
		
		foreach($this->_data as $item) {
			$listContent .= $itemTag->Surround($item)."\n";
		}
		
		return $listTag->Surround("\n$listContent");
		
	}
	
	public function EchoList() {
		echo $this->GenerateList();		
	}
	
}

?>