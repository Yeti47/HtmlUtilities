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
	
	/**
	 * Adds a new attribute to this HtmlElement. 
	 * @param string $name The name (type) of the new attribute (eg 'class').
	 * @param string $content The value of the new attribute.
	 * @param string $allowOverride Whether the content of an attribute should be overwritten in case it already exists. 
	 * Overwriting the content of an existing attribute is equivalent to calling the UpdateAttribute method.
	 * @return boolean True if the attribute was successfully created/overwritten, false otherwise.
	 */
	public function CreateAttribute($name, $content, $allowOverride = true) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes) || $allowOverride) {
			$this->_attributes[$name] = $content;
			return true;
		}
		
		return false;
	}
	
	/**
	 * Removes the attribute with the given name/type from this HtmlElement.
	 * @param string $name The name/type of the attribute to remove (eg 'style').
	 * @return array The new set of attributes of this HtmlElement.
	 */
	public function RemoveAttribute($name) {
		
		$name = strtolower($name);
		
		if(array_key_exists($name, $this->_attributes))
			unset($this->_attributes[$name]);
		
		return $this->_attributes;
		
	}
	
	/**
	 * Updates the value of an existing attribute. Updating fails if there is no attribute of the given
	 * name/type attached to this HtmlElement.
	 * @param string $name The name/type of the attribute to update.
	 * @param string $content The new value for the attribute.
	 * @return boolean True if the attribute was updated successfully, false otherwise.
	 */
	public function UpdateAttribute($name, $content) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return false;
		
		$this->_attributes[$name] = $content;
		return true;
		
	}
	
	/**
	 * Gets the names/types of all attributes attached to this HtmlElement.
	 * @return string[] The set of attributes attached to this HtmlElement.
	 */
	public function GetAttributes() {
		return array_keys($this->_attributes);
	}
	
	/**
	 * Removes all attributes from this HtmlElement.
	 */
	public function ClearAttributes() {
		$this->_attributes = array();
	}
	
	/**
	 * Gets the value of the attribute with the given name (type).
	 * @param string $name The name (type) of the attribute the retrieve the content of.
	 * @return string The content of the given attribute.
	 */
	public function GetAttributeContent($name) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return "";
		
		return $this->_attributes[$name];
	}
	
	/**
	 * Generates the complete HTML code for the given attribute.
	 * @param string $name 
	 * @return string The complete HTML code for the given attribute as a string (eg 'class="test"').
	 */
	public function GetFullAttribute($name) {
		
		$name = strtolower($name);
		
		if(!array_key_exists($name, $this->_attributes))
			return "";
		
		return $name."=\"".$this->_attributes[$name]."\"";
	}
	
}

?>