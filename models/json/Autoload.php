<?php
function myAutoload($classname) {
    $filename = str_replace('\\', '/', $classname);
    $filename = $filename . ".php";
//  echo $filename;
    include_once($filename);
    
}
spl_autoload_register('myAutoload');
?>