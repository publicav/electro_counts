<?php
mb_internal_encoding('UTF-8');
try {
    include_once "models/json/Autoload.php";
    include_once("models/open.php");
    include_once("models/config.php");
    include_once("models/funclib.php");

    $route = navigation\Route::init();
//    include_once $route->getModelPath();
    $conroler = 'controllers\ControllerMain';
    if ( $sid  != 0 ) $action = 'actionIndex'; else $action = 'actionBlank';
    $contoller = new $conroler();
    $contoller->$action( $sid );
}catch(Exception $e){
    die( $e->getMessage() );
}
