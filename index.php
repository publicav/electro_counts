<?php
mb_internal_encoding('UTF-8');
try {
    include_once "models/json/Autoload.php";
    include_once("models/open.php");
    include_once("models/config.php");
    include_once("models/funclib.php");

    $route = navigation\Route::init();
    $route->setAuthorization( $sid );
    $route->getController();
//    include_once $route->getModelPath();
    var_dump($route->getController());
    $conroler = $route->getController();
    if ( $sid  != 0 ) $action = 'actionIndex'; else $action = 'actionBlank';
    $contoller = new $conroler();
    $contoller->$action();
}catch(Exception $e){
    die( $e->getMessage() );
}
