<?php

class HtmlScriptResource extends HtmlResource {

    // Constants
    
    const TAG_NAME = 'script';
    
    // Fields
    
    private $_isAsynchronous = false;
    private $_isDeferred = false;
        
    // Methods
    
    /**
     * Whether or not the external script is executed asynchronously. Please note, that asynchronous execution
     * has priority over deferred execution, meaning that deferred execution will be ignored if execution is set to async.
     * @return bool True if execution is set to asynchronous, false otherwise.
     */
    public function GetIsAsynchronous()
    {
        return $this->_isAsynchronous;
    }

    /**
     * Sets the execution mode of the external script to async if true.
     * Please note, that asynchronous execution has priority over deferred execution, meaning that deferred execution 
     * will be ignored if execution is set to async.
     * @param bool $isAsynchronous The new value.
     */
    public function SetIsAsynchronous($isAsynchronous)
    {
        $this->_isAsynchronous = $isAsynchronous;
    }

    /**
     * Whether or not the execution of the external script is deferred. Please note, that deferred execution
     * has priority over async execution, meaning that async execution will be ignored if execution is set to deferred.
     * @return bool True if execution is set to deferred, false otherwise.
     */
    public function GetIsDeferred()
    {
        return $this->_isDeferred;
    }

    /**
     * Sets the execution mode of the external script to deferred if true.
     * Please note, that deferred execution has priority over async execution, meaning that async execution
     * will be ignored if execution is set to deferred.
     * @param bool $isDeferred The new value.
     */
    public function SetIsDeferred($isDeferred)
    {
        $this->_isDeferred = $isDeferred;
    }
    
    public function GetTagName() {
        
        return self::TAG_NAME;
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see HtmlResource::GenerateTag()
     */
    public function GenerateTag() {
        
        $tag = parent::GenerateTag();
        $tag->CreateAttribute('src', $this->GetSource());
        
        if($this->_isAsynchronous) {
            
             $tag->CreateAttribute('async', null);      
            
        }
        
        if($this->_isDeferred) {
            
            $tag->CreateAttribute('defer', null);
            
        }
        
        return $tag;
        
    }
    
    public function GenerateHtml() {
        
        return $this->GenerateTag()->Surround('');
        
    }
    
}

