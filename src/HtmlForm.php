<?php

class HtmlForm extends HtmlElement {
    
    // Fields
    
    private $_action = '';
    private $_method = 'GET';
    
    // Constructor
    
    public function __construct($action, $method = 'GET') {
        
        $this->_action = $action;
        $this->_method = $method;
        
    }
    
    
}


?>