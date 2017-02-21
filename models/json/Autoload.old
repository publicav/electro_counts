<?php

//require_once __DIR__ . '/../../vendor/autoload.php';

function myAutoload( $classname ) {
    $filename = str_replace( '\\', '/', $classname );
    $path = $_SERVER['SCRIPT_FILENAME'];
    //    var_dump($path);
    $path = str_replace( '\\', '/', $path );
    $path = explode( '/', $path );
    $folder = array_pop( $path );
    $folder = array_pop( $path );
    if ( $folder == 'json' ) {
        $filename = $filename . ".php";
    } else {
        $filename = 'models/json/' . $filename . ".php";
    }
    if ( !file_exists( $filename ) ) {
        echo "Class -  $classname not found!";
        exit();
    }
    include_once $filename;

}

spl_autoload_register( 'myAutoload' );
