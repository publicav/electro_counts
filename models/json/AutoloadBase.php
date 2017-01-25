<?php
function myAutoload( $classname ) {
    $filename = str_replace('\\', '/', $classname);
    $filename = 'models/json/' .  $filename . ".php";
//    echo $classname, ' ', $filename , '<br/>';
    include_once( $filename );
    
}
spl_autoload_register( 'myAutoload' );
?>