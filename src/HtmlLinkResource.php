<?php

class HtmlLinkResource extends HtmlResource {
    
    // Fields
    
    private $_relation = '';
    private $_language = '';
    private $_sizes = '';
    private $_type = '';
    
    // Constructor
    
    public function __construct($source, $relation) {
        
        parent::__construct($source);
        $this->_relation = $relation;
                
    }
    
    // Methods
    
    public function SetRelation($relation) { $this->_relation = $relation; }
    public function GetRelation() { return $this->_relation; }
    
    public function SetLanguage($language) { $this->_language = $language; }
    public function GetLanguage() { return $this->_language; }
    
    public function SetSizes($sizes) { $this->_sizes = $sizes; }
    public function GetSizes() { return $this->_sizes; }
    
    public function SetType($type) { $this->_type = $type; }
    public function GetType() { return $this->_type; }
    
    public function GenerateTag() {
        
        $tag = parent.GenerateTag();
        
        $tag->CreateAttribute('rel', $this->_relation);
        $tag->CreateAttribute('href', $this->GetSource());
        
        if($this->_language != '')
            $tag->CreateAttribute('hreflang', $this->_language);
        
        if($this->_type != '')
            $tag->CreateAttribute('type', $this->_type);
        
        if($this->_sizes != '')
            $tag->CreateAttribute('sizes', $this->_sizes);
        
        return $tag;
        
    }
    
}

