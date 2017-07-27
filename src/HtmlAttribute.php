<?php

class HtmlAttribute {
	
	// Fields
	
	private $_name = "id";
	private $_content;
	
	// Constructors

	/**
     * Constructs a new HtmlAttribute.
     *
     * @param string $name The name of the attribute to create (e. g. "class", "id" or "href").
	 * @param string $content The content of the attribute (the text after equal sign).
     */
	public function __construct($name, $content) {
		
		$this->_name = $name;
		$this->_content = $content;
		
	}
	
	// Methods
	
	public function GetName() {
		
		return strtolower($this->_name);
		
	}
	
	public function GetNameRaw() {
		
		return $this->_name;
		
	}
	
	public function SetName($name) {
		
		$this->_name = $name;
		
	}
	
	public function GetContent() {
		
		return strtolower($this->_content);
		
	}
	
	public function GetContentRaw() {
		
		return $this->_content;
		
	}
	
	public function SetContent($content) {
		
		$this->_content = $content;
		
	}
	
	public function GetFullAttribute() {
		
		return $this->GetName()."=\"".$this->GetContent()."\"";
		
	}

}
	
?>