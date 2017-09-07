<?php

abstract class HtmlResource {
    
    // Constants
    
    const TAG_NAME = 'link';
    
    // Fields
    
    private $_crossorigin = '';
    private $_integrity = '';
    private $_source = '';
    private $_isDisabled = false;
    
    // Constructors
    
    protected function __construct($source) {
        
        $this->_source = $source;
        
    }
    
    // Methods

    public function GetCrossorigin()
    {
        return $this->_crossorigin;
    }

    public function SetCrossorigin($crossorigin)
    {
        $this->_crossorigin = $crossorigin;
    }

    public function GetIntegrity()
    {
        return $this->_integrity;
    }

    public function SetIntegrity($integrity)
    {
        $this->_integrity = $integrity;
    }

    public function GetSource()
    {
        return $this->_source;
    }

    public function SetSource($source)
    {
        $this->_source = $source;
    }
    
    public function Disable() {
        $this->_isDisabled = true;        
    }
    
    public function Enable() {
        $this->_isDisabled = false;
    }
    
    public function IsDisabled() {
        return $this->_isDisabled;
    }
    
    public function GetTagName() {
        
        self::TAG_NAME;
        
    }
    
    /**
     * Generates an HtmlTag that can be used to embed this resource in Html source code.
     * Derivative classes should override this method to add custom attributes to the tag created. 
     * @return HtmlTag The HtmlTag instance generated.
     */
    public function GenerateTag() {
        
        $tag = new HtmlTag($this->GetTagName());
        $crossorigin = $this->_crossorigin;
        $integrity = $this->_integrity;
        
        if($this->_isDisabled)
            $tag->CreateAttribute('disabled', null);
        if($crossorigin != '')
            $tag->CreateAttribute('crossorigin', $crossorigin);
        if($integrity != '')
            $tag->CreateAttribute('integrity', $integrity);
        
        return $tag;
        
    }
    
    /**
     * Generates the HTML code responsible for loading the resource.
     * @return string The HTML code generated.
     */
    public function GenerateHtml() {
        
        return $this->GenerateTag()->GetFullTagOpen();
        
    }
    
    
}