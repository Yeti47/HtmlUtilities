<?php

/**
 * Describes an HTML pagination.
 * @author Alexander Herrfurth
 *
 */
class HtmlPagination extends HtmlElement {
    
    // Constants
    
    /**
     * The absolute minimum number of items displayed on one page.
     * @var integer
     */
    const MIN_ITEMS_PER_PAGE = 1;
    
    // Fields
    
    /**
     * The index of the page that is currently shown.
     * @var integer
     */
    private $_currentPage = 1;
    
    /**
     * The maximum number of items shown on a page.
     * @var integer
     */
    private $_itemsPerPage = 10;
    
    /**
     * The total number of items.
     * @var integer
     */
    private $_totalNumberResults = 0;
    
    /**
     * The maximum number of navigation links to list between the first and the current page index as well as the current and the last page index.
     * @var integer
     */
    private $_numberAdjacentLinks = 2;
    
    /**
     * The name of the CSS class to use for disabled links.
     * @var string
     */
    private $_disabledCssClass = 'disabled';
    
    /**
     * The URL the navigation links should redirect to. The index of the selected page will be appended to this URL as a GET variable.
     * @var string
     */
    private $_targetUrl = '';
    
    private $_preserveGetVariables = true;
    
    private $_showSinglePage = false;
    
    /**
     * The name of the CSS class to use for the inner HTML list element.
     * @var string
     */
    private $_listCssClass = 'pagination';
    
    private $_backLabel = '&lt;';
    
    private $_nextLabel = '&gt;';
    
    // Constructor
    
    public function __construct($totalNumberResults, $itemsPerPage, $targetUrl) {
        
        $this->SetTotalNumberResults($totalNumberResults);
        $this->SetItemsPerPage($itemsPerPage);
        $this->_targetUrl = $targetUrl;
        
    }
    
    // Methods
    
    /**
     * Gets the index of the last page available in the pagination.
     * @return int The index of the pagination's last page.
     */
    public function GetLastPageIndex() {
        return max(1,intval(ceil($this->_totalNumberResults / $this->_itemsPerPage)));;
    }
    
    /**
     * Sets the current page index. The value is constrained to lie between 1 and the index of the last page. Therefore, the effective value
     * may vary from the value passed.
     * @param int $currentPage The index of the current page.
     */
    public function SetCurrentPage($currentPage) {
        $this->_currentPage =  max(min($currentPage, $this->GetLastPageIndex()), 1);
    }
    
    /**
     * Gets the current page index.
     * @return int The index of the currently active page.
     */
    public function GetCurrentPage() { return $this->_currentPage; }
    
    /**
     * Gets the maximum number of items displayed on a page.
     * @return int The maximum number of items listed on a page.
     */
    public function GetItemsPerPage() { return $this->_itemsPerPage; }
    
    /**
     * Sets the maximum number of items displayed on a page.
     * @param int $itemsPerPage The new maximum number of items per page.
     */
    public function SetItemsPerPage($itemsPerPage) {
        $this->_itemsPerPage = max($itemsPerPage, self::MIN_ITEMS_PER_PAGE);
    }
    
    /**
     * Gets the total number of items in the pagination.
     * @return int The total number of items in this pagination.
     */
    public function GetTotalNumberResults() { return $this->_totalNumberResults; }
    
    /**
     * Sets the total number of items in the pagination.
     * @param int $totalNumberResults The total number of items in this pagination.
     */
    public function SetTotalNumberResults($totalNumberResults) {
        $this->_totalNumberResults = max($totalNumberResults, 0);
    }
    
    /**
     * Gets the maximum number of navigation links to list between the first and the current page index as 
     * well as the current and the last page index.
     * @return int The maximum number of navigation items adjacent to the current page index.
     */
    public function GetNumberAdjacentLinks() { return $this->_numberAdjacentLinks; }
    
    /**
     * Sets the maximum number of navigation links to list between the first and the current page index as
     * well as the current and the last page index.
     * @param int $numberAdjacentLinks The maximum number of navigation items adjacent to the current page index.
     */
    public function SetNumberAdjacentLinks($numberAdjacentLinks) {
        $this->_numberAdjacentLinks = max($numberAdjacentLinks, 0);
    }
    
    /**
     * Whether the pagination should also be shown if the results fit on a single page.
     * @param boolean $doShow The new value.
     */
    public function SetShowSinglePage($doShow) {
        $this->_showSinglePage = $doShow;
    }
    
    /**
     *  Whether the pagination should also be shown if the results fit on a single page. If not explicitly set, this defaults to false.
     * @return boolean True if the pagination is also shown for single page results; false otherwise.
     */
    public function GetShowSinglePage() { return $this->_showSinglePage; }
    
    /**
     * Whether or not existing GET variables are preserved and appended to the target URL when a navigation link is clicked.
     * @return boolean True if GET variables are preserved; false otherwise.
     */
    public function IsPreservingGetVariables() { return $this->_preserveGetVariables; }
    
    /**
     * Whether or not existing GET variables should be preserved and appended to the target URL when a navigation link is clicked.
     * @param boolean $doPreserve The new value.
     */
    public function PreserveGetVariables($doPreserve) {
        $this->_preserveGetVariables = $doPreserve;
    }
    
    /**
     * Gets the URL the pagination links should navigate to.
     * @return string The target URL of this pagination.
     */
    public function GetTargetUrl() { return $this->_targetUrl; }
    
    /**
     * Sets the URL the navigation links should redirect to. The index of the selected page will be appended to this URL as a GET variable (e.g. /someurl?page=1).
     * @param string $targetUrl The target URL to navigate to.
     */
    public function SetTargetUrl($targetUrl) {
        $this->_targetUrl = $targetUrl;
    }
    
    /**
     * Gets the name of the CSS class used for disabled links.
     * @return string The name of the CSS class used for disabled links.
     */
    public function GetDisabledCssClass() {
        return $this->_disabledCssClass;
    }
    
    /**
     * Sets the name of the CSS class to use for disabled links.
     * @param string $disabledCssClass The name of the CSS class to use.
     */
    public function SetDisabledCssClass($disabledCssClass) {
        $this->_disabledCssClass = $disabledCssClass;
    }
    
    /**
     * Gets the name of the CSS class used for the inner list element.
     * @return string The name of the CSS class used for the inner list element.
     */
    public function GetListCssClass() {
        return $this->_listCssClass;
    }
    
    /**
     * Sets the name of the CSS class to use for the inner list element.
     * @param string $listCssClass The name of the CSS class to use.
     */
    public function SetListCssClass($listCssClass) {
        $this->_listCssClass = $listCssClass;
    }
    
    public function SetBackLabel($label) {
        $this->_backLabel = $label;
    }
    
    public function GetBackLabel() { return $this->_backLabel; }
    
    public function SetNextLabel($label) {
        $this->_nextLabel = $label;
    }
    
    public function GetNextLabel() { return $this->_nextLabel; }
    
    /**
     * Generates the HTML code for this pagination.
     * @return string The HTML code generated.
     */
    public function GenerateHtml() {
        
        $resultsCount = $this->_totalNumberResults;
        $itemsPerPage = $this->_itemsPerPage;
        $showSinglePage = $this->_showSinglePage;
        
        if($resultsCount <= $itemsPerPage && !$showSinglePage) {
            return '';
        }
        
        $currentPage = $this->_currentPage;
        $innerItemsCount = $this->_numberAdjacentLinks;
        $lastPageNum = $this->GetLastPageIndex();
        $disabledCssClass = $this->_disabledCssClass;
        $listCssClass = $this->_listCssClass;
        
        $backLabel = $this->_backLabel;
        $nextLabel = $this->_nextLabel;
        
        $targetUrlBase = $this->_targetUrl.'?';
        
        if($this->_preserveGetVariables) {
            
            foreach($_GET as $key => $value) {
                if($key != 'page') {
                    $targetUrlBase .= "$key=$value&";
                }
            }
            
        }
        
        $targetUrlBase .= 'page=';
        
        $navTag = new HtmlTag('nav');
        
        foreach($this->_attributes as $attributeName => $attributeContent) {
            $navTag->CreateAttribute($attributeName, $attributeContent);
        }
        
        
        $html = "\t<ul class='$listCssClass'>".PHP_EOL;
        
        $previousPageNum = $currentPage - 1;
        $nextPageNum = $currentPage + 1;
        
        $previousItem = $currentPage == 1 ? "<li class='$disabledCssClass'><span>$backLabel</span></li>" : "<li><a href='$targetUrlBase$previousPageNum'>Zurück</a></li>";
        $nextItem = $currentPage == $lastPageNum ? "<li class='$disabledCssClass'><span>$nextLabel</span></li>" : "<li><a href='$targetUrlBase$nextPageNum'>Weiter</a></li>";
        
        $html .= "\t\t".$previousItem.PHP_EOL;
        $html .= "\t\t<li><a href='$targetUrlBase"."1'>1</a></li>".PHP_EOL;

        if(($currentPage - $innerItemsCount) > 2) {
            
            if(($currentPage - $innerItemsCount) == 3) {
                $html .= "\t\t<li><a href='$targetUrlBase"."2'>2</a></li>";
            }
            else {
                $html .=  "\t\t<li><span>...</span></li>";
            }
            
            $html .= PHP_EOL;
            
        }
        
        $innerItemsHtml = "";
        
        for($i = $currentPage; $i > 1 && $i >= ($currentPage-$innerItemsCount); $i--) {
            
            if($i != $lastPageNum) {
                $innerItemsHtml = "\t\t<li><a href='$targetUrlBase"."$i'>$i</a></li>".PHP_EOL . $innerItemsHtml;
            }
            
        }
        
        for($i = $currentPage +1 ; $i < $lastPageNum && $i <= ($currentPage + $innerItemsCount); $i++) {
            
            $innerItemsHtml .= "\t\t<li><a href='$targetUrlBase"."$i'>$i</a></li>".PHP_EOL;
            
        }
        
        $html .= $innerItemsHtml;
        
        if(($currentPage + $innerItemsCount) < ($lastPageNum - 1)) {
            
            if(($currentPage + $innerItemsCount) == ($lastPageNum - 2)) {
                $html .= "\t\t<li><a href='$targetUrlBase".($lastPageNum - 1)."'>".($lastPageNum - 1)."</a></li>";
            }
            else {
                $html .=  "\t\t<li><span>...</span></li>";
            }
            
            $html .= PHP_EOL;
            
        }
        
        if($resultsCount > $itemsPerPage) {
            $html .= "\t\t<li><a href='$targetUrlBase$lastPageNum'>$lastPageNum</a></li>".PHP_EOL;
        }
        
        $html .= "\t\t".$nextItem.PHP_EOL;
        $html .= "\t</ul>".PHP_EOL."</nav>".PHP_EOL;
        
        $activePageMatch = '';
        
        preg_match("~<li><a.*>$currentPage</a></li>~", $html, $activePageMatch);
        
        $html = str_replace($activePageMatch, str_replace('<li>', "<li class='active'>", $activePageMatch), $html);
        
        return $navTag->Surround($html);
        
    }
    
    /**
     * Generates and prints the HTML code of this pagination.
     */
    public function EchoHtml() {
        echo $this->GenerateHtml();
    }
    
}