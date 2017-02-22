<?php
try {
    //    include_once "models/json/Autoload.php";
    include_once 'vendor/autoload.php';
    include_once( "models/open.php" );
    include_once( "models/config.php" );
    include_once( "models/funclib.php" );

    $route = \Navigation\Route::init();
    $conroler = $route->getController();
    $action = $route->getAction();

    $contoller = new $conroler();
    $contoller->$action();

} catch ( Exception $e ) {
    die( $e->getMessage() );
}
