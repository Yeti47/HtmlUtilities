
<?php

spl_autoload_register('html_utilities_autoload_handler');

function html_utilities_autoload_handler($className) {
    
    include_once __DIR__."/$classname.php";
    
}
	
?>