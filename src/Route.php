<?php

/**
 * Describes a URL route. Routes consist of a regular expression and a callback function that should be called if the URL
 * matches the given expression. Please be aware, that the metacharacters '^' and '$' are automatically added to the
 * beginning and the end of the expression respectively when the expression is evaluated by the Router.
 *  * 
 * @author Alexander Herrfurth
 *
 */
class Route {
    
    // Fields
    
    /**
     * The regular expression the URL should be matched against.
     * 
     * @var string
     */
    private $_expression;
    
    /**
     * Modifiers to use with this Route's regular expression as a string. For example: 'i'.
     * 
     * @var string
     */
    private $_expressionModifiers;
    
    /**
     * A callback function that is to be called if the URL matches the regular expression of this Route.
     * 
     * @var callable
     */
    private $_callback;
    
    // Constructor
    
    public function __construct(string $expression, callable $callback, string $expressionModifiers = '') {
        
        $this->_expression = $expression;
        $this->_callback = $callback;
        $this->_expressionModifiers = $expressionModifiers;
        
    }
    
    // Methods
    
    public function GetExpression() {
        
        return $this->_expression;        
        
    }
    
    public function GetExpressionModifiers() {
        
        return $this->_expressionModifiers;
        
    }
    
    public function SetExpressionModifiers($value) {
        
        $this->_expressionModifiers = $value;
        
    }
    
    /**
     * Calls this Route's callback function.
     * 
     * @return boolean True if the callback function could be called successfully, false otherwise. 
     */
    public function Run() {
        
        if(is_callable($this->_callback)) {
            
            call_user_func($this->_callback);
            return true;
            
        }
        
        return false;
        
    }
    
    
}