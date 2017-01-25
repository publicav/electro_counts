<?php
function myAutoload($classname) {
    $filename = str_replace('\\', '/', $classname);
    $filename = $filename . ".php";
    if( !file_exists( $filename ) ){
        echo "Class $classname not found!";
        exit();
    }
    include_once $filename;

}
spl_autoload_register('myAutoload');
?>