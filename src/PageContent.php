<?php

include_once 'CommonCdnSources.php';

/**
 * Describes the content of an html/php web page.
 * @author Alexander Herrfurth
 *
 */
class PageContent {
    
    // Fields
    
    private $_lang;
    private $_charset = 'UTF-8';
    private $_title;
    private $_template;
    private $_styles = [];
    private $_scripts = [];
    private $_contents = [];
        
    // Constructor
    
    public function __construct($template, $title = 'untitled', $lang = 'en') {
        
        $this->_lang = $lang;
        $this->_title = $title;
        $this->_template = $template;
                
    }
    
    // Methods
    
    /**
     * Renders this page with all of its content using the provided template.
     * @param array An optional associative array that provides additional parameters that can then be used by the content. 
     * @return boolean True if the page could be rendered successfully. False otherwise.
     */
    public function Render($params = array()) {
        
        if(file_exists($this->_template)) {
            
            $lang = $this->_lang;
            $charset = $this->_charset;
            $title = $this->_title;
            $styles = $this->_styles;
            $scripts = $this->_scripts;
            $contents = $this->_contents;
            
            include $this->_template;
            return true;
            
        }
        
        return false;
        
    }
    /**
     * @return string the $_lang
     */
    public function GetLang()
    {
        return $this->_lang;
    }

    /**
     * @param string $lang
     */
    public function SetLang($lang)
    {
        $this->_lang = $lang;
    }

    /**
     * @return string the $_title
     */
    public function GetTitle()
    {
        return $this->_title;
    }

    /**
     * @param string $title
     */
    public function SetTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return string the $_template
     */
    public function GetTemplate()
    {
        return $this->_template;
    }

    /**
     * @param string $template
     */
    public function SetTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * @return string[] the $_styles
     */
    public function GetStyles()
    {
        return $this->_styles;
    }

    /**
     * @param string[] $styles
     */
    public function SetStyles($styles)
    {
        $this->_styles = array_unique($styles);
    }

    /**
     * @return string[] the $_scripts
     */
    public function GetScripts()
    {
        return $this->_scripts;
    }

    /**
     * @param string[] $scripts
     */
    public function SetScripts($scripts)
    {
        $this->_scripts = array_unique($scripts);
    }

    /**
     * @return string[] the $_contents
     */
    public function GetContents()
    {
        return $this->_contents;
    }

    /**
     * @param string[] $contents
     */
    public function SetContents($contents)
    {
        $this->_contents = $contents;
    }
    
    public function GetCharset() {
        
        return $this->_charset;
        
    }
    
    public function SetCharset($charset) {
        
        $this->_charset = $charset;
        
    }
    
    public function AddScript($script) {
        
        if(!$this->HasScript($script)) {
            
            $this->_scripts[] = $script;
            return true;
            
        }
        
        return false;
        
    }
    
    public function HasScript($script) {
        
        return in_array($script, $this->_scripts);  
        
    }
    
    public function RemoveScript($script) {
        
        $existingScriptIndex = array_search($script, $this->_scripts);
        
        if($existingScriptIndex !== false) {
            
            unset($this->_scripts[$existingScriptIndex]);
            return true;
            
        }
        
        return false;
        
    }
    
    public function AddStyle($style) {
        
        if(!$this->HasStyle($style)) {
            
            $this->_styles[] = $style;
            return true;
            
        }
        
        return false;
        
    }
    
    public function HasStyle($style) {
        
        return in_array($style, $this->_styles);
        
    }
    
    public function RemoveStyle($style) {
        
        $existingStyleIndex = array_search($style, $this->_styles);
        
        if($existingStyleIndex !== false) {
            
            unset($this->_styles[$existingStyleIndex]);
            return true;
            
        }
        
        return false;
        
    }
    
    public function HasContent($content) {
        
        return in_array($content, $this->_contents);
        
    }
    
}