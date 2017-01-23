<?php
function myAutoload($classname) {
    $filename = str_replace('\\', '/', $classname);
    $filename = $filename . ".php";
  echo $filename . '<br/>';
    include_once($filename);
    
}
spl_autoload_register('myAutoload');
?>