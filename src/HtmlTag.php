<?php

/**
 * Describes any type of HTML tag like &lt;br&gt;, &lt;span&gt;, &lt;p&gt;, &lt;div&gt; etc.
 * @author Alexander Herrfurth
 *
 */
class HtmlTag extends HtmlElement {
	
	// Fields
	
	private $_name = "span";
	
	// Constructors
	
	/**
	 * Creates a new HtmlTag of the type determined by the provided string.
	 * @param string $name The type of the HTML tag (for example 'p', 'span' or 'div').
	 */
	public function __construct($name) {
		
		$this->_name = $name;
		
	}
	
	// Methods
	
	/**
	 * Gets the name (type) of this HtmlTag as a string. Please note: The string returned will be converted to all lowercase.
	 * To retrieve the string in its original format, use GetNameRaw().
	 * @return string The type/name of this tag ('p', 'div', 'span' etc).
	 */
	public function GetName() {
		return strtolower($this->_name);
	}
	
	public function GetNameRaw() {
		return $this->_name;
	}
	
	/**
	 * Generates the full HTML code for this HtmlTag.
	 * @param bool $isOpening Whether to generate an opening or a closing HTML tag.
	 * @return string The full HTML code for this HtmlTag. Opening tags include all attributes.
	 */
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
	
	/**
	 * Generates the full HTML code for this HtmlTag as an opening tag.
	 * @return string The full HTML code for this HtmlTag (opening) including all attributes.
	 */
	public function GetFullTagOpen() {
		return $this->GetFullTag();
	}
	
	/**
	 * Generates the full HTML code for this HtmlTag as a closing tag.
	 * @return string The full HTML code for this HtmlTag (closing).
	 */
	public function GetFullTagClose() {
		return $this->GetFullTag(false);
	}
	
	/**
	 * Surrounds the given text by an opening and a closing HTML tag and returns the full HTML code with all attributes applied.
	 * @param string $text The HTML content between the opening and the closing tag.
	 * @return string HTML code consisting of an opening tag with all attributes, the given content and a closing tag.
	 */
	public function Surround($text) {
		return $this->GetFullTag().$text.$this->GetFullTag(false);
	}
	
	/**
	 * Prints the opening version of this HTML tag with all attributes applied.
	 */
	public function EchoOpen() {
		echo $this->GetFullTag();
	}
	
	/**
	 * Prints the closing version of this HTML tag.
	 */
	public function EchoClose() {
		echo $this->GetFullTag(false);
	}
	
	/**
	 * Surrounds the given text by an opening and a closing HTML tag and prints the full HTML code with all attributes applied.
	 * @param string $text The HTML content between the opening and the closing tag.
	 */
	public function EchoSurround($text) {
		echo $this->Surround($text);
	}
	
	// Static Methods
	
	/**
	 * Creates a br HTML tag. Shorthand for: new HtmlTag('br');
	 * @return HtmlTag
	 */
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