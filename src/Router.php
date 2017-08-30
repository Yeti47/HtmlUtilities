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
    
    /**
     * Creates a new Route and adds it to the collection of Routes managed by this Router.
     * @param string $expression The regular expression the URL should be matched against.
     * @param callable $func The handler function to call if the URL matches the given regular expression.
     * @param string $expressionModifiers An optional string of modifiers to use on the regular expression.
     * @return Route The newly created Route.
     */
    public function CreateRoute($expression, $func, $expressionModifiers = '') {
       
        $route = new Route($expression, $func, $expressionModifiers);  
        $this->_routes[] = $route;
        
        return $route;
        
    }
    
    /**
     * Adds the given Route to the collection of Routes managed by this Router.
     * @param Route $route The Route to add.
     */
    public function AddRoute($route) {
        
        $this->_routes[] = $route;
        
    }
    
    /**
     * Creates a new 404 Route, meaning the Route that is run when none of the specified Routes match the URL.
     * @param callable $func The callback function of the Route to create.
     */
    public function CreateRoute404($func) {
        
        $route = new Route('_404_', $func);
        $this->_route404 = $route;
        
        return $route;
        
    }
    
    /**
     * Sets the given Route to be the 404 Route, meaning the Route that is run when none of the specified Routes match the URL.
     * Pass null for default behavior (http response code 404).
     * @param Route $route The Route to use in case the URL does not match any of the specified Routes.
     */
    public function SetRoute404($route) {
                
        $this->_route404 = $route;
        
    }
    
    /**
     * Retrieves the first Route in the set of Routes managed by this Router that is mapped to the given regular expression.
     * @param string $expression The regular expression to search.
     * @return Route|NULL The first Route found that uses the given regular expression. Null if there was no match.
     */
    public function FindRoute($expression) {
        
        foreach($this->_routes as $route) {
            
            if($route->GetExpression() == $expression)
                return $route;
            
        }
        
        return null;
        
    }
    
    /**
     * Retrieves all Routes in the set of Routes managed by this Router that are mapped to the given regular expression.
     * @param string $expression The regular expression to search.
     * @return Route[] An array of all the Routes found that use the given regular expression. An empty array if there was no match.
     */
    public function FindRoutes($expression) {
        
        $result = [];
        
        foreach($this->_routes as $route) {
            
            if($route->GetExpression() == $expression)
                $result[] = $route;
                
        }
        
        return $result;
        
    }
    
    /**
     * Removes the given Route from the set of Routes this Router manages if it is included.
     * @param Route $route The Route to remove.
     * @return boolean True if the Route was successfully removed. False if the Route was not found in the set of Routes.
     */
    public function RemoveRoute($route) {
        
        $routeIndex = array_search($route, $this->_routes, true);
        
        if($routeIndex !== false) {
            
            unset($this->_routes[$routeIndex]);
            return true;
            
        }
        
        return false;
        
    }
    
    /**
     * Removes all Routes from this Router.
     */
    public function ClearRoutes() {
        
        $this->_routes = [];
        
    }
    
    /**
     * Iterates over all Routes that were specified beforehand and calls their callback function in case the URL matches
     * their regular expression.
     * 
     * @return boolean True if the current URL matches at least one of the specified Routes, false otherwise.
     */
    public function ProcessRoutes() {
        
        $parsedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($parsedUrl, '/');
        
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
    
    public static function GetCurrentUrl($doTrimLeft = false, $doTrimRight = false) {
        
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if($doTrimLeft)
            $url = ltrim($url, '/');
            
            if($doTrimRight)
                $url = rtrim($url, '/');
                
                return $url;
                
    }
    
}