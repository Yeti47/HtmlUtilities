<?php

/**
 * Describes an HTML list element.
 * @author Alexander Herrfurth
 *
 */
class HtmlList extends HtmlElement {
	
	// Fields
	
	private $_isOrdered = false;
	private $_data = array();
	
	// Constructors
	
	/**
	 * Creates a new HtmlList. The list's order and data can either be passed to the constructor or set later on.
	 * @param bool $isOrdered Whether or not this list should be ordered (false by default). If false, the list will be unordered.
	 * @param string[] $data The items of the list as a string array.
	 */
	public function __construct($isOrdered = false, $data = null) {
		
		$this->_isOrdered = $isOrdered;
		
		if($data != null)
			$this->_data = $data;
		
	}
	
	// Methods
	
	/**
	 * Determines whether or not the list should be ordered. If false, the list will be unordered.
	 * @param bool $value Pass true for an ordered list or false for an unordered list.
	 */
	public function SetOrdered($value) { $this->_isOrdered = $value; }
	
	/**
	 * Whether or not this HtmlList is ordered.
	 * @return boolean|bool True if the list is ordered, false otherwise.
	 */
	public function IsOrdered() { return $this->_isOrdered; }
	
	/**
	 * Sets the items of the list by providing a string array.
	 * @param string[] $items A string array containing the new items of the list.
	 */
	public function SetItems($items) {
		$this->_data = $items;
	}
	
	/**
	 * Returns a string array representing the items of this HtmlList.
	 * @return string[] a string array representing the items of this HtmlList.
	 */
	public function GetItems() {
		return $this->_data;
	}
	
	/**
	 * Gets the tag of this HTML element, which is 'ol' for an ordered list and 'ul' for an unordered one.
	 * @return string 'ol' for an ordered list and 'ul' for an unordered one.
	 */
	public function GetTagName() {
		return $this->_isOrdered ? "ol" : "ul";
	}
	
	/**
	 * Generates the HTML code for this list and returns it.
	 * @return string The HTML code for this list as a string.
	 */
	public function GenerateList() {
		
		$listTag = new HtmlTag($this->GetTagName());
		$itemTag = new HtmlTag("li");
		$listContent = "";
		
		foreach($this->_data as $item) {
			$listContent .= $itemTag->Surround($item)."\n";
		}
		
		return $listTag->Surround("\n$listContent");
		
	}
	
	/**
	 * Generates the HTML code for this list and prints it.
	 */
	public function EchoList() {
		echo $this->GenerateList();		
	}
	
}

?>