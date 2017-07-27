<?php

/**
 * The base class for all HTML elements.
 * Provides methods to conveniently manage attributes.
 * @author Alexander Herrfurth
 *
 */
abstract class HtmlElement {

	// Fields
		
	protected $_attributes = array();
	
	// Methods
	
	public function CreateAttribute($name, $content, $allowOverride = true) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes) || $allowOverride) {
			$this->_attributes[$name] = $content;
			return true;
		}
		
		return false;
	}
	
	public function RemoveAttribute($name) {
		
		$name = strtolower($name);
		
		if(array_key_exists($name, $this->_attributes))
			unset($this->_attributes[$name]);
		
		return $this->_attributes;
		
	}
	
	public function UpdateAttribute($name, $content) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return false;
		
		$this->_attributes[$name] = $content;
		return true;
		
	}
	
	public function GetAttributes() {
		return array_keys($this->_attributes);
	}
	
	public function ClearAttributes() {
		$this->_attributes = array();
	}
	
	public function GetAttributeContent($name) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return "";
		
		return $this->_attributes[$name];
	}
	
	public function GetFullAttribute($name) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return "";
		
		return $name."=\"".$this->_attributes[$name]."\"";
	}
	
}

?>