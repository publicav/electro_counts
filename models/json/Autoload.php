<?php
function myAutoload($classname) {
    $filename = $classname . ".php";
    include_once($filename);
}
spl_autoload_register('myAutoload');
?>