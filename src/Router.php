<?php

/**
 * Responsible for managing URL routes and mapping them to a specific regular expression in the URL.
 * 
 * @author Alexander Herrfurth
 *
 */
class Router {
    
    
    // Fields
    
    /**
     * A collection of all the Route instances this Router manages.
     * @var Route[]
     */
    private $_routes = [];
    
    /**
     * The route to use in case the URL does not match any Route's regular expression. If null, the Router will simply
     * respond with the http response code 404.
     * 
     * @var Route
     */
    private $_route404;
    
    
    // Constructor
    
    public function __construct() {
        
    }
    
    // Methods
    
    public function CreateRoute($expression, $func, $expressionModifiers = '') {
       
        $route = new Route($expression, $func, $expressionModifiers);  
        $this->_routes[] = $route;
        
        return $route;
        
    }
    
    public function AddRoute($route) {
        
        $this->_routes[] = $route;
        
    }
    
    public function CreateRoute404($func) {
        
        $route = new Route('_404_', $func);
        $this->_route404 = $route;
        
        return $route;
        
    }
    
    public function AddRoute404($route) {
                
        $this->_route404 = $route;
        
    }
    
    /**
     * Iterates over all Routes that were specified beforehand and calls their callback function in case the URL matches
     * their regular expression.
     * 
     * @return boolean True if the current URL matches at least one of the specified Routes, false otherwise.
     */
    public function ProcessRoutes() {
        
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        $url = trim($parsedUrl['path'], '/');
        
        $isValidUrl = false;
        
        foreach($this->_routes as $route) {
            
            $routeRegex = '#^'.$route->GetExpression().'$#'.$route->GetExpressionModifiers();
            
            if(preg_match($routeRegex, $url)) {
                $route->Run();
                $isValidUrl = true;
            }
        }
        
        if(!$isValidUrl) {
            
            if(!isset($this->_route404) || !$this->_route404->Run())
                http_response_code(404);
            
            return false;
            
        }
        
        return true;
        
    }
    
}