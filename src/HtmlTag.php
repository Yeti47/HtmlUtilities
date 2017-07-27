<?php

class HtmlTag extends HtmlElement {
	
	// Fields
	
	private $_name = "span";
	
	// Constructors
	
	public function __construct($name) {
		
		$this->_name = $name;
		
	}
	
	// Methods
	
	public function GetName() {
		return strtolower($this->_name);
	}
	
	public function GetNameRaw() {
		return $this->_name;
	}
	
	private function GetFullTag($isOpening = true) {
		
		$fullTag = "<".($isOpening ? "" : "/").$this->GetName();
		
		if($isOpening) {
			
			foreach($this->GetAttributes() as $attributeKey) {
				$fullTag .= " ".$this->GetFullAttribute($attributeKey);
			}
			
		}
		
		$fullTag .= ">";
		
		return $fullTag;
		
	}
	
	public function GetFullTagOpen() {
		return $this->GetFullTag();
	}
	
	public function GetFullTagClose() {
		return $this->GetFullTag(false);
	}
	
	public function Surround($text) {
		return $this->GetFullTag().$text.$this->GetFullTag(false);
	}
	
	public function EchoOpen() {
		echo $this->GetFullTag();
	}
	
	public function EchoClose() {
		echo $this->GetFullTag(false);
	}
	
	public function EchoSurround($text) {
		echo $this->Surround($text);
	}
	
	// Static Methods
	
	public static function BR() { return new HtmlTag("br"); }
	
	public static function EchoTagOpen($htmlTag) { echo $htmlTag->GetFullTagOpen(); }
	public static function EchoTagClose($htmlTag) { echo $htmlTag->GetFullTagClose(); }
	public static function EchoTagSurround($htmlTag, $text) { echo $htmlTag->Surround($text); }
	
	public static function EchoBR($count = 1) {
		
		for($i = 0; $i < $count; $i++)
			HtmlTag::EchoTagOpen(HtmlTag::BR());
		
		
	}
	
}

?>